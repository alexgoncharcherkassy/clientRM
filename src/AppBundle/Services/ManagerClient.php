<?php
/**
 * Created by PhpStorm.
 * User: device
 * Date: 15.04.16
 * Time: 20:28
 */

namespace AppBundle\Services;


use Guzzle\Http\Client;

class ManagerClient
{
    private $param;

    public function __construct($param)
    {
        $this->param = $param;
    }
    private function createClient()
    {
        $client = new Client('https://redmine.ekreative.com/', [
            'request.options' => [
                'headers' => ['X-Redmine-API-Key' => $this->param]
            ]
        ]);

        return $client;
    }

    public function get($url, $param = null)
    {
        $request = $this->createClient()->get($url.'.json'.$param);
        $response = $request->send();

        return $response;
    }

}