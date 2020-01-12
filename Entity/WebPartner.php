<?php

namespace Zakjakub\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use DateTime;
use Zakjakub\OswisCoreBundle\Entity\Nameable;
use Zakjakub\OswisCoreBundle\Filter\SearchAnnotation as Searchable;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\ColorTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\DateRangeTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\NameableBasicTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\PriorityTrait;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="Zakjakub\OswisWebBundle\Repository\WebPageRepository")
 * @Doctrine\ORM\Mapping\Table(name="web_partner")
 * @ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MANAGER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_partners_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_partners_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_partner_get"}},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_partner_put"}}
 *     }
 *   }
 * )
 * @ApiFilter(OrderFilter::class)
 * @Searchable({
 *     "id",
 *     "slug",
 *     "name",
 *     "shortName",
 *     "description",
 *     "note",
 *     "startDateTime",
 *     "endDateTime",
 *     "color"
 * })
 * @todo Is this used?
 */
class WebPartner
{
    use BasicEntityTrait;
    use NameableBasicTrait;
    use DateRangeTrait;
    use PriorityTrait;
    use ColorTrait;

    public function __construct(
        ?Nameable $nameable = null,
        ?DateTime $startDateTime = null,
        ?DateTime $endDateTime = null,
        ?int $priority = null,
        ?string $color = null
    ) {
        $this->setFieldsFromNameable($nameable);
        $this->setStartDateTime($startDateTime);
        $this->setEndDateTime($endDateTime);
        $this->setPriority($priority);
        $this->setColor($color);
    }
}
