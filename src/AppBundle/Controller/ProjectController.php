<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
    /**
     * @Route("/project/{id}", name="show_project", requirements={"id" : "\d+"})
     * @Template("@App/project/showProject.html.twig")
     */
    public function showProjectAction($id)
    {
        $response = $this->get('client_manager')->get('projects/'.$id, '?include=trackers,issue_categories,enabled_modules');

        return [
          'data' => json_decode($response->getBody(), true)
        ];
    }

    /**
     * @Route("/issues", name="show_all_issues")
     * @Template("@App/project/showAllIssues.html.twig")
     */
    public function showAllIssues()
    {
        $response = $this->get('client_manager')->get('issues');

        return [
            'data' => json_decode($response->getBody(), true)
        ];
    }
}
