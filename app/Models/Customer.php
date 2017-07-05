<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 10:26 AM
 */

namespace Models;


use Utils\Console;
use Utils\CurrencyConverter;
use Utils\Log;

class Customer
{
    private $id;
    private $defaultAccount;
    private $accounts = array();

    /**
     * Get default Customer
     * @param $id
     * @return Customer
     */
    public static function getDefault($id)
    {
        $customer = new Customer();

        //init virtual account
        $virtualAccount = new Account();
        $virtualAccount->setId(SequenceAccount::getSequence());
        $virtualAccount->setName('Credits');
        $virtualAccount->setCurrency(Currency::getVirtualCurrency());
        $virtualAccount->setBalance(0.0);

        //init usd account
        $usdAccount = new Account();
        $usdAccount->setId(SequenceAccount::getSequence());
        $usdAccount->setName('United States Dollar');
        $usdAccount->setCurrency(Currency::getCurrencyByCode('USD'));
        $usdAccount->setBalance(0.0);

        //binding data to customer object
        $customer->setId($id);
        $customer->addAccounts($virtualAccount);
        $customer->addAccounts($usdAccount);
        $customer->setDefaultAccount($usdAccount);

        return $customer;
    }

    /**
     * Print all account to screen
     */
    public function printAccounts()
    {
        Console::writeLine('You have ' . count($this->accounts) . ' account: ');
        for ($i = 0; $i < count($this->accounts); ++$i) {
            $account = $this->accounts[$i];
            Console::write($account->getId() .
                ' - ' . $account->getName() .
                ' - ' . $account->getBalance() .
                ' ' . $account->getCurrency()->getCode());

            if ($account->isFreeze()) {
                Console::write(' (freeze)');
            }

            //if account is default account will break line and print text notice for user it is primary account
            if ($account->getId() == $this->defaultAccount->getId()) {
                Console::writeLine(' (Primary account)');
            } else {
                Console::writeLine('');
            }
        }
    }

    /**
     * Help user choose account by account id from keyboard
     * @return bool if user input --back command, account if user input correct amount
     */
    public function chooseAccount()
    {
        // Get account which user want to get
        $account = Console::loop(function () {
            Console::writeLine('Enter your account id you want to do this action (or you can type --back to back to previous screen): ');
            $id = trim(Console::readLine());

            if (!empty($id)) {
                //with input --back we support user back to previous screen
                if ($id == '--back')
                    return true;

                //use regex to check data type is integer
                if (preg_match('/^[-+]?\d+$/', $id)) {

                    //find account by id
                    $account = $this->getAccountById($id);

                    //check account exist
                    if ($account) {
                        return $account;
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

        return $account;
    }

    /**
     *
     * Get Amount from keyboard
     * @param $account
     * @return bool if user input --back command, double if user input correct amount
     */
    public function inputAmount($account)
    {
        $amount = Console::loop(function ($account) {
            //Get input from keyboard
            Console::writeLine('Please enter the number of the ' . $account->getCurrency()->getCode() . ' : ');
            $amount = trim(Console::readLine());

            //validate
            if (!empty($amount)) {
                //with input --back we support user back to previous screen
                if ($amount == '--back')
                    return true;

                //make sure it is number
                if (is_numeric($amount)) {
                    //make sure amount is double data type
                    $amount = (double)$amount;

                    //amount need larger than 0
                    if ($amount > 0) {
                        return $amount;
                    } else {
                        Console::writeLine('Notice: your amount must be larger than 0');
                    }
                } else {
                    Console::writeLine('Notice: your amount must be numeric');
                }
            } else {
                Console::writeLine('Notice: your amount cannot be empty');
            }
            return false;
        }, $account);
        return $amount;
    }

    /**
     * WithDrawl amount from account
     * @param $account
     * @param $amount
     */
    public function withdraw($account, $amount)
    {
        if ($amount > $account->getBalance()) {
            Console::writeLine('Notice: your account not enough money');
            Log::info('Customer ' . $this->getId() . ' withdraw ' . $amount . ' ' . $account->getCurrency()->getCode() . ' from account ' . $account->getId() . ' but not enough money');
        } else {
            //update balance
            $newBalance = $account->getBalance() - $amount;
            $account->setBalance($newBalance);
            Console::writeLine('You did withdraw ' . $amount . ' ' . $account->getCurrency()->getCode() . ' to account ' . $account->getId());
            Log::info('Customer ' . $this->getId() . ' withdraw ' . $amount . ' ' . $account->getCurrency()->getCode() . ' from account ' . $account->getId());
        }
    }

    /**
     * Deposit amount to account
     * @param $account
     * @param $amount
     */
    public function deposit($account, $amount)
    {
        //update balance
        $newBalance = $account->getBalance() + $amount;
        $account->setBalance($newBalance);
        Console::writeLine('You did deposit ' . $amount . ' ' . $account->getCurrency()->getCode() . ' to account ' . $account->getId());
        Log::info('Customer ' . $this->getId() . ' deposit ' . $amount . ' ' . $account->getCurrency()->getCode() . ' to account ' . $account->getId());
    }

    /**
     * Freeze or unfreeze account
     * @param $account
     */
    public function freezeOrUnFreeze($account)
    {
        if ($account->getCurrency()->isVirtualCurrency()) {
            Console::writeLine('Notice: cannot freeze this account');
            Log::info('Customer freeze virtual account but not permit');
        } else {
            $account->setFreeze(!$account->isFreeze());//reverse, if account is freeze ~> unfreeze or else
            Console::writeLine('Now account ' . $account->getId() . ' is ' . ($account->isFreeze() ? 'freeze' : 'unfreeze'));
            Log::info(($account->isFreeze() ? 'Freeze ' : 'Unfreeze ') . $account->getId() . ' of the customer ' . $this->getId());
        }
    }

    /**
     * Change Primary Account
     * @param $account
     */
    public function changePrimaryAccount($account)
    {
        /*virtual account and old primary account cannot set to primary account*/
        $defaultAccount = $this->getDefaultAccount();
        if ($defaultAccount->getId() == $account->getId()) {
            Console::writeLine('Notice: this account is identical to the old primary account');
        } else if ($account->getCurrency()->isVirtualCurrency()) {
            Console::writeLine('Notice: virtual account cannot set to primary account');
        } else {
            $this->setDefaultAccount($account);
            Console::writeLine('Now account ' . $account->getId() . ' is primary account');
            Log::info('Set account ' . $account->getId() . ' to be primary account for customer ' . $this->getId());
        }
    }

    /**
     * Transfer money
     * @param $fromAccount
     * @param $toAccount
     * @param $amount
     */
    public function transfer($fromAccount, $toAccount, $amount)
    {
        if ($amount > $fromAccount->getBalance()) {
            Console::writeLine('Your sender account not enough money');
            Log::info('Customer ' . $this->getId() . ' transfer ' . $amount . ' ' . $fromAccount->getCurrency()->getCode() . ' from account ' . $fromAccount->getId() . ' to another account but not enough money');
        } else {
            //1 credit = 1 usd
            $fromCurrency = ($fromAccount->getCurrency()->isVirtualCurrency()) ? 'USD' : $fromAccount->getCurrency()->getCode();
            $toCurrency = ($toAccount->getCurrency()->isVirtualCurrency()) ? 'USD' : $toAccount->getCurrency()->getCode();


            //if same currency code
            if($fromCurrency == $toCurrency){
                // - money
                $newFromBalance = $fromAccount->getBalance() - $amount;
                $fromAccount->setBalance($newFromBalance);

                // + money
                $newToBalance = $toAccount->getBalance() + $amount;
                $toAccount->setBalance($newToBalance);

                Log::info('Customer ' . $this->getId() . ' transfer ' . $amount . ' ' . $fromAccount->getCurrency()->getCode() . ' from account ' . $fromAccount->getId() . ' to account ' . $toAccount->getId() . ' successfully');
                Console::writeLine('You have successfully transferred money');
            }else{
                Console::writeLine('Connect to world bank to get currency rate...');
                $convertAmount = CurrencyConverter::convert($amount, $fromCurrency, $toCurrency);

                if($convertAmount > -1){
                    // - money
                    $newFromBalance = $fromAccount->getBalance() - $amount;
                    $fromAccount->setBalance($newFromBalance);

                    // + money
                    $newToBalance = $toAccount->getBalance() + (double)$convertAmount;
                    $toAccount->setBalance($newToBalance);

                    Log::info('Customer ' . $this->getId() . ' transfer ' . $amount . ' ' . $fromAccount->getCurrency()->getCode() . ' from account ' . $fromAccount->getId() . ' to account ' . $toAccount->getId() . ' successfully');
                    Console::writeLine('You have successfully transferred money');
                }else{
                    Log::info('Customer ' . $this->getId() . ' transfer ' . $amount . ' ' . $fromAccount->getCurrency()->getCode() . ' from account ' . $fromAccount->getId() . ' to account ' . $toAccount->getId() . ' error');
                    Console::writeLine('Cannot connect to world bank please try again late.');
                }
            }
        }
    }

    /**
     * Do login
     * @param $id
     * @param array $customers
     * @return bool
     */
    public function login($id, array $customers)
    {
        if (count($customers) > 0) {
            for ($i = 0; $i < count($customers); ++$i) {
                $item = $customers[$i];
                if ($id == $item->id) {
                    return $item;
                }
            }
        }
        return false;
    }

    /**
     * Check customer unique by id
     * @param array $customers
     * @return bool
     */
    public function isUnique(array $customers)
    {
        //if $customers bigger than 0 ~> need check. else just return true
        if (count($customers) > 0) {
            for ($i = 0; $i < count($customers); ++$i) {
                $item = $customers[$i];
                if ($this->id == $item->id) {
                    return false;
                }
            }
        }

        return true;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDefaultAccount()
    {
        return $this->defaultAccount;
    }

    /**
     * @param mixed $defaultAccount
     */
    public function setDefaultAccount($defaultAccount)
    {
        $this->defaultAccount = $defaultAccount;
    }

    /**
     * @return array
     */
    public function getAccounts()
    {
        return $this->accounts;
    }


    /**
     * Find account by id
     * @param $id
     * @return bool
     */
    public function getAccountById($id)
    {
        $accounts = $this->accounts;
        for ($i = 0; $i < count($this->accounts); ++$i) {
            $account = $this->accounts[$i];
            if ($id == $account->getId()) {
                return $account;
            }
        }
        return false;
    }

    /**
     * Add account to array
     * @param array $account
     */
    public function addAccounts($account)
    {
        $this->accounts[] = $account;
    }


}