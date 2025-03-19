<?php

namespace App\Repository;

use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resume>
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    public function getProjectsJoinWithResumeProject()
    {
        $qb = $this->createQueryBuilder('resume')
            ->select('resume, project, language')
            ->leftJoin('resume.projects', 'project')
            ->leftJoin('resume.languages', 'language');

        return $qb->getQuery()->getResult();
    }
}
