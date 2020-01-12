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
use Zakjakub\OswisWebBundle\Entity\WebPartner;
use Zakjakub\OswisWebBundle\Repository\WebPartnerRepository;

class WebPartnerService
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
        ?DateTime $startDateTime = null,
        ?DateTime $endDateTime = null,
        ?int $priority = null,
        ?string $color = null
    ): ?WebPartner {
        try {
            $entity = new WebPartner($nameable, $startDateTime, $endDateTime, $priority, $color);
            $this->em->persist($entity);
            $this->em->flush();
            $this->logger->info('CREATE: Created web partner (by service): '.$entity->getId().' '.$entity->getName().'.');

            return $entity;
        } catch (Exception $e) {
            $this->logger->info('ERROR: Web partner not created (by manager): '.$e->getMessage());

            return null;
        }
    }

    public function getWebPartners(): Collection
    {
        return $this->getRepository()->getActiveWebPartners();
    }

    final public function getRepository(): WebPartnerRepository
    {
        $repository = $this->em->getRepository(WebPartner::class);
        assert($repository instanceof WebPartnerRepository);

        return $repository;
    }
}