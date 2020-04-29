<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Service;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Repository\AbstractWebPageRepository;
use Psr\Log\LoggerInterface;

class WebService
{
    protected EntityManagerInterface $em;

    protected LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function getLastActualities(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null
    ): Collection {
        return $this->getAbstractWebPages($dateTime, $limit, $offset, null, WebActuality::class);
    }

    public function getAbstractWebPages(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): Collection {
        return $this->getRepository()
            ->getAbstractPages($dateTime, $limit, $offset, $slug, $class);
    }

    final public function getRepository(): AbstractWebPageRepository
    {
        $repository = $this->em->getRepository(AbstractWebPage::class);
        assert($repository instanceof AbstractWebPageRepository);

        return $repository;
    }

    public function getAbstractWebPage(
        ?DateTime $dateTime = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $slug = null,
        ?string $class = null
    ): ?AbstractWebPage {
        return $this->getRepository()
            ->getAbstractPage($dateTime, $limit, $offset, $slug, $class);
    }
}