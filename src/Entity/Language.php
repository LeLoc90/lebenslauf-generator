<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use App\Service\IDService;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
//    #[ORM\Column(type: UlidType::NAME, unique: true)]
//    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
//    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(targetEntity: Resume::class, inversedBy: 'languages')]
    private ?Resume $resume = null;

    public function __construct()
    {
        $this->id ??= IDService::MakeULID(new DateTime('now'));
    }

    public function getId(): string
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): static
    {
        $this->resume = $resume;

        return $this;
    }
}
