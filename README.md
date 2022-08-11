
# bussystem.eu API PHP SDK
BusSystem is bus transport control system 

## Installation

Install nikba/bus-system-php-sdk  with php composer

```bash
  composer require nikba/bus-system-php-sdk
```
    
## Usage/Examples

```php
$bussystem = new \Nikba\BusSystemPhpSdk\BusSystem(
    'BASE URL', 
    'LOGIN', 
    'PASSWORD', 
    'en'
);

# Get All Countries
$params = ['viev' => 'get_country'];
$points = $bussystem->getPoints($params);
```


## Web-service function:

- get_points — selection of available cities, countries, as well as dynamically linked ones (united with the outdated function get_country, an optional function)

- get_routes — Information about ALL available routes within selected interval of cities as on the specified date

- get_plan — Plan places in the bus (ALL ROUTES, an optional function)

- get_free_seats — Search number seats (bus and train) and search wagons for train. (Required for train)

- get_discount — List of discounts for route (optional function)

- get_all_routes — Timetable of route (optional function)

- new_order — Creating a new order for the period depending on the terms of lock_min (generally 10 minutes). Upon the expiry of lock_min, the order will be automatically cancelled. Some routes allow blocking the seats for the indicated time. Moreover, some routes may be paid for even upon the expiry of lock_min, but this does not guarantee a successful sale and the specified seat (might be changed).

- buy_ticket — Sale of tickets based on the generated order (item 3. new_order)

- cancel_ticket — Order cancellation and ticket refund (united with the outdated function cancel_order)

- get_ticket — Getting full information about a ticket (an optional function)

- get_orer — Getting full information about a order

- print_ticket — Getting an e-ticket form (confirmation for the carrier can be of different designs, depending on the selected route). The passenger must show this very form on the bus, and not a receipt from the terminal, bank, etc, otherwise the passenger may be denied a trip.

- get_orders — Order list (if applicable payment)

- get_tickets — List of tickets (if applicable payment)

- get_tickets (dispatcher) — List of tickets for carriers and dispatchers

- get_cash — Cash (if applicable payment)

#### In all the above requests, it is recommended to send the tag session=xxxx (user session) - this is how you can get routes where this tag is required.



## API Reference

All data shall be transmitted via HTTP (HTTPS for real system) using POST method.
In response to the query data returns as XML.

Address for test queries:
https://test-api.bussystem.eu/server

Address for prod. queries:
https://api.bussystem.eu/server

### get_points

```http
  POST /server/curl/get_points.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `country_id`   | `1` | `int (3)` | Shows all cities of the specified country (optional parameter) |
| `point_id_from`   | `3` | `int (10)` | Shows all cities where you can get from the specified point, may not reflect the reality if routes of the external systems have been connected (optional parameter) |
| `point_id_to`   | `90` | `int (10)` | Shows all cities wherefrom you can get to the specified point, may not reflect the reality if routes of the external systems have been connected (optional parameter) |
| `autocomplete`   | `Моск` | `varchar (100)` | Shows the cities, the initial symbols of which coincide (optional parameter) |
| `boundLatSW`   | `15.75` | `float (10)` | Search cities in a given field of GPS |
| `boundLonSW`   | `15.75` | `float (10)` | Search cities in a given field of GPS |
| `boundLatNE`   | `15.75` | `float (10)` | Search cities in a given field of GPS |
| `boundLotNE`   | `15.75` | `float (10)` | Search cities in a given field of GPS |
| `trans`   | `all, bus, train, air, travel, hotel` | `varchar (10)` | Shows only the cities that belong to the specified transport or service, if more than one is connected (optional parameter, all by default) |
| `viev`   | `get_country, group_country` | `varchar (10)` | get_country - To get a list of countries, please specify this parameter, group_country - Shows the cities grouped by the countries in the orderly list (if lang is specified, cities and countries will be displayed in that language, ru is set by default) |
| `all`   | `1` | `int(3)` | 1 - get a list of all cities (including towns, villages, etc.), 0 - get a list of popular cities  |

### get_routes

```http
  POST /server/curl/get_routes.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `session`   | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `v`   | `1.1` | `varchar (5)` | Query version |
| `id_from`   | `3` | `int (10)` | Departure city |
| `id_to`   | `7` | `int (10)` | Arrival city |
| `point_train_from_id`   | `2004000` | `int (10)` | Departure city (for railway) |
| `point_train_to_id`   | `2062428` | `int (10)` | Arrival city (for railway) |
| `id_iata_from`   | `LWO` | `vachar (3)` | Departure airport (for avia, by IATA code) |
| `id_iata_to`   | `KBP` | `vachar (3)` | Arrival airport (for avia, by IATA code) |
| `date`   | `2014-08-21` | `date (yyyy-mm-dd)` | Departure date. When searching routes with an OPEN date - parameter is optional |
| `currency`   | `EUR` | `vachar (3)` | Currency requested (optional parameter) |
| `period`   | `2` | `int (2)` | Number of days of searching starting from the specified date. If the negative value is specified, the search will be done from and to the specified date (-/+), i.e. the interval is twice as much. Maximum value from -3 to 14 is allowed. If the parameter is not specified, search will be done only regarding the specified date. (optional parameter) |
| `interval_id`   | `45475` | `vachar (1000)` | When selecting more than 2 routes in one order, it is recommended to specify this parameter (interval of any previous route) to provide visual presentation of price considering two-way trip, if the routes allow each other a discount. |
| `route_id`   | `90` | `int (5)` | Searches only for the specified route ID (optional parameter) |
| `trans`   | `all, bus, train, air, travel, hotel` | `vachar (10)` | Shows only the routes that belong to the specified transport or service, in case several are connected (optional parameter, all by default) |
| `search_type`   | `1` | `int (1)` | Search type. 1-search for all routes, 2-search for routes in order to buy OPEN tickets, 3-search for routes in order to register OPEN tickets, find_order_id or find_ticket_id and find_security should be obligatory specified |
| `find_order_id`   | `10527554` | `int (10)` | Order ID to search for the route to register OPEN (optional parameter) |
| `find_ticket_id`   | `90005` | `int (10)` | Ticket ID to search for the route to register OPEN (optional parameter) |
| `find_security`   | `5735838` | `varchar (10)` | Security code of the order or ticket to search for the route to register OPEN (optional parameter) |
| `change`   | `1` | `int (1)` | 1 - route with changes, 0 - direct route  |
| `direct`   | `1` | `int (1)` | 1 - avia routes with changes, 0 - only direct avia routes  |
| `baggage_no`   | `1` | `int (1)` | 1 - avia routes without baggage, 0 - all avia routes, with baggage and without baggage  |
| `service_class`   | `E` | `vachar(1)` | Avia routes search by service class. Possible values: A - all service classes, E - Economy-class, B - Business-class.  |
| `adt`   | `2` | `int (1)` | Quantity of adult passengers in avia routes search. By default search avia routes for adt=1. |
| `chd`   | `1` | `int (1)` | Quantity of children to 12 years in avia routes search. |
| `inf`   | `1` | `int (1)` | Quantity of infants to 2 years in avia routes search. |
| `sort_type` | `price` | `varchar (10)` | Sort found routes: time – according to time and date of departure (by default), price – according to price |
| `ws`   | `1` | `int (1)` | ws=1 - get routes from our server (for faster response). ws=2 - get routes from third-party systems (possible delays in waiting for a response). ws=0 - get all routes|

### get_plan

```http
  POST /server/curl/get_plan.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `session`   | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `bustype_id`   | `22` | `varchar (6)` | ID bustype (only for bus) |
| `vagon_type`   | `P` | `varchar (6)` | ID type vagon from request get_free_seats. (only for train) |
| `position`   | `v` | `varchar (1)` | arrangement plan (vertical-and-horizontal) (v - vertical, h - horizontal) |

### get_free_seats

```http
  POST /server/curl/get_free_seats.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `session`   | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `interval_id`   | `ju34hd, 23012012, 23012012` | `varchar (1000)` | Interval route |
| `currency`   | `EUR` | `vachar (3)` | Currency requested (optional parameter) |

### get_discount

```http
  POST /server/curl/get_discount.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `session`   | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `interval_id`   | `90, gh340, d29-96` | `varchar (1000)` | ID interval from the request get routes |
| `currency`   | `EUR` | `vachar (3)` | Currency requested (optional parameter) |

### get_all_routes

```http
  POST /server/curl/get_all_routes.php
```

| Parameter | Example of value     | Type     | Description                |
| :-------- | :------- | :------- | :------------------------- |
| `login`   | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password`   | `1234` | `varchar (32)` | It is specified individually for each one in the test and real system |
| `lang`   | `en, ru, ua, de, pl, cz` | `varchar (2)` | Sorts countries and cities in alphabetic order (optional parameter) |
| `session`   | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `timetable_id`   | `90, gh340, d29-96` | `varchar (1000)` | Timetable ID, from the get_routes query, reflects information about the route found |

### new_order

```http
  POST /server/curl/new_order.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `session` | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `partner` | `155487` | `varchar (6)` | ID your web site (optional parameter) |
| `v` | `1.1` | `varchar (5)` | Query version |
| `date[0]` | `2011-08-21` | `date (yyyy-mm-dd)` | Departure date of the 1st bus (train, airplane) in the order<br><br>If the value date=open is OPEN ticket reservation |
| `interval_id[0]` | `ju34hd, 23012012, 23012012` | `varchar (1000)` | Departure interval of the 1st bus (train, airplane) in the order |
| `station_from_id[0]` | `1547` | `int (10)` | Departure station ID of the 1st bus (optional parameter) |
| `station_to_id[0]` | `757` | `int (10)` | Arrival station ID of the 1st bus (optional parameter) |
| `seat[0][0]` | `45S` | `varchar (10)` | Selected seat of the 1st bus (train) for the 1st passenger in the order, in case the seat is occupied, the next closest vacant seat will be suggested (some external systems will not suggest a seat)  <br>  <br>For trans=air it is necessary to indicate value of the seat in accordance with earlier specified in get_routes request passengers quantity "adt" or "chd" or "inf":  <br>For example, a request of seats for 3 passengers in 1st order should be indicated as follows:  <br>seat\[0\]\[0\] = adt (1 adult; 1st passenger)  <br>seat\[0\]\[1\] = chd (1 child to 12 years; 2nd passenger)  <br>seat\[0\]\[2\] = inf (1 infant to 2 years; 3rd passenger) |
| `name[0]` | `pavel` | `varchar (50)` | Name of the 1st passenger, for the 2nd one name\[1\] (mandatory parameter in the request for routes with need_orderdata=1)<br><br>CAUTION! Only in english, except for departure and arrival bus/train in Russia, Ukraine and Belarus. |
| `surname[0]` | `kuznecov` | `varchar (50)` | Surname of the 1st passenger, for the 2nd one surname\[1\] (mandatory parameter in the request for routes with need_orderdata=1)<br><br>CAUTION!Only in Latin, except for departure and arrival bus / train in Russia, Ukraine and Belarus. |
| `middlename[0]` | `aleksandrovich` | `varchar (50)` | Middlename of the 1st passenger, for the 2nd one middlename\[1\] (mandatory parameter in the request for routes with need_middlename=1)<br><br>CAUTION!Only in Latin, except for departure and arrival bus / train in Russia, Ukraine and Belarus. |
| `birth_date[0]` | `1983-03-24` | `date (yyyy-mm-dd)` | Date of birth of the 1st passenger (mandatory parameter in the request for routes with need_birth=1) |
| `doc_type[0]` | `1`   | `int (1)` | Document type of 1st passenger (mandatory parameter in the request for routes with need_doc=1)  <br>1 - travel passport  <br>2 - internal passport  <br>3 - birth certificate |
| `doc_number[0]` | `CZRE5752475-54` | `varchar (50)` | Document number of 1st passenger (mandatory parameter in the request for routes with need_doc=1) |
| `doc_expire_date[0]` | `2020-01-20` | `date (yyyy-mm-dd)` | Document expiration date of 1st passenger (mandatory parameter in the request for routes with need\_doc\_expire_date=1) |
| `citizenship[0]` | `RU`  | `varchar (2)` | Citizenship of 1st passenger (mandatory parameter in the request for routes with need_citizenship=1) |
| `gender[0]` | `M`   | `varchar (1)` | Gender of 1st passenger (mandatory parameter in the request for routes with need_gender=1)  <br>M - man  <br>F - woman |
| `discount_id[0][0]` | `457` | `int (10)` | Selected ID discount of the 1st bus (train) for the 1st passenger in the order (optional parameter)  <br>  <br>For trans=air discount is already included in the seat parameter, it is not necessary to indicate it. |
| `phone` | `420776251258` | `varchar (20)` | General phone number for all passengers in case of emergency (mandatory parameter in the request for routes with need_orderdata=1) |
| `phone2` | `380776251258` | `varchar (20)` | Additional general phone number for all passengers in case of emergency (optional parameter) |
| `email` | `info@seznam.cz` | `varchar (50)` | E-mail of all passengers in case of emergency (optional parameter) |
| `info` | `i want to home` | `varchar (255)` | Information from passenger (optional parameter) |
| `currency` | `EUR` | `varchar (3)` | Requested currency (optional parameter) |
| `lang` | `en, ru, pl, cz, ua, ro` | `varchar (2)` | Response language (optional parameter) |

### buy_ticket

```http
  POST /server/curl/buy_ticket.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | varchar (32) | It is specified individually for each one in the test and real systems |
| `password` | `12345` | varchar (32) | It is specified individually for each one in the test and real systems |
| `session` | `c227e552956b` | varchar (32) | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `v` | `1.1` | `varchar (5)` | Query version |
| `order_id` | `1158240` | `int (10)` | Order ID, received from the query new_order |
| `lang` | `en, ru, pl, cz, ua, ro` | varchar (2) | Response language (optional parameter) |


### reg_ticket

```http
  POST /server/curl/reg_ticket.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `session` | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `v` | `1.1` | `varchar (5)` | Query version |
| `ticket_id` | `90424` | `int (10)` | ticket ID |
| `security` | `5734574` | `varchar (10)` | Security code of the order or ticket (optional parameter when requested by the ticket seller) |
| `date` | `2014-08-21` | `date (yyyy-mm-dd)` | Departure date |
| `seat` | `31`  | `int (2)` | Seat on a bus. Seats 80-99 unreal, seat numbers will be indicated when boarding the bus (the ticket will contain *) |

### cancel_ticket

```http
  POST /server/curl/cancel_ticket.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `session` | `c227e552956b` | `varchar (32)` | The session parameter of each user (unique), it is recommended to send for get additional routes where this tag is required. (optional parameter) |
| `v` | `1.1` | `varchar (5)` | Query version |
| `order_id` | `1158240` | `int (10)` | Order ID, received from the query new\_order. It is applied to remove the unpaid and paid all order (it is optional only if you need to remove just 1 ticket by specifying ticket\_id) |
| `ticket_id` | `90422` | `int (10)` | Ticket ID, received from the query buy\_ticket (it is optional only if you need to remove all order by specifying order\_id) |

### get_ticket

```http
  POST /server/curl/get_ticket.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `order_id` | `1158240` | `int (10)` | Order ID to display all tickets of the order, obtained from the query new\_order or buy\_ticket. |
| `ticket_id` | `90422` | `int (10)` | ticket ID to display only 1 ticket, obtained from the query buy_ticket |
| `security` | `5734574` | `varchar (10)` | Security code of the order or ticket (optional parameter when requested by the ticket seller) |
| `lang` | `en, ru, pl, cz, ua, ro` | `varchar (2)` | Language of the data returned (optional parameter) |


### get_order

```http
  POST /server/curl/get_order.php
```

| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `order_id` | `1158240` | `int (10)` | Order ID to display all tickets of the order, obtained from the query new\_order or buy\_ticket. |
| `security` | `5734574` | `varchar (10)` | Security code of the order (optional parameter when requested by the ticket seller) |

### get_orders

```http
  POST /server/curl/get_orders.php
```
| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `date_from` | `2016-01-25` | `date` | Created Order (from) |
| `date_until` | `2016-01-25` | `date` | Created Order (until) |
| `order_id` | `1158240` | `int (10)` | Order number |
| `ticket_id` | `1000240` | `int (10)` | Number of ticket |
| `status` | `buy` | `vachar (10)` | Order status (buy, cancel, reserve) |
| `date_departure` | `2016-01-25` | `date` | departure date |
| `date_reservation` | `2016-01-25` | `date `| booking date |
| `date_buy` | `2016-01-25` | `date` | payment date |
| `client_surname` | `aleksandrov` | `varchar (50)` | surname |
| `phone` | `420776251258` | `varchar (20)` | phone |
| `email` | `info@seznam.cz` | `varchar (50)` | E-Mail |

### get_orders (partners)

```http
  POST /server/curl_partner/get_orders.php
```
| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `partner` | `varchar (32)` | login to system WEBSITE, it is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | password to system WEBSITE, it is specified individually for each one in the test and real systems website |
| `date_from` | `2016-01-25` | `date` | Created Order (from) |
| `date_until` | `2016-01-25` | `date` | Created Order (until) |
| `marker_id` | `14`  | `int` | ID marker (for other web page) |
| `status` | `buy` | `string` | Status Order |
| `calculation` | `1`   | `int` | 1 - calculated partner, 2 - not calculated partner, 0 - all |

### get_tickets
```http
  POST /server/curl_partner/get_tickets.php
```
| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `date_from` | `2016-01-25` | `date` | Created ticket (from) |
| `date_until` | `2016-01-25` | `date` | Created ticket (until) |
| `ticket_status` | `buy` | `vachar (10)` | Status of tickets:  buy, cancel, reserve |
| `canceled_routes` | `1`   | `int (3)` | 1 - get tickets on the canceled routes |

### get_tickets (dispatcher)
```http
  POST /server/curl_dispatcher/get_tickets.php
```
| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `date_from` | `2016-01-25` | `date` | Created ticket (from) |
| `date_until` | `2016-01-25` | `date` | Created ticket (until) |
| `type_date` | `buy` | `vachar (32)` | Type of date: buy - found by departure date (default), departure - found by departure date |

### get_cash
```http
  POST /server/curl/get_cash.php
```
| Parameter | Example of value     | Type     | Description |
| :-------- | :------- | :------- | :------------------------- |
| `login` | `dealer` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `password` | `12345` | `varchar (32)` | It is specified individually for each one in the test and real systems |
| `date_from` | `2016-01-25` | `date` | Cash (from) |
| `date_until` | `2016-01-25` | `date` | Cash (until) |


## Documentation

[Documentation](https://bussystem.eu/api/en.html)


## Support

For support, [GitHub Issues](https://github.com/NikbaCreativeStudio/BusSystem-PHP-SDK/issues)

