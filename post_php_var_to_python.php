<?php


$hello = 'world';

// $output = shell_exec('app/http/Amazon_Price_Checker/price_checker.py 2>&1 | tee -a /tmp/mylog 2>/dev/null >/dev/null &');

$command = escapeshellcmd('app/http/Amazon_Price_Checker/price_checker.py');

$output = shell_exec($command);

echo $output; 


