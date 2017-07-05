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
        Console::writeLine('6. Exit');
        Console::writeLine('------------------------------');
    }

    /**
     * Print all currency to screen
     */
    function printCurrencies()
    {
        $currencies = Currency::getCurrencies();

        for ($i = 0; $i < count($currencies); ++$i) {
            $currency = $currencies[$i];
            Console::writeLine(($i + 1) . ' - ' . $currency->getCode() . ' - ' . $currency->getCountryName());
        }
    }

    function afterLogin(){
        do{
            $this->printMenuCustomer();
            $choice = Console::readLine();

            switch ($choice){
                case 1:
                    break;
                case 1:
                    break;
                case 1:
                    break;
                case 1:
                    break;
            }
        }while(true);
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
            $this->afterLogin();
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
                        $this->customer = $customer;
                        Console::writeLine('Welcome back ' . $result->getId());

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
            $this->afterLogin();
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
        do {
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
        } while (true);
    }
}

//invoke main function, main function is where first call
$program = new Program();
$program->main();







