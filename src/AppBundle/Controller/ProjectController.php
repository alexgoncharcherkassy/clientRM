<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @package AppBundle\Controller
 */
class ProjectController extends Controller
{
    /**
     * @Route("/project/{id}", name="show_project", requirements={"id" : "\d+"})
     * @Template("@App/project/showProject.html.twig")
     */
    public function showProjectAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AppBundle:Comment')
            ->findBy(['idProject' => $id], ['createdAt' => 'DESC']);

        $response = $this->get('client_manager')->get('projects/'.$id, '?include=trackers,issue_categories,enabled_modules');

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $comment->setIdProject($id);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('show_project', ['id' => $id]);
        }

        return [
            'form' => $form->createView(),
            'projects' => json_decode($response->getBody(), true),
            'comments' => $comments
        ];
    }

    /**
     * @Route("/project/{id}/issues", name="show_issues_project", requirements={"id" : "\d+"})
     * @Template("@App/issues/showAllIssues.html.twig")
     */
    public function showIssuesPerProjectAction($id)
    {
        $response = $this->get('client_manager')->get('issues', '?project_id='.$id);

        return [
            'issues' => json_decode($response->getBody(), true)
        ];
    }
}
