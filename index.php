#!/usr/bin/env php
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
use Models\Currency;
use Models\Constant;
use Models\Customer;

class Program
{
    var $customers = array();
    var $customer = null;

    /**
     * Print Menu Main to screen
     */
    function printMenuMain()
    {
        Console::writeLine('------------------------------');
        Console::writeLine('Welcome to E-Wallet System');
        Console::writeLine('1. I am a new customer');
        Console::writeLine('2. I am a returning customer');
        Console::writeLine('3. Exit');
        Console::writeLine('------------------------------');
    }

    /**
     * Print Menu Customer to screen
     */
    function printMenuCustomer()
    {
        Console::writeLine('------------------------------');
        Console::writeLine($this->customer->getId() . ' welcome to E-Wallet System');
        Console::writeLine('1. Get list account');
        Console::writeLine('2. Transfer your money');
        Console::writeLine('3. Withdraw your money');
        Console::writeLine('4. Deposit your money');
        Console::writeLine('5. Add new an account');
        Console::writeLine('6. Change Primary account');
        Console::writeLine('7. Freeze/UnFreeze account');
        Console::writeLine('8. Logout');
        Console::writeLine('------------------------------');
    }


    /**
     * Control panel for customer
     * Customer can do any things with their account option
     */
    function customerControlPanel()
    {
        Console::loop(function () {
            $this->printMenuCustomer();
            $choice = Console::readLine();

            switch ($choice) {
                case Constant::MENU_CUSTOMER_GET_LIST_ACCOUNT:
                    $this->customer->printAccounts();
                    Log::info('Get list accounts and balance of the customer ' . $this->customer->getId());
                    break;
                case Constant::MENU_CUSTOMER_TRANSFER:
                    $this->transfer();
                    break;
                case Constant::MENU_CUSTOMER_WITHDRAW:
                    $this->withdraw();
                    break;
                case Constant::MENU_CUSTOMER_DEPOSIT:
                    $this->deposit();
                    break;
                case Constant::MENU_CUSTOMER_ADD_ACCOUNT:
                    $this->addAccount();
                    break;
                case Constant::MENU_CUSTOMER_CHANGE_PRIMARY_ACCOUNT:
                    $this->changePrimaryAccount();
                    break;
                case Constant::MENU_CUSTOMER_FREEZE_ACCOUNT:
                    $this->freezeAccount();
                    break;
                case Constant::MENU_CUSTOMER_LOGOUT:
                    Log::info('Customer ' . $this->customer->getId() . ' logout');
                    $this->customer = null;//clear session
                    Console::writeLine('Goodbye !!!');
                    return true;
                default:
                    Console::writeLine('Please enter correct choice: ');
                    break;
            }
            return false;
        });
    }

    /**
     * Transfer money
     */
    function transfer()
    {
        Console::writeLine('Do you want transfer money ?');
        $this->customer->printAccounts();

        //Choose transfer account
        Console::writeLine('Select account transfer: ');
        $accountTransfer = $this->customer->chooseAccount();

        if (!($accountTransfer instanceof Account))
            return;

        //Choose receiving account
        Console::writeLine('Select the receive account: ');
        $accountReceive = $this->customer->chooseAccount();

        if (!($accountReceive instanceof Account))
            return;

        //Cannot transfer money between freeze account
        if ($accountTransfer->isFreeze() || $accountReceive->isFreeze()) {
            Console::writeLine('One of the accounts has been frozen');
        } else {

            //Cannot transfer money same one account
            if ($accountTransfer->getId() == $accountReceive->getId()) {
                Console::writeLine('You do not transfer money between same one account');
            } else {
                //input amount user want transfer
                Console::writeLine('Let enter your amount you want send: ');
                $amount = $this->customer->inputAmount($accountTransfer);

                if (is_double($amount)) {
                    $this->customer->transfer($accountTransfer, $accountReceive, $amount);
                }
            }
        }
    }

    /**
     * Withdraw
     */
    function withdraw()
    {
        Console::writeLine('Do you want withdraw money ?');
        $this->customer->printAccounts();

        // Get account which user want to withdraw
        $account = $this->customer->chooseAccount();

        if ($account instanceof Account) {

            //check account has freeze
            if ($account->isFreeze()) {
                Console::writeLine('Notice: this account has been freeze, you must unfreeze to do this action');
            } else {

                //check is virtual currency
                if ($account->getCurrency()->isVirtualCurrency()) {
                    Console::writeLine('Notice: virtual account cannot withdraw money');
                } else {
                    //Get amount from user
                    $amount = $this->customer->inputAmount($account);

                    //Do withdraw to account
                    if (is_double($amount)) {
                        $this->customer->withdraw($account, $amount);
                    }
                }
            }
        }
    }

    /**
     * Deposit
     */
    function deposit()
    {
        Console::writeLine('Do you want deposit money ?');
        $this->customer->printAccounts();

        // Get account which user want to deposit
        $account = $this->customer->chooseAccount();

        if ($account instanceof Account) {

            //check account has freeze
            if ($account->isFreeze()) {
                Console::writeLine('Notice: this account has been freeze, you must unfreeze to do this action');
            } else {
                //Get amount from user
                $amount = $this->customer->inputAmount($account);

                //Do deposit to account
                if (is_double($amount)) {
                    $this->customer->deposit($account, $amount);
                }
            }
        }
    }

    /**
     * Add new an account
     */
    function addAccount()
    {
        Console::writeLine('Do you want create an new account ?');

        //Get name from keyboard
        $name = Console::loop(function () {
            Console::writeLine('Enter your account name: ');
            $name = trim(Console::readLine());

            //Validate name
            if (strlen($name) <= 0) {
                Console::writeLine('Notice: your account name cannot be empty');
                return false;
            }
            return $name;
        });

        //Get currency
        Currency::printCurrencies();
        $currency = Console::loop(function () {
            Console::writeLine('Enter your currency code (reference currencies list above): ');
            $code = trim(Console::readLine());

            //Validate code
            if (empty($code)) {
                Console::writeLine('Notice: your currency code cannot be empty');
                return false;
            } elseif (strlen($code) != 3) {
                Console::writeLine('Notice: your currency code must be length 3 character');
                return false;
            }

            //find currency object by input code
            $currency = Currency::getCurrencyByCode(strtoupper($code));
            if (!$currency) {
                Console::writeLine('Notice: your currency code do not match any code in currencies list above');
            }
            return $currency;
        });

        //create an account with input above
        $account = new Account();
        $account->setId(\Models\SequenceAccount::getSequence());
        $account->setBalance(0.0);
        $account->setCurrency($currency);
        $account->setName($name);

        //store to array list
        $this->customer->addAccounts($account);

        Console::writeLine('Your account created, here is info: ' . $account);

        Log::info('Add new account ' . $account->getId() . ' for customer ' . $this->customer->getId());
    }


    /**
     * Freeze/UnFreeze Account
     */
    function freezeAccount()
    {
        Console::writeLine('Do you want freeze/unfreeze account ?');
        $this->customer->printAccounts();

        // Get account which user want to freeze/unfreeze
        $account = $this->customer->chooseAccount();

        if ($account instanceof Account) {
            $this->customer->freezeOrUnFreeze($account);
        }
    }

    /**
     * Change Primary Account
     * Note: except virtual account
     */
    function changePrimaryAccount()
    {
        Console::writeLine('Do you want change primary account ?');
        $this->customer->printAccounts();

        // Get account which user want to change primary account
        $account = $this->customer->chooseAccount();


        if ($account instanceof Account) {
            $this->customer->changePrimaryAccount($account);
        }
    }

    /**
     * Create new wallet
     */
    function register()
    {
        Console::writeLine('Hello new user let choose your unique id (or you can type --back to back to previous screen): ');

        //when all things are correct flag will be false value to end this loop
        $flag = true;
        do {
            $id = trim(Console::readLine());

            //Just process when input from user is correct. Else notice to they re-enter
            if (strlen($id) > 0) {
                if ($id == '--back') {
                    break;
                } else {
                    //create new customer
                    $customer = Customer::getDefault($id);

                    //Check customer id is unique
                    if ($customer->isUnique($this->customers)) {
                        //store new customer to array
                        $this->customers[] = $customer;
                        $this->customer = $customer;

                        //write this event to logs folder
                        Log::info('Create new customer with id ' . $customer->getId());

                        //break this loop
                        $flag = false;
                    } else {
                        Console::writeLine("Your id already existing, please choose new unique id (or you can type --back to back to previous screen): ");
                    }
                }

            } else {
                Console::writeLine("Id can not be empty, please choose new unique id (or you can type --back to back to previous screen): ");
            }
        } while ($flag);


        //if user created we are going to next screen
        if (!$flag) {
            $this->customerControlPanel();
        }

    }

    /**
     * Login to exist wallet
     */
    function login()
    {
        Console::writeLine('Welcome back guest, tell me your id (or you can type --back to back to previous screen): ');

        $flag = true;
        do {
            $id = trim(Console::readLine());

            //Just process when input from user is correct. Else notice to they re-enter
            if (strlen($id) > 0) {
                if ($id == '--back') {
                    break;
                } else {
                    $customer = new Customer();
                    $result = $customer->login($id, $this->customers);

                    //if return data type is Customer ~> Login success
                    if ($result instanceof Customer) {
                        $this->customer = $result;
                        Console::writeLine('Welcome back ' . $result->getId());
                        Log::info('Customer ' . $customer->getId() . ' login');
                        $flag = false;
                    } else {
                        Console::writeLine('Login unsuccessfully, may be incorrect id, please enter your id again (or you can type --back to back to previous screen): ');
                    }
                }
            } else {
                Console::writeLine("Id can not be empty, please enter your id (or you can type --back to back to previous screen): ");
            }
        } while ($flag);

        if (!$flag) {
            $this->customerControlPanel();
        }

    }

    /**
     * Exit this program
     */
    function quit()
    {
        exit('Thanks for your visit. See you later');
    }

    /**
     * All code write in here will run first
     */
    public function main()
    {
        Console::loop(function () {
            //print to screen menu choice and wait input from user
            $this->printMenuMain();
            $choice = Console::readLine();

            switch ($choice) {
                case Constant::MENU_MAIN_NEW_CUSTOMER:
                    $this->register();
                    break;
                case Constant::MENU_MAIN_RETURNING_CUSTOMER:
                    $this->login();
                    break;
                case Constant::MENU_MAIN_EXIT:
                    $this->quit();
                    break;
                default:
                    Console::writeLine('Please enter correct choice:');
                    break;
            }
            return false;
        });
    }
}

//invoke main function, main function is where first call
$program = new Program();
$program->main();









