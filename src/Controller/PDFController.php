<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected string                 $targetDirectory)
    {
    }

    public function getAllPdfs(): Response
    {
        $files = glob($this->getTargetDirectory() . '/*.pdf');
        $pdfs = [];

        foreach ($files as $file) {
            $relativePath = str_replace($this->getTargetDirectory(), '/pdfs', $file);
            $filename = basename($relativePath);
            $pdfs[] = [
                'filename' => $filename,
                'path' => $relativePath,
            ];
        }
        return $this->render('pages/pdfs_list.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function deletePdf(string $filename): Response
    {
        $path = $this->getTargetDirectory() . '/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $this->redirectToRoute('get-all-pdfs', [], Response::HTTP_SEE_OTHER);
    }

    public function deleteAllPdfs(): Response
    {
        $files = glob($this->getTargetDirectory() . '/*.pdf');
        foreach ($files as $file) {
            unlink($file);
        }
        return $this->redirectToRoute('get-all-pdfs', [], Response::HTTP_SEE_OTHER);
    }
}

