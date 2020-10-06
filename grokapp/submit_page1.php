<!DOCTYPE html>
<html>
<body>

<?php
$command = escapeshellcmd('/usr/bin/env conda run -n polar python test.py');
$output = shell_exec($command);
?>

Accessed python version <?php echo $output; ?><br>
Form provided information <?php echo $_POST; ?>

</body>
</html>
