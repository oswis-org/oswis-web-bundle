<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use OswisOrg\OswisWebBundle\Entity\JobFairEvent;

class FaqWebRepository extends EntityRepository
{
    public function getAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        $queryBuilder = $this->createQueryBuilder('faq');
        $queryBuilder->where("faq.answer IS NOT NULL AND faq.answer != ''");
        $queryBuilder->orderBy('faq.priority', 'DESC');
        $queryBuilder->addOrderBy('faq.createdDateTime', 'ASC');
        $queryBuilder->addOrderBy('faq.id', 'ASC');
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return new ArrayCollection(
            $queryBuilder->getQuery()->getArrayResult()
        );
    }

    public function getLastUpdatedAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        $queryBuilder = $this->createQueryBuilder('faq');
        $queryBuilder->where("faq.answer IS NOT NULL AND faq.answer != ''");
        $queryBuilder->addOrderBy('faq.updatedDateTime', 'DESC');
        $queryBuilder->addOrderBy('faq.id', 'DESC');
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return new ArrayCollection(
            $queryBuilder->getQuery()->getArrayResult()
        );
    }
}
