<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function index(): Response
    {
        $resumeRepository = $this->entityManager->getRepository(Resume::class);
        $resumes = $resumeRepository->getAllResumesWithRelatedObjects();
        return $this->render('pages/index.html.twig', [
            'resumes' => $resumes,
        ]);
    }

    public function createResume(Request $request): Response
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

            return $this->redirectToRoute('resume-index');
        }

        return $this->render('pages/_resume_form.html.twig', [
            'form' => $form,
            'resume' => $resume
        ]);
    }

    public function editResume(Request $request, string $ulid, SerializerInterface $serializer): Response
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

            return $this->redirectToRoute('resume-index');
        }

        return $this->render('pages/_resume_form.html.twig', [
            'form' => $form,
            'resume' => $resume,
            'liveViewData' => $liveViewData
        ]);
    }

    public function deleteResume(string $ulid): Response
    {

        $resume = $this->entityManager->getRepository(Resume::class)->find($ulid);
        if (!$resume) {
            throw $this->createNotFoundException('Keine Lebenslauf mit der ULID gefunden:' . $ulid);
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

        return $this->redirectToRoute('resume-index', [], Response::HTTP_SEE_OTHER);
    }

    public function getPdfs(): Response
    {
        // Get the project directory and the absolute path of the pdf folder.
        $projectDir = $this->getParameter('kernel.project_dir');
        $pdfDirectory = $projectDir . '/public/pdfs';

        // Use glob() to find all PDF files in the directory.
        $files = glob($pdfDirectory . '/*.pdf');
        $pdfs = [];

        // Convert each file path into a relative path for asset() usage.
        foreach ($files as $file) {
            // Remove the projectDir/public part to get the relative path.
            $relativePath = str_replace($projectDir . '/public/', '', $file);
            $filename = basename($relativePath);
            $pdfs[] = [
                'filename' => $filename,
                'path' => $relativePath,
            ];
        }

        // Render a template that lists the PDF files.
        return $this->render('pages/pdfs_list.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }

    public function deletePdf(string $filename): Response
    {
        // Get the project directory and the absolute path of the pdf folder.
        $projectDir = $this->getParameter('kernel.project_dir');
        $pdfDirectory = $projectDir . '/public/pdfs';

        // Check if the file exists.
        $fullPath = $pdfDirectory . '/' . $filename;
        if (file_exists($fullPath)) {
            // Delete the file.
            unlink($fullPath);
        }

        // Redirect to the list of PDF files.
        return $this->redirectToRoute('pdfs-index', [], Response::HTTP_SEE_OTHER);

    }
}

