<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\Resume;
use App\Form\ResumeFormType;
use App\Service\FileUploader;
use Exception;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Exceptions\NoOutputFileInResponse;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsLiveComponent]
class ResumeCreator extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true)]
    public int $template = 1;
    #[LiveProp(writable: true)]
    public ?string $photoForPDF = "";

    #[LiveProp(writable: true,
        hydrateWith: 'hydrateFormData',
        dehydrateWith: 'dehydrateFormData')]
    public ?array $formData = [
        "name" => "",
        "birthdate" => "",
        "schoolGraduation" => "",
        "trainingGraduation" => "",
        "positions" => [],
        "languages" => [],
        "programmingLanguages" => [],
        "tools" => [],
        "projects" => [],
    ];

    #[LiveProp]
    public ?Resume $initialFormData = null;

    public function __construct(
        protected Environment $environment,
    )
    {
    }

    public static function dehydrateFormData(?array $formData): string
    {
        return json_encode($formData);
    }

    public static function hydrateFormData(string $jsonData): ?array
    {
        return json_decode($jsonData, true);
    }

    #[LiveAction]
    public function uploadPhoto(Request $request, FileUploader $fileUploader)
    {
        $uploadedFile = $request->files->get('resume_form')['uploadPhoto'] ?? null;
        if ($uploadedFile) {
            try {
                $fileName = $fileUploader->upload($uploadedFile);
                $this->photoForPDF = $fileName;
                $this->formValues['photo'] = $this->photoForPDF;
            } catch (Exception $e) {
                return $this->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws GotenbergApiErrored
     * @throws NoOutputFileInResponse
     */
    #[LiveAction]
    public function generatePDF(FileUploader $fileUploader)
    {
        $renderedForm = $this->getTemplateHTML();

        $projectDir = $this->getParameter('kernel.project_dir');
        $pdfPath = $projectDir . '/public/pdfs';

        $gotenbergRequest = $this->createGotenbergRequest($renderedForm);
        $filename = Gotenberg::save($gotenbergRequest, $pdfPath);
        $fullPath = $pdfPath . '/' . $filename;

        if (file_exists($fullPath)) {
            $this->addFlash('success', 'PDF wurde erfolgreich erstellt!');
        } else {
            $this->addFlash('error', 'PDF konnte nicht erstellt werden!');
        }
    }

    private function getTemplateHTML(): string
    {
        $data = $this->formData;
        $templateName = 'resumes/pdf_template_' . $this->template . '.html.twig';

        if (!$this->photoForPDF) {
            $this->photoForPDF = 'profilePlaceholder.png';
        }

        $renderedForm = $this->environment->render($templateName, [
            'profilePhoto' => $this->photoForPDF,
            'formData' => $data,
        ]);
        return $renderedForm;
    }

    private function createGotenbergRequest(string $renderedForm)
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $assetPath = $projectDir . '/assets/images';
        $publicPath = $projectDir . '/public/build/images';
        $outputFileName = 'Lebenslauf_' . str_replace(' ', '_', $this->formData['name']) . time();

        $baseRequest = Gotenberg::chromium($_ENV['GOTENBERG_DSN'])
            ->pdf()
            ->outputFilename($outputFileName)
            ->margins(0, 0, 0, 0)
            ->paperSize('210mm', '297mm');

        if ($this->template == 1) {
            $request = $baseRequest
                ->assets(Stream::path($assetPath . '/coding.jpg'))
                ->assets(Stream::path($publicPath . '/' . $this->photoForPDF))
                ->html(Stream::string('index.html', $renderedForm));
        } else {
            $request = $baseRequest
                ->assets(Stream::path($publicPath . '/' . $this->photoForPDF))
                ->html(Stream::string('index.html', $renderedForm));
        }
        return $request;
    }

    protected function instantiateForm(): FormInterface
    {
        $this->updateLiveView();
        return $this->createForm(ResumeFormType::class, $this->initialFormData);
    }

    public function updateLiveView(): void
    {
        if ($this->formValues) {
            $this->formData = $this->formValues;
        }
    }
}
