<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TimeEntry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TimeEntryType;

/**
 * Class TimeEntryController
 * @package AppBundle\Controller
 */
class TimeEntryController extends Controller
{
    /**
     * @Route("/time_entry/{projectId}/{issueId}", name="time_entry", requirements={"projectId" : "\d+", "issueId" : "\d+"})
     * @Template("@App/timeEntry/createTimeEntry.html.twig")
     */
    public function createTimeEntryAction($projectId, $issueId = null, Request $request)
    {
        $timeEntry = new TimeEntry();
        $form = $this->createForm(TimeEntryType::class, $timeEntry, [
            'projectId' =>  $projectId,
            'issueId' => $issueId
        ]);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $timeEntry->setIssueId($issueId);
            $response = $this->get('client_manager')->post('time_entries', $timeEntry->toArray());
            if($response->isError()){
                $this->addFlash('notice', 'Time entry was not created due to validation failures');
            } else {
                $this->addFlash('notice', "Time entry was created");
            }

            return $this->redirectToRoute('show_project', ['id' => $projectId]);
        }

        return [
            'form' => $form->createView()
        ];
    }
}
