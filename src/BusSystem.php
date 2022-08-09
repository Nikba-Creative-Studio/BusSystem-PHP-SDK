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
     * @bool true if test mode is enabled
     */
    private $testMode = false;
     
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
    public function __construct($login, $password, $testMode = false, $language = 'en') {

        $this->baseurl = (self::$testMode) ? 'https://test.bussystem.eu/api/' : 'https://bussystem.eu/api/';

        $this->login = $login;
        $this->password = $password;
        $this->testMode = $testMode;
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

        $request = new Request($method, self::$baseurl . $endpoint . '?' . http_build_query($params));
        $response = $client->send($request);
        $response = $response->getBody()->getContents();
        print_r($response);

        #$this->apiResponse = json_decode($response->getBody()->getContents(), true);
        #return $this->apiResponse;
    }

    /**
     * Get Countries
     * @return array Countries.
     */
    public function getCountries() {
        return $this->request('GET', 'countries');
    }
   
}