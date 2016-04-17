<?php
/**
 * Created by PhpStorm.
 * User: device
 * Date: 16.04.16
 * Time: 14:32
 */

namespace AppBundle\Services;

use AppBundle\Entity\TimeEntry;
use AppBundle\Form\TimeEntryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
/**
 * Class RedmineManager
 * @package AppBundle\Services
 */
class TimeEntryManager
{
    /**
     * @var ManagerClient
     */
    private $redmineManager;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @param ManagerClient $redmineManager
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     * @param Session $session
     */
    public function __construct(ManagerClient $redmineManager,
                                FormFactoryInterface $formFactory,
                                RouterInterface $router,
                                Session $session)
    {
        $this->redmineManager = $redmineManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @param Request $request
     * @param null $projectId
     * @param null $issueId
     * @return array|RedirectResponse
     */
    public function process(Request $request, $projectId = null, $issueId = null)
    {
        $timeEntry = new TimeEntry();
        $form = $this->formFactory->create(TimeEntryType::class, $timeEntry, [
            'projectId' =>  $projectId,
            'issueId' => $issueId
        ]);
        $form->add('submit', SubmitType::class, ['label' => 'Save', 'attr' => [ 'class' => 'btn btn-primary' ]]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $timeEntry->setIssueId($issueId);
            $response = $this->redmineManager->post('time_entries', $timeEntry->toArray());
            if($response->isError()){
                $this->session->getFlashBag()->add('notice', 'Time entry was not created due to validation failures');
            } else
                $this->session->getFlashBag()->add('notice', "Time entry was created");

            $url = $this->router->generate('show_project', ['id' => $projectId]);

            return new RedirectResponse($url, 301);
        }

        return [
            'form' => $form->createView()
        ];
    }
}