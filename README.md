# Geert Boetzkes / Here Maps

Heremaps is a simple Heremaps Rest wrapper for PHP 5.6+. 

Features

 - GeoCoder
 - Mapview
 - Route
 
# Installation

## Composer

HereMaps is PSR-0 compliant and can be installed using [composer](http://getcomposer.org/).  Simply add `geertboetzkes/heremaps` to your composer.json file.  _Composer is the sane alternative to PEAR.  It is excellent for managing dependencies in larger projects_.
```json
{
    "require": {
        "geertboetzkes/heremaps": "*"
    }
}
```
    

## Autoload using composer

```bash
composer require geertboetzkes/heremaps

```



# Example
Here are a few examples how this libary could be used.
for convenience I have build the package so that all the command are chain-able.

## GeoCoding

```php
<?php
$geoCoder = new GeoCoder(API_KEY, API_SECRET);

$results = $geoCoder->locate("addressstring 1a city")->search();

print_R($results);
```

## Routes

```php
<?php
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

```

## Mapview
To get a imagestring of the map you could use the mapview option. 
the map has several options for displaying. It can also display the
poi on the map.

```php
<?php
 $map  = new Mapview(API_KEY, API_SECRET);

$result = $map
    ->coordinates(51.97109267, 5.26213026)
    ->pointsOfInterest(
        [
            52.05811712, 5.47741202,
            52.11244458, 5.36696158,
            51.97504327, 5.24482833
        ]
    )
    ->uncertainty(1000)
    ->type(2)
    ->get();

echo "<img src='data:image/png;base64, ".base64_encode($result)."'>";
```
