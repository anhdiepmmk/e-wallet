<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 8:15 AM
 */

namespace Models;


class Account
{
    private $id;
    private $name;
    private $currency;
    private $balance;
    private $isFreeze;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return (double)$this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = (double)$balance;
    }

    /**
     * @return mixed
     */
    public function isFreeze()
    {
        return $this->isFreeze;
    }

    /**
     * @param mixed $isFreeze
     */
    public function setFreeze($isFreeze)
    {
        $this->isFreeze = $isFreeze;
    }


    function __toString()
    {
        // TODO: Implement __toString() method.
        return 'id = ' . $this->id . PHP_EOL .
            'currency (' . $this->currency. ')' . PHP_EOL .
            'balance = ' . $this->balance;
    }

}