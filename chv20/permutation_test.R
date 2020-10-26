
library("tidyverse")
library("permute")
library("pander")
library("estimatr")
library("reshape")

setwd("~/Documents/Study/DPhil/Main/Code/coppock_et_al2020")
set.seed(634)

data <- read_rds("reprod/exps.rds")


# Design permutation test
# Two variants: block randomised over wave, and standard shuffle

filter_data <- function(data, treatment_filter, dv, covs) {
  df <- data %>% filter(assignment %in% treatment_filter) %>% drop_na(., c(dv, covs))
  return(df)
}

# New variables include:
# age, race, income3, region, newsint, track_pre

fit_model <- function(df, dv, model = estimatr::lm_robust) {
  # TODO: Parameterise to allow for alternative models
  formula <- formula(
    paste0(
      dv,
      #"~ ad_id_fac + ad_id_fac*pid_7_pre + ad_id_fac*ideo5_pre + ad_id_fac*female_pre"
      paste0("~ ad_id_fac + ad_id_fac*pid_7_pre + ad_id_fac*ideo5_pre + ad_id_fac*female_pre + ad_id_fac*age + ad_id_fac*race",
             "+ ad_id_fac+income3 + ad_id_fac*region + ad_id_fac*newsint + ad_id_fac*track_pre"
      )
    )
  )
  fit <- model(formula, weights = weights, data = df)
  return(fit)
}

make_predictions <- function(df, dv, covs, fitted_model, treatment_filter) {

  # Params used throughout
  n_treats <- length(unique(df$ad_id_fac))
  step <- dim(df)[1]

  # Construct prediction frame `test`
  test <- df[,covs]
  for (i in 1:(n_treats-1)) {
    test <- rbind(test, df[,covs])
  }
  test$ad_id_fac <- sort(rep(unique(df$ad_id_fac), step))
  test$yhat <- predict(fitted_model, test)

  # Reshape prediction frame to view predictions side-by-side
  test.predict <- data.frame(matrix(nrow=step, ncol=n_treats))
  colnames(test.predict) <- sapply(
    unique(df$ad_id_fac), function(x){paste0('treatment ', x)}
  )
  i <- 1
  for (t in unique(df$ad_id_fac)) {
    test.predict[,paste0('treatment ', t)] <- test$yhat[i:(i-1+step)]
    i <- i + step
  }

  # Find best ad per-observation
  rank_optima <- function(x){
    ranking <- ifelse(
      str_extract(treatment_filter, "[A-z]+")=="Anti",
      min, max)
    optim_ind <- which(x==ranking(x))
    out_str <- colnames(test.predict)[optim_ind]
    return(out_str)
  }
  best_ad <- apply(
    X = test.predict,
    FUN = rank_optima,
    MARGIN = 1
  )

  # Simulate outcome under Maximal Allocation
  ma_df <- df[,covs]
  ma_df$ad_id_fac <- sapply(best_ad, function(x){str_extract(x, "[0-9]+")}) %>% unlist()
  ma_df[[dv]] <- predict(fitted_model, ma_df)

  # Compare Maximal Allocation to Random Allocation
  rand_out <- mean(df[[dv]])
  ma_out <- mean(ma_df[[dv]])
  pred_improv <- ifelse(
    str_extract(treatment_filter, "[A-z]+")=="Anti",
    (rand_out - ma_out)/rand_out,
    (ma_out - rand_out)/rand_out
  )

  # Reallocation Table
  rand_ad <- df$ad_id_fac %>%
    sapply(., function(x){paste0('treatment ', x)}) %>%
    as.factor()
  ma_ad <- factor(best_ad, levels(rand_ad))
  alloc_df <- data.frame(
    Random = rand_ad,
    Maximal = ma_ad
  )
  alloc_table <- do.call(
    "rbind", lapply(alloc_df, function(x) table(x, useNA = "ifany")))

  # Return list of
  return(
    list(
      Objective = treatment_filter,
      Observations = step,
      Allocation = alloc_table,
      Improvement = pred_improv,
      "Base Outcome" = rand_out,
      "Predicted Outcome" = ma_out,
      "Simulated Data" = ma_df
    )
  )
}

permute_test <- function(data, dv, covs, perm_col, treatment_filter, n_permutations) {
  df <- filter_data(data, treatment_filter, dv, covs)
  fitted_model <- fit_model(df, dv)

  # First derive unpermuted estimate
  no_permute <- make_predictions(df, dv, covs, fitted_model, treatment_filter)

  # Permute using the shuffle function
  null_dist <- numeric(length=n_permutations)
  perm_df <- df # Make a copy for continuous modification
  N <- nrow(df)
  for (i in seq_len(length(null_dist) - 1)) {
    perm <- shuffle(N)
    perm_df[[perm_col]] <- df[[perm_col]][perm] # Shuffle permuting column
    fitted_model <- fit_model(perm_df, dv) # Fit a model to predict the best ad
    null_dist[i] <- make_predictions(
      perm_df, dv, covs, fitted_model, treatment_filter)$Improvement
  }
  return(list(no_permute, null_dist))
}

plot_permute <- function(p_test) {
  ggplot(data.frame(x=p_test[[2]]), aes(x=x)) +
#    geom_histogram(alpha=0.5) +
    geom_density(alpha=0.8, color='black') +
    geom_vline(xintercept=p_test[[1]]$Improvement, color='red')
}


# PARAMETERS
covs <- c('pid_7_pre', 'ideo5_pre', 'female_pre', 'age', 'race', 'income3', 'region', 'newsint', 'track_pre')

# Speed Test
pmt <- proc.time()
p_test <- permute_test(data, "favorDT_rev", covs, "ad_id_fac", "Anti Trump", 1)
proc.time() - pmt

# Test Run
p_test <- permute_test(data, "favorDT_rev", covs, "ad_id_fac", "Anti Trump", 10)
plot_permute(p_test)
table(p_test[[1]]$Improvement > p_test[[2]]) # Not significant


p_test <- permute_test(data, "favorDT_rev", covs, "ad_id_fac", "Anti Trump", 30000)
plot_permute(p_test)
table(p_test[[1]]$Improvement > p_test[[2]]) # Not significant

# Looking at covariates
df <- filter_data(data, "Anti Trump", "favorDT_rev", covs)
model1 <- fit_model(df, "favorDT_rev")
model1_summary <- summary(model1)
m1_coefs <- model1_summary$coefficients %>% as.data.frame()

temp <- m1_coefs[m1_coefs$`Pr(>|t|)`<0.3, ]
temp$Coefficient <- ordered(rownames(temp), levels=rownames(temp[with(temp, order(temp$Estimate)),]))
temp$Interaction <- sapply(temp$Coefficient, function(x){ifelse(grepl(":", x), "Interaction", "Non-Interaction")})
ggplot(data=temp, aes(y=Coefficient, x=Estimate, color=Interaction)) +
  geom_point(stat="identity") + geom_vline(xintercept = 0, linetype="solid", alpha=0.6) +
  geom_errorbarh(aes(xmin = `CI Lower`, xmax = `CI Upper`)) + ggtitle("Coefplot, y=Trump Favorability")
