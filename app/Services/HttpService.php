<?php

namespace App\Services;

use ArrayObject;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class HttpService
{
    private $api_url;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->api_url = config('app.api_url');
    }

    public function postDataWithBody($endpoint, $body, $headers = [])
    {
            $response = Http::withHeaders($headers)->post("$this->api_url/$endpoint",$body);
            if($response->successful())
            {
                $payload = json_decode($response->getBody()->getContents());
                return $payload;
            }
            elseif( $response->status() == 401)
                return error('login','Unauthorized');
            elseif( $response->status() == 402)
            {
                $payload = json_decode($response->getBody()->getContents());
                return $payload;
            }
            else
                $response->throw();
    }


    public function updateDataWithBody($endpoint, $id, array $body, $headers)
    {
        $url = "$this->api_url/$endpoint/$id";

        $response = Http::withHeaders($headers)->patch($url,$body);
        if($response->successful() || $response->status() == 402)
        {
            $payload = json_decode($response->getBody()->getContents());
            return $payload;
        }
        elseif( $response->status() == 401)
            return json_decode($response->getBody()->getContents());
        else
            $response->throw();

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
            else
                $response->throw();
        }

        return null;
    }

    public function deletedData($endpoint, $id, array $body, $headers)
    {
        $url = "$this->api_url/$endpoint/$id";

        $response = Http::withHeaders($headers)->delete($url,$body);
        if($response->successful())
        {
            $data = json_decode($response->getBody()->getContents());
            return $data;
        }elseif($response->status() == 401)
        {
            return error('logout');
        }
        else
           return $response->throw();

    }

    public function updateDataWithOptions($endpoint, $id, $options, $headers = [])
    {
        $client = new Client();
        $request = new Request('POST', "$this->api_url/$endpoint/$id", $headers);
        $response = $client->sendAsync($request, $options)->wait();
        $payload = json_decode($response->getBody()->getContents());
        return $payload;
    }

    public function postDataWithOptions($endpoint, $options, $headers = [])
    {
        $client = new Client();
        $request = new Request('POST', "$this->api_url/$endpoint", $headers);
        $response = $client->sendAsync($request, $options)->wait();
        $payload = json_decode($response->getBody()->getContents());
        return $payload;
    }


}
