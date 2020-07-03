<?php

namespace OswisOrg\OswisWebBundle\Entity;

use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_actuality")
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
 * @ApiPlatform\Core\Annotation\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter::class)
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
 * @author Jakub Zak <mail@jakubzak.eu>
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_page")
 */
class WebActuality extends AbstractWebPage
{
}
