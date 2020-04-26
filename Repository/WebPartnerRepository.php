<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Repository;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use OswisOrg\OswisWebBundle\Entity\JobFairEvent;

class WebPartnerRepository extends EntityRepository
{
    public function getActiveWebPartners(?DateTime $referenceDateTime = null, ?int $limit = null): Collection
    {
        $referenceDateTime ??= new DateTime() ?? null;
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->where(':ref BETWEEN p.startDateTime AND p.endDateTime')
            ->setParameter('ref', $referenceDateTime);
        $queryBuilder->orWhere('p.startDateTime IS NULL AND :ref < p.endDateTime')
            ->orWhere('p.endDateTime IS NULL AND :ref > p.startDateTime');
        $queryBuilder->orderBy('priority', 'DESC')
            ->addOrderBy('id', 'ASC');
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return new ArrayCollection(
            $queryBuilder->getQuery()
                ->getArrayResult()
        );
    }
}
