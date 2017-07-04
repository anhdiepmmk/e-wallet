<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 8:15 AM
 */
include 'autoload.php';

//print to screen menu choice
echo 'Welcome to E-Wallet System' . PHP_EOL;
echo '1. I am a new customer' . PHP_EOL;
echo '2. I am a returning customer' . PHP_EOL;
echo '3. Exit' . PHP_EOL;
echo '--------------------------' . PHP_EOL;

$choice = \Utils\Console::readLine();

$account = new \Models\Account();