<?php

namespace Nikba\BusSystemPhpSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * bussystem.eu API PHP wrapper
 * BusSystem is bus transport control system
 * @see https://bussystem.eu/api/en.html BusSystem API.
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
     * @var array Errors
     */
    private $errors = [];

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
                    'name' => 'lang',
                    'contents' => $this->language,
                ],
                
          ]];
          
          # Push Params to Options
          foreach ($params as $key => $value) {
            array_push($options['multipart'], ['name' => $key, 'contents' => $value]);
          }

          // Send request
          $request = new Request($method, $this->baseurl . $endpoint);
          
          // Check request response
          try {
            $res = $client->sendAsync($request, $options)->wait();
            $response = $res->getBody()->getContents();
            $xml = simplexml_load_string($response,'SimpleXMLElement',LIBXML_NOCDATA);
            return $xml;
          } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
          }
    }

    /**
     * Get Errors
     * @return array Errors.
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get Points
     * Selection of available cities, countries.
     * @param array $params API parameters.
     * @return array Points.
     */
    public function getPoints($params) {
        return $this->request('POST', '/curl/get_points.php', $params);
    }

    /**
     * Get Routes
     * Information about available active routes on the selected interval of cities as of the date specified.
     * @param array $params API parameters.
     * @return array Routes.
     */
    public function getRoutes($params) {
        return $this->request('POST', '/curl/get_routes.php', $params);
    }

    /**
     * Get Plan
     * Plan places in the bus or train
     * @param array $params API parameters.
     * @return array Plans.
     */
    public function getPlan($params) {
        return $this->request('POST', '/curl/get_plan.php', $params);
    }

    /**
     * Get Seats
     * Information about available seats
     * @param array $params API parameters.
     * @return array Seats.
     */
    public function getFreeSeats($params) {
        return $this->request('POST', '/curl/get_free_seats.php', $params);
    }

    /**
     * Get Discount
     * Information about available discounts
     * @param array $params API parameters.
     * @return array Discounts.
     */
    public function getDiscount($params) {
        return $this->request('POST', '/curl/get_discount.php', $params);
    }

    /**
     * Get All Routes
     * Information about all available routes
     * @param array $params API parameters.
     * @return array Routes.
     */
    public function getAllRoutes() {
        return $this->request('POST', '/curl/get_all_routes.php');
    }

    /**
     * New Order
     * Create new order
     * @param array $params API parameters.
     * @return array New Route info.
     */
    public function newOrder($params) {
        return $this->request('POST', '/curl/new_order.php', $params);
    }

    /**
     * Buy Ticket
     * Buy ticket based on generated order
     * @param array $params API parameters.
     * @return array New Ticket info.
     */
    public function buyTicket($params) {
        return $this->request('POST', '/curl/buy_ticket.php', $params);
    }

    /**
     * Register Ticket
     * Registration dates for OPEN Ticket
     * @param array $params API parameters.
     * @return array New Ticket info.
     */
    public function registerTicket($params) {
        return $this->request('POST', '/curl/reg_ticket.php', $params);
    }

    /**
     * Cancel Ticket
     * Cancellation of unpaid order, reservation cancellation, refund of the paid ticket (full or partial).
     * @param array $params API parameters.
     * @return array Order info.
     */
    public function cancelTicket($params) {
        return $this->request('POST', '/curl/cancel_ticket.php', $params);
    }

    /**
     * Get Ticket
     * Get ticket info
     * @param array $params API parameters.
     * @return array Ticket info.
     */
    public function getTicket($params) {
        return $this->request('POST', '/curl/get_ticket.php', $params);
    }

    /**
     * Get Tickets
     * Get tickets info
     * @param array $params API parameters.
     * @return array Tickets info.
     */
    public function getTickets($params) {
        return $this->request('POST', '/curl/get_tickets.php', $params);
    }

    /**
     * Get Tickets for Dispatch
     * Get tickets info for dispatch
     * @param array $params API parameters.
     * @return array Tickets info.
     */
    public function getTicketsForDispatch($params) {
        return $this->request('POST', '/curl_dispatcher/get_tickets.php', $params);
    }

    /**
     * Get Order
     * Get order info
     * @param array $params API parameters.
     * @return array Order info.
     */
    public function getOrder($params) {
        return $this->request('POST', '/curl/get_order.php', $params);
    }

    /**
     * Get Orders
     * Get orders info
     * @param array $params API parameters.
     * @return array Orders info.
     */
    public function getOrders($params) {
        return $this->request('POST', '/curl/get_orders.php', $params);
    }

    /** Get Cash
     * Get cash info
     * @param array $params API parameters.
     * @return array Cash info.
     */
    public function getCash($params) {
        return $this->request('POST', '/curl/get_cash.php', $params);
    }
   
}