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
        $this->createLanguage("Deutsch", 5);
        $this->createLanguage("Englisch", 4);
        $this->createLanguage("Französisch", 3);
        $this->createLanguage("Spanisch", 4);
        $this->createLanguage("Italienisch", 3);

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

        $this->createProject(
            "Webportal für ABC AG",
            2022,
            "Dieses Projekt umfasst die Entwicklung eines modernen Webportals, das Kundeninformationen, Angebote und Bestellungen in Echtzeit verarbeitet.",
            [
                "PHP",
                "Laravel",
                "MySQL",
                "Vue.js",
                "Docker",
            ],
            "Implementierung von Benutzerverwaltung und Echtzeit-Datenvisualisierung.",
            "Agile Entwicklung, kontinuierliche Integration und regelmäßige Code Reviews."
        );

        $this->createProject(
            "Mobile App für XYZ Solutions",
            2020,
            "Entwicklung einer plattformübergreifenden mobilen Anwendung, die den Zugriff auf Unternehmensdaten und Kundenservices ermöglicht.",
            [
                "React Native",
                "Node.js",
                "Express",
                "MongoDB",
                "Firebase",
            ],
            "Implementierung von Push-Benachrichtigungen und einer intuitiven Benutzeroberfläche.",
            "Testgetriebene Entwicklung und schnelle Iterationen basierend auf Nutzerfeedback."
        );

        $this->createProject(
            "CRM-System für Beispiel AG",
            2023,
            "Entwicklung eines Customer Relationship Management Systems zur Verwaltung von Kundenbeziehungen und Verkaufschancen.",
            [
                "PHP",
                "Symfony",
                "PostgreSQL",
                "Redis",
                "Bootstrap",
            ],
            "Integration von CRM-Funktionen, automatisierten E-Mail-Kampagnen und Reporting-Tools.",
            "Iterative Entwicklung mit Fokus auf Skalierbarkeit und Performance."
        );

        $this->createProject(
            "E-Commerce Plattform für Shop24",
            2021,
            "Aufbau einer skalierbaren E-Commerce-Plattform, die Online-Verkäufe und Produktmanagement unterstützt.",
            [
                "PHP",
                "Laravel",
                "Vue.js",
                "Stripe",
                "Docker",
            ],
            "Implementierung eines sicheren Zahlungssystems und eines flexiblen Bestellmanagements.",
            "Agile Methoden, Microservices-Architektur und kontinuierliche Bereitstellung."
        );

        $this->createProject(
            "Buchungssystem für TravelCo",
            2022,
            "Entwicklung eines Buchungssystems für Reiseangebote, das Echtzeit-Verfügbarkeitsprüfungen und Buchungen ermöglicht.",
            [
                "Java",
                "Spring Boot",
                "Angular",
                "MySQL",
                "Kubernetes",
            ],
            "Implementierung von Such- und Buchungsalgorithmen sowie Integration externer Zahlungssysteme.",
            "DevOps-Methoden, Containerisierung und automatisierte Tests."
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
            'example-profile.png',
            1
        );

        $this->createResume(
            'Anna Musterfrau',
            '1995-07-22T00:00:00+00:00',
            "Mittlere Reife",
            "Fachinformatikerin für Systemintegration",
            [
                "Systemadministratorin",
            ],
            [
                "Python",
                "JavaScript",
                "HTML",
                "CSS"
            ],
            [
                "Docker",
                "Kubernetes",
                "Git",
                "Jira"
            ],
            'example-profile.png',
            3
        );

        $this->createResume(
            'Peter Mustermann',
            '1987-03-15T00:00:00+00:00',
            "Abitur",
            "Fachinformatiker für Anwendungsentwicklung",
            [
                "Backend-Entwickler",
                "DevOps-Ingenieur",
            ],
            [
                "PHP",
                "SQL",
                "Java",
                "Go"
            ],
            [
                "Scrum",
                "Kanban",
                "Git",
                "Docker"
            ],
            'example-profile.png',
            5
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
        string $photo,
        int    $number,
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
        $projects = $this->manager->getRepository(Project::class)->findAll();

        $resume->addLanguage($languages[$number - 1]);
        $resume->addLanguage($languages[$number]);
        $resume->addProject($projects[$number - 1]);
        $resume->addProject($projects[$number]);

        $this->manager->persist($resume);
        $this->manager->flush();
    }


}
