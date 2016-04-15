<?php

namespace AppBundle\Controller;

use Guzzle\Http\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("@App/index.html.twig")
     */
    public function indexAction()
    {
        $client = new Client('https://redmine.ekreative.com/', [
            'request.options' => [
                'headers' => array('X-Redmine-API-Key' => $this->getParameter('x-redmine-api-key')),
            ]
        ]);
        $request = $client->get('projects.json');
        $response = $request->send();

        return [
            'data' => json_decode($response->getBody(), true)
        ];
    }
}
