<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TimeEntryController extends Controller
{
    /**
     * @Route("/time_entry/{projectId}/{issueId}", name="time_entry", requirements={"id" : "\d+"})
     * @Template("@App/timeEntry/createTimeEntry.html.twig")
     */
    public function createTimeEntryAction($projectId, $issueId = null, Request $request)
    {
        return $this->get('time_entry_manager')->process($request, $projectId, $issueId);
    }
}
