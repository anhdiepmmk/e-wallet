<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 1:49 PM
 */

namespace Utils;


use Models\Currency;

class CurrencyConverter
{
    /*
     * url for curl
     */
    const API_URL = 'http://www.xe.com/currencyconverter/convert/?Amount=[amount]&From=[fromCurrency]&To=[toCurrency]';

    /**
     * Get rate from currency to another currency
     * @param $amount
     * @param $fromCurrency
     * @param $toCurrency
     * @return mixed
     */
    public static function convert($amount, $fromCurrency, $toCurrency)
    {
        //prepare parameters
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);
        $url = str_replace(
            ['[amount]', '[fromCurrency]', '[toCurrency]'],
            [$amount, $fromCurrency, $toCurrency],
            static::API_URL
        );

        //init curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $result = curl_exec($ch);

        // Check HTTP status code
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    preg_match('/<span class=\'uccResultAmount\'>(.+?)<\/span>/m', $result, $matches);
                    if (count($matches) > 1) {
                        return $matches[1];
                    }
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }

        //close curl
        curl_close($ch);

        return -1;
    }


}