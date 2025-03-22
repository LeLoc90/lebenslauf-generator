<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Project;
use App\Entity\Resume;
use DateMalformedStringException;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResumeFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createLanguage(
            "Deutsch",
            5,
        );

        $this->createLanguage(
            "Englisch",
            4,
        );

        $this->createProject(
            "Internes Dashboard für Mustermann GmbH",
            2021,
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
            [
                "PHP",
                "Symfony",
                "Docker",
                "Jira",
                "Bitbucker",
                "PostgreSQL",
                "React",
            ],
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
        );

        $this->createProject(
            "Dynamische Website für Musterfirma ",
            2022,
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
            [
                "React",
                "TypeScript",
                "HTML5",
                "CSS3",
                "Git",
                "Rest API",
                "Docker"
            ],
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
        );

        $this->createResume(
            'Maxx Mustermann',
            '1999-11-11T00:00:00+00:00',
            "Abitur",
            "Fachinformatiker Anwendungsentwickler",
            [
                "Lead-Entwickler",
                "Frontend-Entwickler",
            ],
            [
                "HTML",
                "CSS",
                "PHP",
                "JavaScript"
            ],
            [
                "Scrum",
                "Jira",
                "Docker",
                "Atlassian Stack",
                "PHPStorm"
            ],
            'example-profile.png'
        );
    }

    protected function createLanguage(
        string $title,
        int    $level,
    ): void
    {
        $language = new Language();

        $language->setTitle($title);
        $language->setLevel($level);

        $this->manager->persist($language);
        $this->manager->flush();
    }

    protected function createProject(
        string $title,
        int    $year,
        string $description,
        array  $technologies,
        string $task,
        string $workflow
    ): void
    {
        $project = new Project();
        $project->setTitle($title);
        $project->setYear($year);
        $project->setDescription($description);
        $project->setTechnologies($technologies);
        $project->setTask($task);
        $project->setWorkflow($workflow);

        $this->manager->persist($project);
        $this->manager->flush();
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function createResume(
        string $name,
        string $birthdate,
        string $schoolGraduation,
        string $trainingGraduation,
        array  $positions,
        array  $programmingLanguages,
        array  $tools,
        string $photo
    ): void
    {
        $resume = new Resume();
        $resume->setName($name);
        $resume->setBirthdate(new DateTime($birthdate));
        $resume->setSchoolGraduation($schoolGraduation);
        $resume->setTrainingGraduation($trainingGraduation);
        $resume->setPositions($positions);
        $resume->setProgrammingLanguages($programmingLanguages);
        $resume->setTools($tools);
        $resume->setPhoto($photo);

        $languages = $this->manager->getRepository(Language::class)->findAll();
        for ($i = 0; $i < 2; $i++) {
            $resume->addLanguage($languages[$i]);
        }

        $projects = $this->manager->getRepository(Project::class)->findAll();
        for ($i = 0; $i < 2; $i++) {
            $resume->addProject($projects[$i]);
        }

        $this->manager->persist($resume);
        $this->manager->flush();
    }
}
