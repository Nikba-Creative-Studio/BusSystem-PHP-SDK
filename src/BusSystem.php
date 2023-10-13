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
    
    private const ENDPOINTS = [
        'points' => '/curl/get_points.php',
        'routes' => '/curl/get_routes.php',
        'plan' => '/curl/get_plan.php',
        'freeSeats' => '/curl/get_free_seats.php',
        'discount' => '/curl/get_discount.php',
        'allRoutes' => '/curl/get_all_routes.php',
        'newOrder' => '/curl/new_order.php',
        'buyTicket' => '/curl/buy_ticket.php',
        'registerTicket' => '/curl/reg_ticket.php',
        'cancelTicket' => '/curl/cancel_ticket.php',
        'ticket' => '/curl/get_ticket.php',
        'tickets' => '/curl/get_tickets.php',
        'ticketsForDispatch' => '/curl_dispatcher/get_tickets.php',
        'order' => '/curl/get_order.php',
        'orders' => '/curl/get_orders.php',
        'cash' => '/curl/get_cash.php',
    ];

    private $baseUrl;
    private $login;
    private $password;
    private $language = 'en';
    private $errors = [];

    public function __construct($baseUrl, $login, $password, $language = 'en') {
        $this->baseUrl = $baseUrl;
        $this->login = $login;
        $this->password = $password;
        $this->language = $language;
    }

    public function setLanguage($lang) {
        $this->language = $lang;
    }

    private function request($method, $endpointKey, $params = []) {
        $client = new Client();

        $defaultOptions = [
            'multipart' => [
                ['name' => 'login', 'contents' => $this->login],
                ['name' => 'password', 'contents' => $this->password],
                ['name' => 'lang', 'contents' => $this->language],
            ]
        ];

        $paramOptions = array_map(function($key, $value) {
            return ['name' => $key, 'contents' => $value];
        }, array_keys($params), $params);

        $options = [
            'multipart' => array_merge($defaultOptions['multipart'], $paramOptions)
        ];

        $request = new Request($method, $this->baseUrl . self::ENDPOINTS[$endpointKey]);

        try {
            $res = $client->sendAsync($request, $options)->wait();
            $response = $res->getBody()->getContents();
            return simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getPoints($params) {
        return $this->request('POST', 'points', $params);
    }

    public function getRoutes($params) {
        return $this->request('POST', 'routes', $params);
    }

    public function getPlan($params) {
        return $this->request('POST', 'plan', $params);
    }

    public function getFreeSeats($params) {
        return $this->request('POST', 'freeSeats', $params);
    }

    public function getDiscount($params) {
        return $this->request('POST', 'discount', $params);
    }

    public function getAllRoutes() {
        return $this->request('POST', 'allRoutes');
    }

    public function newOrder($params) {
        return $this->request('POST', 'newOrder', $params);
    }

    public function buyTicket($params) {
        return $this->request('POST', 'buyTicket', $params);
    }

    public function registerTicket($params) {
        return $this->request('POST', 'registerTicket', $params);
    }

    public function cancelTicket($params) {
        return $this->request('POST', 'cancelTicket', $params);
    }

    public function getTicket($params) {
        return $this->request('POST', 'ticket', $params);
    }

    public function getTickets($params) {
        return $this->request('POST', 'tickets', $params);
    }

    public function getTicketsForDispatch($params) {
        return $this->request('POST', 'ticketsForDispatch', $params);
    }

    public function getOrder($params) {
        return $this->request('POST', 'order', $params);
    }

    public function getOrders($params) {
        return $this->request('POST', 'orders', $params);
    }

    public function getCash($params) {
        return $this->request('POST', 'cash', $params);
    }
}
