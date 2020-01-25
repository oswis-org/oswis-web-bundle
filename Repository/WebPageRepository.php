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
use Zakjakub\OswisWebBundle\Entity\WebPage;

class WebPageRepository extends AbstractWebPageRepository
{
    public function getPages(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return new ArrayCollection($this->getPagesQueryBuilder($dateTime, $limit, $offset)->getQuery()->getArrayResult());
    }

    private function getPagesQueryBuilder(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null, ?string $slug = null): QueryBuilder
    {
        return $this->getAbstractPagesQueryBuilder($dateTime, $limit, $offset, $slug, WebPage::class);
    }

    public function getPage(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null, ?string $slug = null): ?WebPage
    {
        try {
            $actuality = $this->getPagesQueryBuilder($dateTime, $limit, $offset, $slug)->getQuery()->getOneOrNullResult();

            return $actuality instanceof WebPage ? $actuality : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
