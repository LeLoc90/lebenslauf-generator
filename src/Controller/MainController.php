<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function getAllResumes(): Response
    {
        $resumeRepository = $this->entityManager->getRepository(Resume::class);
        $resumes = $resumeRepository->getAllResumesWithRelatedObjects();
        return $this->render('pages/index.html.twig', [
            'resumes' => $resumes,
        ]);
    }

    /**
     * @throws Exception
     */
    public function createResume(Request $request, FileUploader $fileUploader): Response
    {
        $resume = new Resume();
        $form = $this->createForm(ResumeFormType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resume = $form->getData();
            $languages = $resume->getLanguages();
            $projects = $resume->getProjects();

            foreach ($languages as $language) {
                $this->entityManager->persist($language);
            }
            foreach ($projects as $project) {
                $this->entityManager->persist($project);
            }

            $this->entityManager->persist($resume);
            $this->entityManager->flush();

            return $this->redirectToRoute('get-all-resumes');
        }

        return $this->render('pages/_resume_form.html.twig', [
            'form' => $form,
            'resume' => $resume
        ]);
    }

    public function editResume(Request $request, string $ulid, FileUploader $fileUploader): Response
    {
        $resume = $this->entityManager->getRepository(Resume::class)->getResumeWithRelatedObjects($ulid)[0];
        if (!$resume) {
            throw $this->createNotFoundException('Keine Lebenslauf mit der ULID gefunden:' . $ulid);
        }

        $form = $this->createForm(ResumeFormType::class, $resume);
        $data = $form->getData();

        $languages = array_map(function ($language) {
            return $language->toArray();
        }, $data->getLanguages()->toArray());

        $projects = array_map(function ($project) {
            return $project->toArray();
        }, $data->getProjects()->toArray());
        $liveViewData = [
            "name" => $data->getName(),
            "birthdate" => $data->getBirthdate() ? $data->getBirthdate()->format('Y-m-d') : '',
            "schoolGraduation" => $data->getSchoolGraduation(),
            "trainingGraduation" => $data->getTrainingGraduation(),
            "positions" => $data->getPositions(),
            "languages" => $languages,
            "programmingLanguages" => $data->getProgrammingLanguages(),
            "tools" => $data->getTools(),
            "projects" => $projects,
            "photo" => $data->getPhoto(),
        ];

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resume = $form->getData();
            $languages = $resume->getLanguages();
            $projects = $resume->getProjects();

            foreach ($languages as $language) {
                $this->entityManager->persist($language);
            }
            foreach ($projects as $project) {
                $this->entityManager->persist($project);
            }

            $this->entityManager->persist($resume);
            $this->entityManager->flush();

            return $this->redirectToRoute('edit-resume', ['ulid' => $ulid]);
        }

        return $this->render('pages/_resume_form.html.twig', [
            'form' => $form,
            'resume' => $resume,
            'liveViewData' => $liveViewData,
            'photo' => $liveViewData['photo']
        ]);
    }

    public function deleteResume(string $ulid): Response
    {

        $resume = $this->entityManager->getRepository(Resume::class)->find($ulid);
        if (!$resume) {
            throw $this->createNotFoundException('Keine Lebenslauf mit der ULID gefunden:' . $ulid);
        }

        $photo = $resume->getPhoto();
        if ($photo) {
            $projectDir = $this->getParameter('kernel.project_dir');
            $photoPath = $projectDir . '/public/build/images/' . $photo;

            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $languages = $resume->getLanguages();
        $projects = $resume->getProjects();

        foreach ($languages as $language) {
            $this->entityManager->remove($language);
        }

        foreach ($projects as $project) {
            $this->entityManager->remove($project);
        }

        $this->entityManager->remove($resume);
        $this->entityManager->flush();

        return $this->redirectToRoute('get-all-resumes', [], Response::HTTP_SEE_OTHER);
    }
}

