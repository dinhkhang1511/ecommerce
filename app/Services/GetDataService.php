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
            elseif($response->status() == 401)
            {
                return error('logout');
            }
            else
                $response->throw();
        }
        return null;
    }

    public function getDataWithParam($endpoint, array $param, $headers = [])
    {
        if($endpoint)
        {
            $response = Http::withHeaders($headers)->get("$this->api_url/$endpoint",$param);
            if($response->successful())
            {
                $data = json_decode($response->getBody()->getContents());
                return $data;
            }
            elseif($response->status() == 401)
            {
                return error('logout');
            }
            elseif($response->status()  == 404)
                return [];
            else
                $response->throw();
        }
        return null;
    }

    public function getDataFromId($endpoint,$id) : object
    {
        if($endpoint)
        {
            $response = Http::get("$this->api_url/$endpoint/$id");
            if($response->successful())
            {
                $data = json_decode($response->getBody()->getContents());
                return $data;
            }
            elseif($response->status() == 401)
            {
                return error('logout');
            }
            elseif($response->status() == 404)
            {
                return abort(404);
            }
            else
                $response->throw();
        }
        return null;
    }


}
