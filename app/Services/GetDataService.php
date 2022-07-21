<?php

namespace App\Services;

use ArrayObject;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetDataService
{
    private $api_url;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->api_url = config('app.api_url');
    }

    public function getDataFromType($type)
    {
        if($type)
        {
            $response = Http::get("$this->api_url/$type");
            if($response->successful())
            {
                $data = json_decode($response->getBody()->getContents());
                return $data;
            }
            else
                $response->throw();
        }
        return null;
    }

    public function getDataWithParam($endpoint,array $param) : object
    {
        if($endpoint)
        {
            $response = Http::get("$this->api_url/$endpoint",$param);
            if($response->successful())
            {
                $data = json_decode($response->getBody()->getContents());
                return $data;
            }
            else
                $response->throw();
        }
        return null;
    }


}
