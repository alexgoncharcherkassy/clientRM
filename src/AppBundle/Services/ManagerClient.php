<?php
/**
 * Created by PhpStorm.
 * User: device
 * Date: 15.04.16
 * Time: 20:28
 */

namespace AppBundle\Services;


use Guzzle\Http\Client;

/**
 * Class ManagerClient
 * @package AppBundle\Services
 */
class ManagerClient
{
    /**
     * @var
     */
    private $param;
    /**
     * @var Client
     */
    private $client;

    /**
     * @param $param
     */
    public function __construct($param)
    {
        $this->param = $param;

        $this->client = new Client('https://redmine.ekreative.com/', [
            'request.options' => [
                'headers' => ['X-Redmine-API-Key' => $this->param]
            ]
        ]);
    }

    /**
     * @param $url
     * @param null $param
     * @return \Guzzle\Http\Message\Response
     */
    public function get($url, $param = null)
    {
        $request = $this->client->get($url.'.json'.$param);
        $response = $request->send();

        return $response;
    }


    /**
     * @param $url
     * @param $body
     * @return \Guzzle\Http\Message\Response
     */
    public function post($url, $body)
    {
        $request = $this->client->post($url.'.json',[], $body);
        $response = $request->send();

        return $response;
    }

}