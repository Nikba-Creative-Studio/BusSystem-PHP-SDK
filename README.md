
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

- get_plan Plan places in the bus (ALL ROUTES, an optional function)

- get_free_seats Search number seats (bus and train) and search wagons for train. (Required for train)

- get_discount List of discounts for route (optional function)

- get_all_routes — Timetable of route (optional function)

- new_order — Creating a new order for the period depending on the terms of lock_min (generally 10 minutes). Upon the expiry of lock_min, the order will be automatically cancelled. Some routes allow blocking the seats for the indicated time. Moreover, some routes may be paid for even upon the expiry of lock_min, but this does not guarantee a successful sale and the specified seat (might be changed).

- buy_ticket — Sale of tickets based on the generated order (item 3. new_order)

- cancel_ticket — Order cancellation and ticket refund (united with the outdated function cancel_order)

- get_ticket — Getting full information about a ticket (an optional function)

- get_orer — Getting full information about a order

- print_ticket — Getting an e-ticket form (confirmation for the carrier can be of different designs, depending on the selected route). The passenger must show this very form on the bus, and not a receipt from the terminal, bank, etc, otherwise the passenger may be denied a trip.

- get_orders — Order list (if applicable payment)

- get_orders (partner) — Order list (for web affilite partners)

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


## Documentation

[Documentation](https://bussystem.eu/api/en.html)


## Support

For support, [GitHub Issues](https://github.com/NikbaCreativeStudio/BusSystem-PHP-SDK/issues)

