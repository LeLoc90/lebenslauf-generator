<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function getAllPdfs(): Response
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
        return $this->redirectToRoute('get-all-pdfs', [], Response::HTTP_SEE_OTHER);

    }

    public function deleteAllPdfs(): Response
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $pdfDirectory = $projectDir . '/public/pdfs';
        $files = glob($pdfDirectory . '/*.pdf');
        foreach ($files as $file) {
            unlink($file);
        }
        return $this->redirectToRoute('get-all-pdfs', [], Response::HTTP_SEE_OTHER);
    }
}

