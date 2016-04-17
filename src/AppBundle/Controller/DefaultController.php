<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("@App/index.html.twig")
     */
    public function indexAction()
    {
        $response = $this->get('client_manager')->get('projects');

        return [
            'projects' => json_decode($response->getBody(), true)
        ];
    }
}
