<?php

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use OswisOrg\OswisCoreBundle\Filter\SearchAnnotation as Searchable;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_actuality")
 * @ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MEMBER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "normalization_context"={"groups"={"web_actualities_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "denormalization_context"={"groups"={"web_actualities_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "normalization_context"={"groups"={"web_actuality_get"}},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "denormalization_context"={"groups"={"web_actuality_put"}}
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
 *     "createdDateTime",
 *     "updatedDateTime",
 *     "startDateTime",
 *     "endDateTime"
 * })
 */
class WebActuality extends AbstractWebPage
{
}
