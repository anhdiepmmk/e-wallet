<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 10:26 AM
 */

namespace Models;


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
    public static function getDefault($id){
        $customer = new Customer();

        //init virtual account
        $virtualAccount = new Account();
        $virtualAccount->setId(SequenceAccount::getSequence());
        $virtualAccount->setName('Credits');
        $virtualAccount->setCurrency(Constant::DEFAULT_CURRENCY);
        $virtualAccount->setBalance(0.0);

        //init usd account
        $usdAccount = new Account();
        $usdAccount->setId(SequenceAccount::getSequence());
        $usdAccount->setName('United States Dollar');
        $usdAccount->setCurrency('USD');
        $usdAccount->setBalance(0.0);

        //binding data to customer object
        $customer->setId($id);
        $customer->addAccounts($virtualAccount);
        $customer->addAccounts($usdAccount);
        $customer->setDefaultAccount($usdAccount);

        return $customer;
    }

    public function printAccounts(){

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
     * Add account to array
     * @param array $account
     */
    public function addAccounts($account)
    {
        $this->accounts[] = $account;
    }


}