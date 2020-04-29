<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use OswisOrg\OswisWebBundle\Entity\WebFrequentlyAskedQuestion;
use OswisOrg\OswisWebBundle\Repository\FaqWebRepository;

class FaqWebService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getLastUpdatedAnsweredQuestion(): ?WebFrequentlyAskedQuestion
    {
        $lastFaq = $this->getRepository()
            ->getLastUpdatedAnsweredQuestions(1)
            ->first();

        return empty($lastFaq) ? null : $lastFaq;
    }

    final public function getRepository(): FaqWebRepository
    {
        $repository = $this->em->getRepository(WebFrequentlyAskedQuestion::class);
        assert($repository instanceof FaqWebRepository);

        return $repository;
    }

    public function getAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        return $this->getRepository()
            ->getAnsweredQuestions($limit, $offset);
    }
}