<?php

namespace App\DataFixtures;

use App\Entity\Resume;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResumeFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

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
                [
                    "title" => "Deutsch",
                    "level" => 5
                ],
                [
                    "title" => "Englisch",
                    "level" => 4
                ]
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
            ], [
            [
                "title" => "Internes Dashboard für Mustermann GmbH",
                'year' => 2021,
                "description" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                "technologies" => [
                    "PHP",
                    "Symfony",
                    "Docker",
                    "Jira",
                    "Bitbucker",
                    "PostgreSQL",
                    "React",
                ],
                "task" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                "workflow" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
            ],
            [
                "title" => "Dynamische Website für Musterfirma ",
                "year" => 2022,
                "description" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                "technologies" => [
                    "React",
                    "TypeScript",
                    "HTML5",
                    "CSS3",
                    "Git",
                    "Rest API",
                    "Docker"
                ],
                "task" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At",
                "workflow" => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At"
            ]
        ]);
    }

    protected function createResume(
        string $name,
        string $birthdate,
        string $schoolGraduation,
        string $trainingGraduation,
        array  $positions,
        array  $languages,
        array  $programmingLanguages,
        array  $tools,
        array  $projects
    ): void
    {
        $resume = new Resume();

        $resume->setName($name);
        $resume->setBirthdate(new DateTime($birthdate));
        $resume->setSchoolGraduation($schoolGraduation);
        $resume->setTrainingGraduation($trainingGraduation);
        $resume->setPositions($positions);
        $resume->setLanguages($languages);
        $resume->setProgrammingLanguages($programmingLanguages);
        $resume->setTools($tools);
        $resume->setProjects($projects);

        $this->manager->persist($resume);
        $this->manager->flush();
    }
}
