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
use Models\Constants;


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

    Log::warning('Print menu...',array());
}


do {

    //print to screen menu choice and wait input from user
    printMenuMain();
    $choice = Console::readLine();

    switch ($choice) {
        case Constants::MENU_MAIN_NEW_CUSTOMER:
            Console::writeLine('Hello new user');
            break;
        case Constants::MENU_MAIN_RETURNING_CUSTOMER:
            Console::writeLine('Welcome back');
            break;
        case Constants::MENU_MAIN_EXIT:
            Console::writeLine('Thanks for your visit. See you later');
            break;
        default:
            Console::writeLine('Please enter correct choice');
            break;
    }
} while (true);

$account = new Account();