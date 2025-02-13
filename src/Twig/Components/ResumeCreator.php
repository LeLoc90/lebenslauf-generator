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

    #[LiveProp]
    public ?ResumeDTO $initialFormData = null;

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
