<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Service;

use DateTime;
use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Repository\AbstractWebPageRepository;

class WebService
{
    protected AbstractWebPageRepository $abstractWebPageRepository;

    public function __construct(AbstractWebPageRepository $abstractWebPageRepository)
    {
        $this->abstractWebPageRepository = $abstractWebPageRepository;
    }

    public function getLastActualities(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return $this->getAbstractWebPages($dateTime, $limit, $offset, null, WebActuality::class);
    }

    public function getAbstractWebPages(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): Collection {
        return $this->getRepository()->getAbstractPages($dateTime, $limit, $offset, $slug, $class);
    }

    final public function getRepository(): AbstractWebPageRepository
    {
        return $this->abstractWebPageRepository;
    }

    public function getAbstractWebPage(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): ?AbstractWebPage {
        return $this->getRepository()->getAbstractPage($dateTime, $limit, $offset, $slug, $class);
    }
}