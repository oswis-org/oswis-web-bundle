<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Service;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Zakjakub\OswisCoreBundle\Entity\Nameable;
use Zakjakub\OswisWebBundle\Entity\WebActuality;
use Zakjakub\OswisWebBundle\Repository\WebActualityRepository;

class WebActualityService
{
    protected EntityManagerInterface $em;

    protected LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, ?LoggerInterface $logger)
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
    ): ?WebActuality {
        try {
            $entity = new WebActuality($nameable, $dateTime, $startDateTime, $endDateTime, $priority);
            $this->em->persist($entity);
            $this->em->flush();
            $this->logger->info('CREATE: Created web page (by manager): '.$entity->getId().' '.$entity->getName().'.');

            return $entity;
        } catch (Exception $e) {
            $this->logger->info('ERROR: Web page not created (by manager): '.$e->getMessage());

            return null;
        }
    }

    public function getActualities(?DateTime $dateTime = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return $this->getRepository()->getActualities($dateTime, $limit, $offset);
    }

    final public function getRepository(): WebActualityRepository
    {
        $repository = $this->em->getRepository(WebActuality::class);
        assert($repository instanceof WebActualityRepository);

        return $repository;
    }
}