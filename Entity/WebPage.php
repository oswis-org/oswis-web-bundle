<?php

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

#[Entity]
#[Table(name: 'web_page')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
#[ApiFilter(OrderFilter::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['web_pages_get']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Post(
            denormalizationContext: ['groups' => ['web_pages_post']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Get(
            normalizationContext: ['groups' => ['web_page_get']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Put(
            denormalizationContext: ['groups' => ['web_page_put']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Delete(
            denormalizationContext: ['groups' => ['web_page_delete']],
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    filters: ['search'],
    security: "is_granted('ROLE_MANAGER')"
)]
class WebPage extends AbstractWebPage
{
}
