<?php

namespace geertBoetzkes\heremaps;

use Httpful\Request;

class GeoCoder
{
    const BASE = "https://geocoder.api.here.com/6.2/geocode.json";

    private $key;
    private $secret;

    private $search;
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function locate($addressString){
        $this->search = $addressString;
        return $this;
    }

    public function search(){

        $param = http_build_query(array(
            'app_id' => $this->key,
            'app_code' => $this->secret,
            'searchtext' => urlencode($this->search),
        ));

        $request = Request::get(self::BASE."?".$param)->send();

        $views = $request->body->Response->View;

        if (count($views) > 0){
            $index = array_search("SearchResultsViewType", array_column($views, '_type'));
            if ($index !== false){
                $searchResult = $views[$index]->Result;

                $highest = max(array_column($searchResult, 'Relevance'));

                return array_filter(array_map(function ($searchResult) use ($highest) {
                    return $searchResult->Relevance == $highest ? $searchResult->Location : null;
                }, $searchResult));
            }
        }

        trigger_error("No result found with this these strings");
    }
}
