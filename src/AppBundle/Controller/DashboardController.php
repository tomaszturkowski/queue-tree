<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Problem;
use AppBundle\Entity\Project;
use AppBundle\Form\ProblemType;
use AppBundle\Form\ProjectType;
use AppBundle\Form\SwitchProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // determine project context
        $contextProject = $this->get('app.repository.project')->findOneById($request->get('projectId'));
        if (!$contextProject) {
            $contextProject = $this->get('app.repository.project')->findFirst();
        }
        $contextProblem = $this->get('app.repository.problem')->findOneById($request->get('problemId'));

        $projectForm = $this->createForm(new ProjectType());
        $problemForm = $this->createForm(new ProblemType());
        $switchingForm = $this->createForm(new SwitchProjectType());

        if ($projectForm->handleRequest($request)->isValid()) {
            $project = new Project();
            $project->setValue($projectForm->get('value')->getData());

            $this->get('doctrine.orm.entity_manager')->persist($project);
            $this->get('doctrine.orm.entity_manager')->flush();

            $rootProblem = new Problem($project);
            $rootProblem->setValue('-');
            $rootProblem->setStatus(Problem::STATUS_NEW);
            $rootProblem->setType(Problem::TYPE_ROOT);

            $this->addFlash('notice', 'Project created!');
            $this->redirectToRoute('homepage', [
                'projectId' => $project->getId(),
            ]);
        }

        if ($problemForm->handleRequest($request)->isValid()) {
            $problem = new Problem($contextProject);
            $problem->setType($problemForm->get('type')->getData());
            $problem->setValue($problemForm->get('value')->getData());
            $this->get('doctrine.orm.entity_manager')->persist($problem);
            $this->get('doctrine.orm.entity_manager')->flush();
            $this->addFlash('notice', 'Problem added!');

            // redirect to the project in turn
            $this->redirectToRoute('homepage', [
                'projectId' => $problem->getProject()->getId(),
                'problemAtHand' => $problem->getId(),
            ]);
        }

        if ($switchingForm->handleRequest($request)->isValid()) {
            // here redirect to different selected project
            $projectId = $switchingForm->get('project')->getData()->getId();
            $this->redirectToRoute('homepage', [
                'projectId' => $projectId,
            ]);
        }

        return $this->render('AppBundle:default:index.html.twig', [
            'project_form' => $projectForm->createView(),
            'problem_form' => $problemForm->createView(),
            'switching_form' =>  $switchingForm->createView(),
        ]);
    }
}
