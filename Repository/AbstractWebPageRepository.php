<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Repository;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Zakjakub\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use Zakjakub\OswisWebBundle\Entity\JobFairEvent;

class AbstractWebPageRepository extends EntityRepository
{
    public static function addIdQuery(QueryBuilder $queryBuilder, ?int $id = null): void
    {
        if ($id !== null) {
            $queryBuilder->andWhere('p.id = :id')->setParameter('id', $id);
        }
    }

    public static function addSlugQuery(QueryBuilder $queryBuilder, ?string $slug = null): void
    {
        if (!empty($slug)) {
            $queryBuilder->andWhere('p.slug = :slug')->setParameter('slug', $slug);
        }
    }

    public static function addDateRangeQuery(QueryBuilder $queryBuilder, ?DateTime $dateTime = null): void
    {
        if (null !== $dateTime) {
            $dateRangeQuery = ' (:ref BETWEEN p.startDateTime AND p.endDateTime) ';
            $dateRangeQuery .= ' OR (p.startDateTime IS NULL AND :ref < p.endDateTime) OR (p.endDateTime IS NULL AND :ref > p.startDateTime) ';
            $queryBuilder->andWhere($dateRangeQuery)->setParameter('ref', $dateTime);
        }
    }

    public static function addLimit(QueryBuilder $queryBuilder, ?int $limit = null, ?int $offset = null): void
    {
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }
    }

    public static function addOrderBy(QueryBuilder $queryBuilder, bool $priority = true, bool $dateTime = true): void
    {
        if ($priority) {
            $queryBuilder->addOrderBy('p.priority', 'DESC');
        }
        if ($dateTime) {
            $queryBuilder->addOrderBy('p.dateTime', 'DESC');
        }
        $queryBuilder->addOrderBy('p.id', 'DESC');
    }

    public static function addClassQuery(QueryBuilder $queryBuilder, ?string $class = null): void
    {
        if (!empty($class)) {
            $queryBuilder->andWhere('p INSTANCE OF :class')->setParameter('class', $class);
        }
    }

    public function getAbstractPages(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): Collection {
        return new ArrayCollection(
            $this->getAbstractPagesQueryBuilder($dateTime, $limit, $offset, $slug, $class)->getQuery()->getArrayResult()
        );
    }

    public function getAbstractPagesQueryBuilder(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): QueryBuilder {
        $queryBuilder = $this->createQueryBuilder('p');
        self::addSlugQuery($queryBuilder, $slug);
        self::addDateRangeQuery($queryBuilder, $dateTime);
        self::addLimit($queryBuilder, $limit, $offset);
        self::addOrderBy($queryBuilder, true, true);
        self::addClassQuery($queryBuilder, $class);

        return $queryBuilder;
    }

    public function getAbstractPage(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): ?AbstractWebPage {
        try {
            $page = $this->getAbstractPagesQueryBuilder($dateTime, $limit, $offset, $slug, $class)->getQuery()->getOneOrNullResult();

            return $page instanceof AbstractWebPage && is_a($page, $class) ? $page : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
