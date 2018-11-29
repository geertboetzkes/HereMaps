<?php
/**
 * Created by PhpStorm.
 * User: geertboetzkes
 * Date: 26/11/2018
 * Time: 09:46
 */

namespace geertBoetzkes\heremaps;

use http\Env\Request;

class Mapview
{
    const BASE = "https://image.maps.api.here.com/mia/1.6/mapview";

    private $key;
    private $secret;

    protected $x;
    protected $y;
    protected $zoomLevel= null;
    protected $uncertainty = null;
    protected $maptype = 0;
    protected $languageCode = null;
    protected $imageFormat = 1;
    protected $height = null;
    protected $width = null;
    protected $noCrop = false;
    protected $poi = [];

    /**
     * Mapview constructor.
     * @param $key
     * @param $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param float $x
     * @param float $y
     * @return $this
     */
    public function coordinates(float $x, float $y){
        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    /**
     * @param int $level
     * @return $this
     */
    public function zoomlevel(int $level){
        $this->zoomLevel = $level;

        return $this;
    }

    /**
     * @param string $level
     * @return $this
     */
    public function uncertainty(int $level){
        $this->uncertainty = $level;

        return $this;
    }

    /**
     * @param int $type
     * @return $this
     */
    public function type(int $type){

//        0 (normal.day) Normal map view in day light mode.
//        1 (satellite.day) Satellite map view in day light mode.
//        2 (terrain.day) Terrain map view in day light mode.
//        3 (hybrid.day) Satellite map view with streets in day light mode.
//        4 (normal.day.transit) Normal grey map view with public transit in day light mode.
//        5 (normal.day.grey) Normal grey map view in day light mode (used for background maps).
//        6 (normal.day.mobile) Normal map view for small screen devices in day light mode.
//        7 (normal.night.mobile) Normal map view for small screen devices in night mode.
//        8 (terrain.day.mobile) Terrain map view for small screen devices in day light mode.
//        9 (hybrid.day.mobile) Satellite map view with streets for small screen devices in day light mode.
//        10 (normal.day.transit.mobile) Normal grey map view with public transit for small screen devices in day light mode.
//        11 (normal.day.grey.mobile)
//        12 (carnav.day.grey) Map view designed for navigation devices.
//        13 (pedestrian.day) Map view designed for pedestrians walking by day.
//        14 (pedestrian.night) Map view designed for pedestrians walking by night.


        $this->maptype = $type;

        return $this;
    }

    /**
     * @param string $languageCode
     * @return $this
     */
    public function language(string $languageCode){
//            ara – Arabic
//            baq – Basque
//            cat – Catalan
//            chi – Chinese (simplified)
//            cht – Chinese (traditional)
//            cze – Czech
//            dan – Danish
//            dut – Dutch
//            eng – English
//            fin – Finnish
//            fre – French
//            ger – German
//            gle – Gaelic
//            gre – Greek
//            heb – Hebrew
//            hin – Hindi
//            ind – Indonesian
//            ita – Italian
//            nor – Norwegian
//            per – Persian
//            pol – Polish
//            por – Portuguese
//            rus – Russian
//            sin – Sinhalese
//            spa – Spanish
//            swe – Swedish
//            tha – Thai
//            tur – Turkish
//            ukr – Ukrainian
//            urd – Urdu
//            vie – Vietnamese
//            wel – Welsh

        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * @param int $format
     * @return $this
     */
    public function format(int $format){
//        0 PNG
//        1 JPEG (default)
//        2 GIF
//        3 BMP
//        4 PNG8
//        5 SVG (only for companylogo)

        $this->imageFormat = $format;

        return $this;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function height(int $height){
        $this->height = $height;

        return $this;
    }

    /**
     * @param int $width
     * @return $this
     */
    public function width(int $width){
        $this->width = $width;

        return $this;
    }

    /**
     * @param bool $crop
     */
    public function noCrop(bool $crop){
        $this->noCrop = $crop;

        return $this;
    }

    /**
     * @param array $list
     * @return $this
     */
    public function pointsOfInterest(array $list){
        $this->poi = $list;

        return $this;
    }



    public function get(){

        $queryList = array(
            "app_id"        => $this->key,
            "app_code"      => $this->secret,

            "t"             => $this->maptype,
            "f"             => $this->imageFormat,
        );


        if (!is_null($this->x) && !is_null($this->y)){
            $queryList["c"] = $this->x.",".$this->y;
        }

        if (!is_null($this->zoomLevel)){
            $queryList["z"] = $this->zoomLevel;
        }

        if (!is_null($this->height)){
            $queryList["h"] = $this->height;
        }

        if (!is_null($this->width)){
            $queryList["w"] = $this->width;
        }

        if (!is_null($this->uncertainty)){
            $queryList["u"] = $this->uncertainty;
        }

        if ($this->noCrop){
            $queryList["nocrop"] = '';
        }

        if (!is_null($this->languageCode)){
            $queryList["u"] = $this->uncertainty;
        }

        if (count($this->poi) > 0){
            $queryList["poi"] = implode(",", $this->poi);
        }

        $request = Request::get(self::BASE."?".http_build_query($queryList))->send();


        return $request->body;
    }
}
