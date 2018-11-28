<?php
/**
 * Created by PhpStorm.
 * User: geertboetzkes
 * Date: 26/11/2018
 * Time: 11:00
 */

namespace Hitmetal\HereMaps;


use Httpful\Request;

class Route
{
    const BASE = "https://route.api.here.com/routing/7.2/calculateroute.json";

    protected $key;
    protected $secret;
    protected $mode = RouteTypes::Fastest;
    protected $vehicle = RouteVehicles::Car;

    protected $waypoints = [];
    protected $traffic = true;
    protected $languageCode = null;

    public function __construct(string $key, string $secret){
        $this->key = $key;
        $this->secret = $secret;

        return $this;
    }


    public function mode(string $type){
        $this->mode = $type;

        return $this;
    }

    public function vehicle(string $type){
        $this->vehicle = $type;

        return $this;
    }

    public function AddWaypoint(RouteWaypoint $point){
        array_push($this->waypoints, $point);

        return $this;
    }

    public function RemoveWaypoint(int $index){
        if(array_key_exists($index, $this->waypoints)){
            unset($this->waypoints[$index]);
        }

        return $this;
    }

    public function language(string $language){
        $this->languageCode = $language;
        return $this;
    }
    public function trafficInfo(bool $info){
        $this->traffic = $info;

        return $this;
    }

    public function get(){
        $traffic  = $this->traffic? "enabled": "disabled";

        $queryList = array(
            "app_id" => $this->key,
            "app_code" => $this->secret,
            "mode"  => $this->mode.";".$this->vehicle.";traffic:".$traffic
        );

        if (!is_null($this->languageCode)){
            $queryList["ml"] = $this->languageCode;
        }

        foreach($this->waypoints as $index => $waypoint){
            $queryList["waypoint".$index] = $waypoint->parse();
        }

        $url = self::BASE. "?" . http_build_query($queryList);

        return Request::get($url)->send()->body->response;
    }

}

class RouteWaypoint{
    protected $x;
    protected $y;

    public function __construct(float $x, float $y){
        $this->x = $x;
        $this->y = $y;
    }

    public function parse(){
        return "geo!".$this->x.",".$this->y;
    }
}

class RouteVehicles{
    const Car               = "car";
    const Truck             = "truck";
    const PublicTransport   = "publicTransport";
    const Bicycle           = "bicycle";
}

class RouteTypes{
    const Fastest           = "fastest";
    const Shortest          = "shortest";
    const Balanced          = "balanced";
}
