<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 8:15 AM
 */
include '__autoload.php';
use Utils\Console;
use Utils\Log;
use Models\Account;
use Models\Constant;

echo '.................' . \Utils\CurrencyConverter::convert(22000, 'VND','USD');


/**
 * Print Menu Main to screen
 */
function printMenuMain()
{
    Console::writeLine('Welcome to E-Wallet System');
    Console::writeLine('1. I am a new customer');
    Console::writeLine('2. I am a returning customer');
    Console::writeLine('3. Exit');
    Console::writeLine('--------------------------');
}

/**
 * Create new wallet
 */
function register()
{
    Console::writeLine('Hello new user');
}

/**
 * Login to exist wallet
 */
function login(){
    Console::writeLine('Welcome back');
}

/**
 * Exit this program
 */
function quit(){
    exit('Thanks for your visit. See you later');
}


do {
    //print to screen menu choice and wait input from user
    printMenuMain();
    $choice = Console::readLine();

    switch ($choice) {
        case Constant::MENU_MAIN_NEW_CUSTOMER:
            register();
            break;
        case Constant::MENU_MAIN_RETURNING_CUSTOMER:
            login();
            break;
        case Constant::MENU_MAIN_EXIT:
            quit();
            break;
        default:
            Console::writeLine('Please enter correct choice');
            break;
    }
} while (true);

$account = new Account();