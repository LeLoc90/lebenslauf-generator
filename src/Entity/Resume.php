<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use App\Service\IDService;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Resume
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $ulid;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $schoolGraduation = null;

    #[ORM\Column(length: 255)]
    private ?string $trainingGraduation = null;

    #[ORM\Column(type: Types::ARRAY)]
    private ?array $positions = [];

    #[ORM\Column(type: Types::ARRAY)]
    private ?array $programmingLanguages = [];

    #[ORM\Column(type: Types::ARRAY)]
    private ?array $tools = [];

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'resume')]
    private Collection $projects;

    #[ORM\OneToMany(targetEntity: Language::class, mappedBy: 'resume')]
    private Collection $languages;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    public function __construct()
    {
        $this->ulid ??= IDService::MakeULID(new DateTime("now"));
        $this->projects = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    /**
     * @return void
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at = new DateTimeImmutable("now");
        if (!$this->updated_at) {
            $this->updated_at = new DateTimeImmutable("now");
        }
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new DateTimeImmutable("now");
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getSchoolGraduation(): ?string
    {
        return $this->schoolGraduation;
    }

    public function setSchoolGraduation(?string $schoolGraduation): static
    {
        $this->schoolGraduation = $schoolGraduation;

        return $this;
    }

    public function getTrainingGraduation(): ?string
    {
        return $this->trainingGraduation;
    }

    public function setTrainingGraduation(?string $trainingGraduation): static
    {
        $this->trainingGraduation = $trainingGraduation;

        return $this;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(?array $positions): static
    {
        $this->positions = $positions;

        return $this;
    }

    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(?array $programmingLanguages): static
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function getTools(): array
    {
        return $this->tools;
    }

    public function setTools(?array $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setResume($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getResume() === $this) {
                $project->setResume(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->setResume($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getResume() === $this) {
                $language->setResume(null);
            }
        }

        return $this;
    }

    public function getBirthdate(): ?DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }
}
