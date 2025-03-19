<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Resume;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function index(): Response
    {
        $resumeRepository = $this->entityManager->getRepository(Resume::class);
        $resumes = $resumeRepository->getProjectsJoinWithResumeProject();
//        dd($resumes);
        return $this->render('pages/index.html.twig', [
            'resumes' => $resumes,
        ]);
    }

    public function createResume()
    {

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
            $pdfs[] = $relativePath;
        }

        // Render a template that lists the PDF files.
        return $this->render('pages/pdfs_list.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }
}
