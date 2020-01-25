<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Repository;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Zakjakub\OswisWebBundle\Entity\JobFairEvent;
use Zakjakub\OswisWebBundle\Entity\WebActuality;

class WebActualityRepository extends AbstractWebPageRepository
{
    public function getActualities(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return new ArrayCollection(
            $this->getActualitiesQueryBuilder($dateTime, $limit, $offset)->getQuery()->getArrayResult()
        );
    }

    private function getActualitiesQueryBuilder(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null
    ): QueryBuilder {
        return $this->getAbstractPagesQueryBuilder($dateTime, $limit, $offset, $slug, WebActuality::class);
    }

    public function getActuality(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null, ?string $slug = null): ?WebActuality
    {
        try {
            $actuality = $this->getActualitiesQueryBuilder($dateTime, $limit, $offset, $slug)->getQuery()->getOneOrNullResult();

            return $actuality instanceof WebActuality ? $actuality : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
