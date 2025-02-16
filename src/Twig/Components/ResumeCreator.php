<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\DTO\ResumeDTO;
use App\Form\ResumeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent]
class ResumeCreator extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;
    use ComponentWithFormTrait;

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

    /*    #[LiveProp(writable: true)]
        public array $formData = [
            "name" => "Maxx Mustermann",
            "birthdate" => "1999-11-11T00:00:00+00:00",
            "schoolGraduation" => "Abitur",
            "trainingGraduation" => "Fachinformatiker Anwendungsentwickler",
            "positions" => [
                "Lead-Entwickler",
                "Frontend-Entwickler"
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

//    #[LiveAction]
//    public function save()
//    {
//        $this->submitForm();
//
//        $data = $this->getForm()->getData();
//        dd($data);
//        return $this->redirectToRoute('create-resume');
//    }

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
