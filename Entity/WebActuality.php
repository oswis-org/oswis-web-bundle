<?php

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisCoreBundle\Filter\SearchAnnotation;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

#[Entity]
#[Table(name: 'web_actuality')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
#[ApiFilter(OrderFilter::class)]
#[SearchAnnotation([
    'id',
    'slug',
    'name',
    'shortName',
    'description',
    'note',
    'dateTime',
    'createdAt',
    'updatedAt',
    'startDateTime',
    'endDateTime',
    'textValue',
])]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_MEMBER')",
            normalizationContext: ['groups' => ['nameables_get', 'web_abstract_pages_get', 'web_actualities_get']]
        ),
        new Post(
            security: "is_granted('ROLE_MANAGER')",
            denormalizationContext: ['groups' => ['nameables_post', 'web_abstract_pages_post', 'web_actualities_post']]
        ),
        new Get(
            security: "is_granted('ROLE_MEMBER')",
            normalizationContext: ['groups' => ['nameable_get', 'web_abstract_page_get', 'web_actuality_get']]
        ),
        new Put(
            security: "is_granted('ROLE_MANAGER')",
            denormalizationContext: ['groups' => ['nameable_put', 'web_abstract_page_put', 'web_actuality_put']]
        ),
    ],
    security: "is_granted('ROLE_MEMBER')",
    filters: ['search']
)]
class WebActuality extends AbstractWebPage
{
}
