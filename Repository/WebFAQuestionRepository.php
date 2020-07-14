<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;
use OswisOrg\OswisWebBundle\Entity\JobFairEvent;
use OswisOrg\OswisWebBundle\Entity\WebFAQuestion;

class WebFAQuestionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     *
     * @throws LogicException
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebFAQuestion::class);
    }

    public function getAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        $queryBuilder = $this->createQueryBuilder('faq')->where("faq.answer IS NOT NULL AND faq.answer != ''");
        $queryBuilder->orderBy('faq.priority', 'DESC');
        $queryBuilder->addOrderBy('faq.createdAt', 'ASC')->addOrderBy('faq.id', 'ASC');
        $queryBuilder->setMaxResults($limit)->setFirstResult($offset);

        return new ArrayCollection($queryBuilder->getQuery()->getResult());
    }

    public function getLastUpdatedAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        $queryBuilder = $this->createQueryBuilder('faq')->where("faq.answer IS NOT NULL AND faq.answer != ''");
        $queryBuilder->addOrderBy('faq.updatedAt', 'DESC')->addOrderBy('faq.id', 'DESC');
        $queryBuilder->setMaxResults($limit)->setFirstResult($offset);

        return new ArrayCollection($queryBuilder->getQuery()->getResult());
    }
}
