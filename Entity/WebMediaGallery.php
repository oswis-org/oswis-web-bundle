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
 *     "id"
 * })
 * @ApiPlatform\Core\Annotation\ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MANAGER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_pages_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_pages_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_page_get"}},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_page_put"}}
 *     },
 *     "delete"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"web_page_delete"}}
 *     }
 *   }
 * )
 */
#[Entity]
#[Table(name: 'web_media_gallery')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
#[ApiFilter(OrderFilter::class)]
class WebMediaGallery extends AbstractWebPage
{
}
