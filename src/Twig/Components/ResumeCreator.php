<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\DTO\ResumeDTO;
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
    public ?string $photoLiveSrc = "";

    #[LiveProp(writable: true, onUpdated: 'updateIsConverting')]
    public bool $isConverting = false;

    #[LiveProp(writable: true)]
    public array $formData = [
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
    #[LiveProp(writable: true)]
    public ?string $photoForPDF = "";


    /*    #[LiveProp(writable: true)]
        public array $formData = [
            "name" => "Maxx Mustermann",
            "birthdate" => "1999-11-11T00:00:00+00:00",
            "schoolGraduation" => "Abitur",
            "trainingGraduation" => "Fachinformatiker Anwendungsentwickler",
            "positions" => [
                "Lead-Entwickler",
                "Frontend-Entwickler",
            ],
            "photo" => null,
            "languages" => [
                [
                    "id" => null,
                    "title" => "Deutsch",
                    "level" => 5
                ],
                [
                    "id" => null,
                    "title" => "Englisch",
                    "level" => 4
                ]
            ],
            "programmingLanguages" => [
                "HTML",
                "CSS",
                "PHP",
                "JavaScript"
            ],
            "tools" => [
                "Scrum",
                "Jira",
                "Docker",
                "Atlassian Stack",
                "PHPStorm"
            ],
            "projects" => [
                [
                    "id" => null,
                    "title" => "Projekt 1",
                    'year' => 2021,
                    "description" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                    "technologies" => [
                        "Technology1",
                        "Technology2",
                        "Technology3",
                        "Technology4",
                        "Technology5"
                    ],
                    "task" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                    "workflow" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
                ],
                [
                    "id" => null,
                    "title" => "Projekt 2",
                    "year" => 2022,
                    "description" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                    "technologies" => [
                        "Technology1",
                        "Technology2",
                        "Technology3",
                        "Technology4"
                    ],
                    "task" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                    "workflow" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
                ]
            ]
        ];*/


    #[LiveProp]
    public ?ResumeDTO $initialFormData = null;

    public function __construct(
        protected Environment $environment,
    )
    {
    }

    #[LiveAction]
    public function uploadPhoto(Request $request, FileUploader $fileUploader)
    {
        $uploadedFile = $request->files->get('resume_form')['photo'] ?? null;
        if ($uploadedFile) {
            try {
                $fileName = $fileUploader->upload($uploadedFile);
                // Set the relative path (without a leading slash, so asset() works correctly)
                $this->photoLiveSrc = 'build/images/' . $fileName;

                // copy the file from public/build/images to assets/images for PDF generation.
                $projectDir = $this->getParameter('kernel.project_dir');
                $sourcePath = $projectDir . '/public/build/images/' . $fileName;
                $destinationPath = $projectDir . '/assets/images/' . $fileName;

                if (!copy($sourcePath, $destinationPath)) {
                    throw new Exception("Failed to copy file to assets/images directory");
                }

                // store the PDF-specific path in formData.
                $this->photoForPDF = $fileName;

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
    public function pdfGenerator(FileUploader $fileUploader)
    {
        $renderedForm = $this->getTemplateHTML();

        $projectDir = $this->getParameter('kernel.project_dir');
        $pdfPath = $projectDir . '/public/pdfs';

        $gotenbergRequest = $this->createGotenbergRequest($renderedForm);
        $filename = Gotenberg::save($gotenbergRequest, $pdfPath);
        $fullPath = $pdfPath . '/' . $filename;

        if (file_exists($fullPath)) {
            $this->addFlash('success', 'PDF wird erstellt, bitte warten!');
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
        $outputFileName = 'Lebenslauf_' . str_replace(' ', '_', $this->formData['name']) . time();

        $baseRequest = Gotenberg::chromium($_ENV['GOTENBERG_DSN'])
            ->pdf()
            ->outputFilename($outputFileName)
            ->margins(0, 0, 0, 0)
            ->paperSize('210mm', '297mm');

        if ($this->template == 1) {
            $request = $baseRequest
                ->assets(Stream::path($assetPath . '/coding.jpg'))
                ->assets(Stream::path($assetPath . '/' . $this->photoForPDF))
                ->html(Stream::string('index.html', $renderedForm));
        } else {
            $request = $baseRequest
                ->assets(Stream::path($assetPath . '/' . $this->photoForPDF))
                ->html(Stream::string('index.html', $renderedForm));
        }
        return $request;
    }

    protected function instantiateForm(): FormInterface
    {
        $this->updateResume();
        return $this->createForm(ResumeFormType::class, $this->initialFormData);
    }

    public function updateResume(): void
    {
        if ($this->formValues) {
            $this->formData = $this->formValues;
        }
    }
}
