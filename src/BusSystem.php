<?php

namespace Nikba\BusSystemPhpSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * bussystem.eu API PHP wrapper
 *
 * BusSystem is bus transport control system
 *
 * @see https://bussystem.eu/api/en.html BusSystem API.
 *
 * @author Bargan Nicolai <office@nikba.com>
 */

class BusSystem {     
    /**
     * @var string API base URL
     */
    private $baseUrl;
    
    /**
     * @var string API Login
     */
    private $login;

    /**
     * @var string API Password
     */
    private $password;

    /**
     * @var string API Language
     */
    private $language = 'en';

    /** 
     * Constructor.
     * @param string $login API Login
     * @param string $password API Password
     * @param bool $testMode true if test mode is enabled
     * @param string $language API Language
     */
    public function __construct($baseurl, $login, $password, $language = 'en') {

        $this->baseurl = $baseurl;
        $this->login = $login;
        $this->password = $password;
        $this->language = $language;
    }

    /**
     * Request API.
     * @param string $method API method.
     * @param string $endpoint API endpoint.
     * @param array $params API parameters.
     * @return array API response.
     */
    private function request($method, $endpoint, $params = []) {
        $client = new Client();

        $params['login'] = $this->login;
        $params['password'] = $this->password;
        $params['lang'] = $this->language;


        $request = new Request($method, $this->baseurl . $endpoint . '?' . http_build_query($params));
        $response = $client->send($request);
        
        $xml = simplexml_load_string($response->getBody()->getContents(),'SimpleXMLElement',LIBXML_NOCDATA);
        $json = json_encode($xml);
        return $json;
    }

    /**
     * Get Countries
     * @return array Countries.
     */
    public function getCountries() {
        return $this->request('GET', '/curl/get_points.php', ['viev' => 'get_country']);
    }
   
}