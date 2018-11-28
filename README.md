# Geert Boetzkes / Here Maps

Heremaps is a simple Heremaps Rest wrapper for PHP 5.6+. 

Features

 - GeoCoder
 - Mapview
 - Route
 
# Installation

## Composer

HereMaps is PSR-0 compliant and can be installed using [composer](http://getcomposer.org/).  Simply add `geertboetzkes/here-maps` to your composer.json file.  _Composer is the sane alternative to PEAR.  It is excellent for managing dependencies in larger projects_.

    {
        "require": {
            "geertboetzkes/here-maps": "*"
        }
    }

## Autoload using composer

```bash
composer require geertboetzkes/here-maps

```



# Example
Here are a few examples how this libary could be used.
for convenience I have build the package so that all the command are chain-able.

##GeoCoding

```php

$route = new Route(API_KEY, API_SECRET);

$waypoints["a"] = new RouteWaypoint(51.97109267, 5.26213026);
$waypoints["b"] = new RouteWaypoint(52.11244458, 5.36696158);

$result = $route
    ->AddWaypoint($waypoints['a'])
    ->AddWaypoint($waypoints["b"])
    ->vehicle(RouteVehicles::Truck)
    ->trafficInfo(true)
    ->mode(RouteTypes::Fastest)
    ->get();


print_R($result);
```

##Routes

```php

$route = new Route(API_KEY, API_SECRET);

$waypoints["a"] = new RouteWaypoint(51.97109267, 5.26213026);
$waypoints["b"] = new RouteWaypoint(52.11244458, 5.36696158);

$result = $route
    ->AddWaypoint($waypoints['a'])
    ->AddWaypoint($waypoints["b"])
    ->vehicle(RouteVehicles::Truck)
    ->trafficInfo(true)
    ->mode(RouteTypes::Fastest)
    ->get();


print_R($result);`

``