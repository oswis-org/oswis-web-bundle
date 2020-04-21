<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Service;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use OswisOrg\OswisCoreBundle\Entity\Nameable;
use OswisOrg\OswisWebBundle\Entity\WebPage;
use OswisOrg\OswisWebBundle\Repository\WebPageRepository;

class WebPageService
{
    protected EntityManagerInterface $em;

    protected LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    final public function create(
        ?Nameable $nameable = null,
        ?DateTime $dateTime = null,
        ?DateTime $startDateTime = null,
        ?DateTime $endDateTime = null,
        ?int $priority = null
    ): ?WebPage {
        try {
            $entity = new WebPage($nameable, $dateTime, $startDateTime, $endDateTime, $priority);
            $this->em->persist($entity);
            $this->em->flush();
            $this->logger->info('CREATE: Created web page (by service): '.$entity->getId().' '.$entity->getName().'.');

            return $entity;
        } catch (Exception $e) {
            $this->logger->info('ERROR: Web page not created (by service): '.$e->getMessage());

            return null;
        }
    }

    public function getWebPages(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return $this->getRepository()->getPages($dateTime, $limit, $offset);
    }

    final public function getRepository(): WebPageRepository
    {
        $repository = $this->em->getRepository(WebPage::class);
        assert($repository instanceof WebPageRepository);

        return $repository;
    }
}