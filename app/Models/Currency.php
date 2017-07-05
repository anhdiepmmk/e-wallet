<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 3:12 PM
 */

namespace Models;


use Utils\Console;

class Currency
{

    private $code;
    private $countryName;

    private static $currencies = null;

    /**
     * Get Virtual Currency
     * @return Currency
     */
    public static function getVirtualCurrency()
    {
        return new Currency('CREDITS', 'Unknown');
    }

    /**
     * Get all currency of the world
     * @return currencies
     */
    public static function getCurrencies()
    {
        if (static::$currencies == null) {
            static::$currencies = array();

            static::$currencies[] = new Currency('AED', 'United Arab Emirates Dirham');
            static::$currencies[] = new Currency('AFN', 'Afghanistan Afghani');
            static::$currencies[] = new Currency('ALL', 'Albania Lek');
            static::$currencies[] = new Currency('AMD', 'Armenia Dram');
            static::$currencies[] = new Currency('ANG', 'Netherlands Antilles Guilder');
            static::$currencies[] = new Currency('AOA', 'Angola Kwanza');
            static::$currencies[] = new Currency('ARS', 'Argentina Peso');
            static::$currencies[] = new Currency('AUD', 'Australia Dollar');
            static::$currencies[] = new Currency('AWG', 'Aruba Guilder');
            static::$currencies[] = new Currency('AZN', 'Azerbaijan New Manat');
            static::$currencies[] = new Currency('BAM', 'Bosnia and Herzegovina Convertible Marka');
            static::$currencies[] = new Currency('BBD', 'Barbados Dollar');
            static::$currencies[] = new Currency('BDT', 'Bangladesh Taka');
            static::$currencies[] = new Currency('BGN', 'Bulgaria Lev');
            static::$currencies[] = new Currency('BHD', 'Bahrain Dinar');
            static::$currencies[] = new Currency('BIF', 'Burundi Franc');
            static::$currencies[] = new Currency('BMD', 'Bermuda Dollar');
            static::$currencies[] = new Currency('BND', 'Brunei Darussalam Dollar');
            static::$currencies[] = new Currency('BOB', 'Bolivia Bolíviano');
            static::$currencies[] = new Currency('BRL', 'Brazil Real');
            static::$currencies[] = new Currency('BSD', 'Bahamas Dollar');
            static::$currencies[] = new Currency('BTN', 'Bhutan Ngultrum');
            static::$currencies[] = new Currency('BWP', 'Botswana Pula');
            static::$currencies[] = new Currency('BYN', 'Belarus Ruble');
            static::$currencies[] = new Currency('BZD', 'Belize Dollar');
            static::$currencies[] = new Currency('CAD', 'Canada Dollar');
            static::$currencies[] = new Currency('CDF', 'Congo / Kinshasa Franc');
            static::$currencies[] = new Currency('CHF', 'Switzerland Franc');
            static::$currencies[] = new Currency('CLP', 'Chile Peso');
            static::$currencies[] = new Currency('CNY', 'China Yuan Renminbi');
            static::$currencies[] = new Currency('COP', 'Colombia Peso');
            static::$currencies[] = new Currency('CRC', 'Costa Rica Colon');
            static::$currencies[] = new Currency('CUC', 'Cuba Convertible Peso');
            static::$currencies[] = new Currency('CUP', 'Cuba Peso');
            static::$currencies[] = new Currency('CVE', 'Cape Verde Escudo');
            static::$currencies[] = new Currency('CZK', 'Czech Republic Koruna');
            static::$currencies[] = new Currency('DJF', 'Djibouti Franc');
            static::$currencies[] = new Currency('DKK', 'Denmark Krone');
            static::$currencies[] = new Currency('DOP', 'Dominican Republic Peso');
            static::$currencies[] = new Currency('DZD', 'Algeria Dinar');
            static::$currencies[] = new Currency('EGP', 'Egypt Pound');
            static::$currencies[] = new Currency('ERN', 'Eritrea Nakfa');
            static::$currencies[] = new Currency('ETB', 'Ethiopia Birr');
            static::$currencies[] = new Currency('EUR', 'Euro Member Countries');
            static::$currencies[] = new Currency('FJD', 'Fiji Dollar');
            static::$currencies[] = new Currency('FKP', 'Falkland Islands(Malvinas) Pound');
            static::$currencies[] = new Currency('GBP', 'United Kingdom Pound');
            static::$currencies[] = new Currency('GEL', 'Georgia Lari');
            static::$currencies[] = new Currency('GGP', 'Guernsey Pound');
            static::$currencies[] = new Currency('GHS', 'Ghana Cedi');
            static::$currencies[] = new Currency('GIP', 'Gibraltar Pound');
            static::$currencies[] = new Currency('GMD', 'Gambia Dalasi');
            static::$currencies[] = new Currency('GNF', 'Guinea Franc');
            static::$currencies[] = new Currency('GTQ', 'Guatemala Quetzal');
            static::$currencies[] = new Currency('GYD', 'Guyana Dollar');
            static::$currencies[] = new Currency('HKD', 'Hong Kong Dollar');
            static::$currencies[] = new Currency('HNL', 'Honduras Lempira');
            static::$currencies[] = new Currency('HRK', 'Croatia Kuna');
            static::$currencies[] = new Currency('HTG', 'Haiti Gourde');
            static::$currencies[] = new Currency('HUF', 'Hungary Forint');
            static::$currencies[] = new Currency('IDR', 'Indonesia Rupiah');
            static::$currencies[] = new Currency('ILS', 'Israel Shekel');
            static::$currencies[] = new Currency('IMP', 'Isle of Man Pound');
            static::$currencies[] = new Currency('INR', 'India Rupee');
            static::$currencies[] = new Currency('IQD', 'Iraq Dinar');
            static::$currencies[] = new Currency('IRR', 'Iran Rial');
            static::$currencies[] = new Currency('ISK', 'Iceland Krona');
            static::$currencies[] = new Currency('JEP', 'Jersey Pound');
            static::$currencies[] = new Currency('JMD', 'Jamaica Dollar');
            static::$currencies[] = new Currency('JOD', 'Jordan Dinar');
            static::$currencies[] = new Currency('JPY', 'Japan Yen');
            static::$currencies[] = new Currency('KES', 'Kenya Shilling');
            static::$currencies[] = new Currency('KGS', 'Kyrgyzstan Som');
            static::$currencies[] = new Currency('KHR', 'Cambodia Riel');
            static::$currencies[] = new Currency('KMF', 'Comoros Franc');
            static::$currencies[] = new Currency('KPW', 'Korea(North) Won');
            static::$currencies[] = new Currency('KRW', 'Korea(South) Won');
            static::$currencies[] = new Currency('KWD', 'Kuwait Dinar');
            static::$currencies[] = new Currency('KYD', 'Cayman Islands Dollar');
            static::$currencies[] = new Currency('KZT', 'Kazakhstan Tenge');
            static::$currencies[] = new Currency('LAK', 'Laos Kip');
            static::$currencies[] = new Currency('LBP', 'Lebanon Pound');
            static::$currencies[] = new Currency('LKR', 'Sri Lanka Rupee');
            static::$currencies[] = new Currency('LRD', 'Liberia Dollar');
            static::$currencies[] = new Currency('LSL', 'Lesotho Loti');
            static::$currencies[] = new Currency('LYD', 'Libya Dinar');
            static::$currencies[] = new Currency('MAD', 'Morocco Dirham');
            static::$currencies[] = new Currency('MDL', 'Moldova Leu');
            static::$currencies[] = new Currency('MGA', 'Madagascar Ariary');
            static::$currencies[] = new Currency('MKD', 'Macedonia Denar');
            static::$currencies[] = new Currency('MMK', 'Myanmar(Burma) Kyat');
            static::$currencies[] = new Currency('MNT', 'Mongolia Tughrik');
            static::$currencies[] = new Currency('MOP', 'Macau Pataca');
            static::$currencies[] = new Currency('MRO', 'Mauritania Ouguiya');
            static::$currencies[] = new Currency('MUR', 'Mauritius Rupee');
            static::$currencies[] = new Currency('MVR', 'Maldives(Maldive Islands) Rufiyaa');
            static::$currencies[] = new Currency('MWK', 'Malawi Kwacha');
            static::$currencies[] = new Currency('MXN', 'Mexico Peso');
            static::$currencies[] = new Currency('MYR', 'Malaysia Ringgit');
            static::$currencies[] = new Currency('MZN', 'Mozambique Metical');
            static::$currencies[] = new Currency('NAD', 'Namibia Dollar');
            static::$currencies[] = new Currency('NGN', 'Nigeria Naira');
            static::$currencies[] = new Currency('NIO', 'Nicaragua Cordoba');
            static::$currencies[] = new Currency('NOK', 'Norway Krone');
            static::$currencies[] = new Currency('NPR', 'Nepal Rupee');
            static::$currencies[] = new Currency('NZD', 'New Zealand Dollar');
            static::$currencies[] = new Currency('OMR', 'Oman Rial');
            static::$currencies[] = new Currency('PAB', 'Panama Balboa');
            static::$currencies[] = new Currency('PEN', 'Peru Sol');
            static::$currencies[] = new Currency('PGK', 'Papua New Guinea Kina');
            static::$currencies[] = new Currency('PHP', 'Philippines Peso');
            static::$currencies[] = new Currency('PKR', 'Pakistan Rupee');
            static::$currencies[] = new Currency('PLN', 'Poland Zloty');
            static::$currencies[] = new Currency('PYG', 'Paraguay Guarani');
            static::$currencies[] = new Currency('QAR', 'Qatar Riyal');
            static::$currencies[] = new Currency('RON', 'Romania New Leu');
            static::$currencies[] = new Currency('RSD', 'Serbia Dinar');
            static::$currencies[] = new Currency('RUB', 'Russia Ruble');
            static::$currencies[] = new Currency('RWF', 'Rwanda Franc');
            static::$currencies[] = new Currency('SAR', 'Saudi Arabia Riyal');
            static::$currencies[] = new Currency('SBD', 'Solomon Islands Dollar');
            static::$currencies[] = new Currency('SCR', 'Seychelles Rupee');
            static::$currencies[] = new Currency('SDG', 'Sudan Pound');
            static::$currencies[] = new Currency('SEK', 'Sweden Krona');
            static::$currencies[] = new Currency('SGD', 'Singapore Dollar');
            static::$currencies[] = new Currency('SHP', 'Saint Helena Pound');
            static::$currencies[] = new Currency('SLL', 'Sierra Leone Leone');
            static::$currencies[] = new Currency('SOS', 'Somalia Shilling');
            static::$currencies[] = new Currency('SPL', '* Seborga Luigino');
            static::$currencies[] = new Currency('SRD', 'Suriname Dollar');
            static::$currencies[] = new Currency('STD', 'São Tomé and Príncipe Dobra');
            static::$currencies[] = new Currency('SVC', 'El Salvador Colon');
            static::$currencies[] = new Currency('SYP', 'Syria Pound');
            static::$currencies[] = new Currency('SZL', 'Swaziland Lilangeni');
            static::$currencies[] = new Currency('THB', 'Thailand Baht');
            static::$currencies[] = new Currency('TJS', 'Tajikistan Somoni');
            static::$currencies[] = new Currency('TMT', 'Turkmenistan Manat');
            static::$currencies[] = new Currency('TND', 'Tunisia Dinar');
            static::$currencies[] = new Currency('TOP', 'Tonga Pa\'anga');
            static::$currencies[] = new Currency('TRY', 'Turkey Lira');
            static::$currencies[] = new Currency('TTD', 'Trinidad and Tobago Dollar');
            static::$currencies[] = new Currency('TVD', 'Tuvalu Dollar');
            static::$currencies[] = new Currency('TWD', 'Taiwan New Dollar');
            static::$currencies[] = new Currency('TZS', 'Tanzania Shilling');
            static::$currencies[] = new Currency('UAH', 'Ukraine Hryvnia');
            static::$currencies[] = new Currency('UGX', 'Uganda Shilling');
            static::$currencies[] = new Currency('USD', 'United States Dollar');
            static::$currencies[] = new Currency('UYU', 'Uruguay Peso');
            static::$currencies[] = new Currency('UZS', 'Uzbekistan Som');
            static::$currencies[] = new Currency('VEF', 'Venezuela Bolivar');
            static::$currencies[] = new Currency('VND', 'Viet Nam Dong');
            static::$currencies[] = new Currency('VUV', 'Vanuatu Vatu');
            static::$currencies[] = new Currency('WST', 'Samoa Tala');
            static::$currencies[] = new Currency('XAF', 'Communauté Financière Africaine (BEAC) CFA Franc BEAC');
            static::$currencies[] = new Currency('XCD', 'East Caribbean Dollar');
            static::$currencies[] = new Currency('XDR', 'International Monetary Fund (IMF) Special Drawing Rights');
            static::$currencies[] = new Currency('XOF', 'Communauté Financière Africaine (BCEAO) Franc');
            static::$currencies[] = new Currency('XPF', 'Comptoirs Français du Pacifique (CFP) Franc');
            static::$currencies[] = new Currency('YER', 'Yemen Rial');
            static::$currencies[] = new Currency('ZAR', 'South Africa Rand');
            static::$currencies[] = new Currency('ZMW', 'Zambia Kwacha');
            static::$currencies[] = new Currency('ZWD', 'Zimbabwe Dollar');
        }
        return static::$currencies;
    }

    /**
     * Print all currency to screen
     */
    public static function printCurrencies()
    {
        $currencies = Currency::getCurrencies();

        Console::writeLine('code --- country name');
        for ($i = 0; $i < count($currencies); ++$i) {
            $currency = $currencies[$i];
            Console::writeLine($currency->getCode() . ' - ' . $currency->getCountryName());
        }
        Console::writeLine('code --- country name');
    }

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
     * Check currency is virtual or not
     * @return bool
     */
    public function isVirtualCurrency()
    {
        return ($this->code === static::getVirtualCurrency()->code);
    }


    /**
     * Find and return currency by code
     * @param $code
     * @return bool
     */
    public static function getCurrencyByCode($code)
    {
        $currencies = static::getCurrencies();
        for ($i = 0; $i < count($currencies); ++$i) {
            $currency = $currencies[$i];
            if ($code === $currency->getCode()) {
                return $currency;
            }
        }
        return false;
    }

    /**
     * @param $index
     */
    public static function getCurrencyByIndex($index){

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