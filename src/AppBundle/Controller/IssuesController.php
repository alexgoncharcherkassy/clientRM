<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IssuesController
 * @package AppBundle\Controller
 */
class IssuesController extends Controller
{
    /**
     * @Route("/issues", name="show_all_issues")
     * @Template("@App/issues/showAllIssues.html.twig")
     */
    public function showAllIssuesAction(Request $request)
    {
        $page = $request->get('page', 1);
        $pagination = $this->get('custom_pagination')->pagination($page, 'ALL');

        return [
            'issues' => $pagination['response'],
            'pagination' => $pagination
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

}
