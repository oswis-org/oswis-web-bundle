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
use Zakjakub\OswisWebBundle\Entity\WebMediaGallery;

class WebMediaGalleryRepository extends AbstractWebPageRepository
{
    public function getActualities(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return new ArrayCollection(
            $this->getPagesQueryBuilder($dateTime, $limit, $offset)->getQuery()->getArrayResult()
        );
    }

    private function getPagesQueryBuilder(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null, ?int $slug = null): QueryBuilder
    {
        return $this->getAbstractPagesQueryBuilder($dateTime, $limit, $offset, $slug, WebMediaGallery::class);
    }

    public function getActuality(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null, ?int $slug = null): ?WebMediaGallery
    {
        try {
            $actuality = $this->getPagesQueryBuilder($dateTime, $limit, $offset, $slug)->getQuery()->getOneOrNullResult();

            return $actuality instanceof WebMediaGallery ? $actuality : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
