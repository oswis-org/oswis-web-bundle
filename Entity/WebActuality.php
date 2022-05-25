<?php

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

/**
 * @author Jakub Zak <mail@jakubzak.eu>
 * @OswisOrg\OswisCoreBundle\Filter\SearchAnnotation({
 *     "id",
 *     "slug",
 *     "name",
 *     "shortName",
 *     "description",
 *     "note",
 *     "dateTime",
 *     "createdAt",
 *     "updatedAt",
 *     "startDateTime",
 *     "endDateTime",
 *     "textValue"
 * })
 * @ApiPlatform\Core\Annotation\ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MEMBER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "normalization_context"={"groups"={"nameables_get", "web_abstract_pages_get", "web_actualities_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"nameables_post", "web_abstract_pages_post", "web_actualities_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MEMBER')",
 *       "normalization_context"={"groups"={"nameable_get", "web_abstract_page_get", "web_actuality_get"}}
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"nameable_put", "web_abstract_page_put", "web_actuality_put"}}
 *     }
 *   }
 * )
 */
#[Entity]
#[Table(name: 'web_actuality')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
#[ApiFilter(OrderFilter::class)]
class WebActuality extends AbstractWebPage
{
}
