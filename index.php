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

    function transfer()
    {
    }

    function withdraw()
    {
    }

    function deposit()
    {
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

        //Console::writeLine('Your currency info: ' . $currency->getCode() . ' - ' . $currency->getCountryName());

        //create an account with input above
        $account = new Account();
        $account->setId(\Models\SequenceAccount::getSequence());
        $account->setBalance(0.0);
        $account->setCurrency($currency);
        $account->setName($name);

        //store to array list
        $this->customer->addAccounts($account);

        Console::writeLine('Your account created, here is info: ' . $account);
    }


    /**
     * Freeze/UnFreeze Account
     */
    function freezeAccount()
    {
        Console::writeLine('Do you want change freeze/unfreeze account ?');
        $this->customer->printAccounts();

        Console::loop(function () {
            Console::writeLine('Enter your account id you want to freeze/unfreeze (or you can type --back to back to previous screen): ');
            $id = trim(Console::readLine());

            if (!empty($id)) {
                //use regex to check data type is integer
                if (preg_match('/^[-+]?\d+$/', $id)) {
                    //find account by id
                    $account = $this->customer->getAccountById($id);
                    //check account exist
                    if ($account) {
                        if ($account->getCurrency()->isVirtualCurrency()) {
                            Console::writeLine('Notice: cannot freeze this account');
                        } else {
                            $account->setFreeze(!$account->isFreeze());//reverse, if account is freeze ~> unfreeze or else
                            Console::writeLine('Now account ' . $id . ' is ' . ($account->isFreeze() ? 'freeze' : 'unfreeze'));
                            return true;
                        }

                    } else {
                        Console::writeLine('Notice: account not found, maybe you enter incorrect account id');
                    }
                } else {
                    Console::writeLine('Notice: your account id must be integer number');
                }
            } else {
                Console::writeLine('Notice: your account id cannot be empty');
            }

            return false;
        });


    }

    /**
     * Change Primary Account
     * Note: except virtual account
     */
    function changePrimaryAccount()
    {
        Console::writeLine('Do you want change primary account ?');
        $this->customer->printAccounts();


        Console::loop(function () {
            Console::writeLine('Enter your account id you want to set primary (or you can type --back to back to previous screen): ');
            $id = trim(Console::readLine());

            if (!empty($id)) {
                //with input --back we support user back to previous screen
                if ($id == '--back')
                    return true;

                //use regex to check data type is integer
                if (preg_match('/^[-+]?\d+$/', $id)) {
                    //find account by id
                    $account = $this->customer->getAccountById($id);
                    //check account exist
                    if ($account) {
                        $defaultAccount = $this->customer->getDefaultAccount();
                        if ($defaultAccount->getId() == $account->getId()) {
                            Console::writeLine('Notice: this account is identical to the old primary account');
                        } else if ($account->getCurrency()->isVirtualCurrency()) {
                            Console::writeLine('Notice: virtual account cannot set to primary account');
                        } else {
                            $this->customer->setDefaultAccount($account);
                            Console::writeLine('Now account ' . $id . ' is primary account');
                            return true;
                        }
                    } else {
                        Console::writeLine('Notice: account not found, maybe you enter incorrect account id');
                    }
                } else {
                    Console::writeLine('Notice: your account id must be integer number');
                }
            } else {
                Console::writeLine('Notice: your account id cannot be empty');
            }
            return false;
        });
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







