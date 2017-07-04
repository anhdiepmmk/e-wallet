<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 3:12 PM
 */

namespace Models;


class Currency
{
    private $code;
    private $countryName;

    /**
     * Currency constructor.
     * @param $code
     * @param $countryName
     */
    public function __construct($code, $countryName)
    {
        $this->code = $code;
        $this->countryName = $countryName;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param mixed $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }
}