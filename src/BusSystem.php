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

        $options = [
            'multipart' => [
                [
                    'name' => 'login',
                    'contents' => $this->login,
                ],
                [
                    'name' => 'password',
                    'contents' => $this->password,
                ],
                [
                    'name' => 'language',
                    'contents' => $this->language,
                ],
                
          ]];
          
          # Push Params to Options
          foreach ($params as $key => $value) {
            array_push($options['multipart'], ['name' => $key, 'contents' => $value]);
          }

          $request = new Request('POST', $this->baseurl . $endpoint);
          $res = $client->sendAsync($request, $options)->wait();
          $response = $res->getBody()->getContents();
          $xml = simplexml_load_string($response,'SimpleXMLElement',LIBXML_NOCDATA);
          return $xml;
    }

    /**
     * Get Points
     * Selection of available cities, countries.
     * @return array Countries.
     * @param int country_id - Shows all cities of the specified country (optional parameter)
     * @param int point_id_from - Shows all cities where you can get from the specified point, may not reflect the reality if routes of the external systems have been connected (optional parameter)
     * @param int point_id_to - Shows all cities wherefrom you can get to the specified point, may not reflect the reality if routes of the external systems have been connected (optional parameter)
     * @param string autocomplete - Shows the cities, the initial symbols of which coincide (optional parameter)
     * @param float boundLatSW, boundLonSW, boundLatNE, boundLotNE - Search cities in a given field of GPS
     * @param string trans - all, bus, train, air, travel, hotel - Shows only the cities that belong to the specified transport or service, if more than one is connected (optional parameter, all by default)
     * @param string viev - get_country - To get a list of countries, please specify this parameter, group_country - Shows the cities grouped by the countries in the orderly list (if lang is specified, cities and countries will be displayed in that language, ru is set by default)
     * @param int all - 1 - get a list of all cities (including towns, villages, etc.), 0 - get a list of popular cities 
     */
    public function getPoints($params) {
        return $this->request('POST', '/curl/get_points.php', $params);
    }
   
}