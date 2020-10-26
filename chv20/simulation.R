
library("tidyverse")
library("pander")
library("estimatr")

setwd("~/Documents/Study/DPhil/Main/Code/coppock_et_al2020")

data <- read_rds("reprod/exps.rds")


# ~~ COLUMN LEGEND ~~ #
#
# wave - NUM: Waves 2-30, 1000 each
# date - DATE: Same info as wave
# election_phase - CHAR: 22000 General, 12000 Primary
# pid_3_pre - CHAR: Party ID: Republican, Independent, Democrat
# pid_7_pre - NUM: Party ID 1-7 scale, Dem 1-3 Ind 4 Rep 5-7
# ideo5_pre - NUM: Ideology 1-5 scale, likely L-R scale 1 Left
# female_pre - NUM: Dummy Female 1
# battleground NUM: Dummy Battleground State 1
# assignment FAC: Treatment assignment, 8 treatments 1 control
# ad_id: NUM: numeric id, 51 unique,
# ad_id_fac: FAC: same as above, dtype FACTOR
# ad_title: CHAR: ad title
# ad_valence: CHAR: corresponds to assignment, save Two Ads
# ad_sponsor: CHAR: sponsor of ad, 12 unique values
# manip: NUM: Unclear, TODO: refer to paper
# favorDT_rev: NUM: Donald Trump rating (5-point)
# favorHC_rev: NUM: Hillary Clinton rating
# favorBS_rev: NUM: Bernie Sanders rating
# favorJK_rev: NUM: John Kasich rating
# favorTC_rev: NUM: Ted Cruz rating
# general_vote_HC: NUM: Dummy will vote Hillary in general election
# general_vote_DT: NUM: Dummy will vote Donald in general election
# weights: NUM: unsure TODO: refer to paper

# ~~ OUTCOME ~~
#
# 51 different ads tested, ranging from 1344 to 189 per ad
# No pre-treatment level
# We can do this one model per outcome
# Most models include Donald Trump
# Test number of ads per assignment category

data %>%
  group_by(assignment) %>%
  summarise(length(unique(ad_id)))

# |  assignment  | length(unique(ad_id)) |
# |:------------:|:---------------------:|
# |   Control    |           1           |
# | Pro Clinton  |           6           |
# | Anti Clinton |          11           |
# |  Pro Trump   |           3           |
# |  Anti Trump  |          24           |
# |   Pro Cruz   |           2           |
# |  Pro Kasich  |           1           |
# | Pro Sanders  |           2           |
# |   Two Ads    |           1           |

# Use only Clinton and Trump ads, focus first on Anti-

# treatment_filter <- c("Pro Clinton", "Anti Clinton", "Pro Trump", "Anti Trump")
# TODO: Parameterise per-filter
test_treatments <- function(treatment_filter, data, dv) {
  df <- data %>% filter(assignment %in% treatment_filter) %>% drop_na(., dv)
  # Fitting the model with favorHC_rev as outcome
  formula <- formula(
    paste0(
      dv,
      "~ ad_id_fac + ad_id_fac*pid_7_pre + ad_id_fac*ideo5_pre + ad_id_fac*female_pre"
    )
  )
  model1 <- lm_robust(formula, weights=weights, data = df)

  # Construct prediction frame `test`
  covs <- c('pid_7_pre', 'ideo5_pre', 'female_pre')
  n_treats <- length(unique(df$ad_id_fac))
  step <- dim(df)[1]
  test <- df[,covs]
  for (i in 1:(n_treats-1)) {
    test <- rbind(test, df[,covs])
  }
  test$ad_id_fac <- sort(rep(unique(df$ad_id_fac), step))
  test$yhat <- predict(model1, test)

  # Reform prediction frame to view predictions side-by-side
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
    ranking <- ifelse(str_extract(treatment_filter, "[A-z]+")=="Anti", min, max)
    optim_ind <- which(x==ranking(x))
    out_str <- colnames(test.predict)[optim_ind]
    return(out_str)
  }

  best_ad <- apply(
    X = test.predict,
    FUN = rank_optima,
    MARGIN = 1
  )

  # Find average outcome under random allocation
  rand_out <- mean(df[[dv]])
  # Find average outcome under maximal allocation
  ma_df <- df[,covs]
  ma_df$ad_id_fac <- sapply(best_ad, function(x){str_extract(x, "[0-9]+")})
  ma_df[[dv]] <- predict(model1, ma_df)
  ma_out <- mean(ma_df[[dv]])
  # Calculated predicted improvement
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

test_treatments("Pro Trump", data, "favorDT_rev")[1:6] %>% pander()
test_treatments("Anti Trump", data, "favorDT_rev")[1:6] %>% pander()
test_treatments("Pro Clinton", data, "favorHC_rev")[1:6] %>% pander()
test_treatments("Anti Clinton", data, "favorHC_rev")[1:6] %>% pander()
