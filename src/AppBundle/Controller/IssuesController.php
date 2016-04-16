<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IssuesController extends Controller
{
    /**
     * @Route("/issues", name="show_all_issues")
     * @Template("@App/issues/showAllIssues.html.twig")
     */
    public function showAllIssuesAction()
    {
        $response = $this->get('client_manager')->get('issues');

        return [
            'issues' => json_decode($response->getBody(), true)
        ];
    }

    /**
     * @Route("/issues/{id}", name="show_issue", requirements={"id" : "\d+"})
     * @Template("@App/issues/showIssue.html.twig")
     */
    public function showIssueAction($id)
    {
        $response = $this->get('client_manager')->get('issues/'.$id);

        return [
            'issues' => json_decode($response->getBody(), true)
        ];
    }

    /**
     * @Route("/issues/page/{page}", name="pagination", requirements={"page" : "\d+"}, defaults={"page" : 1})
     * @Template("@App/issues/showAllIssues.html.twig")
     */
    public function paginationIssuesAction($page)
    {

    }
}
