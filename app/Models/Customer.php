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

    function __construct($wantInit = true)
    {
        if($wantInit){
            $virtualAccount = new Account();
            $usdAccount = new Account();

            //add two account to this array
            $accounts[]  = $virtualAccount;
            $accounts[]  = $usdAccount;
        }
    }

    /**
     * Do login
     * @param $id
     * @param array $customers
     * @return bool
     */
    public function login($id, array $customers){
        if(count($customers) > 0){
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
     * @param array $accounts
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }


}