<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OswisOrg\OswisWebBundle\Entity\WebFAQuestion;
use OswisOrg\OswisWebBundle\Repository\WebFAQuestionRepository;

class WebFAQuestionService
{
    protected WebFAQuestionRepository $webFAQuestionRepository;

    protected EntityManagerInterface $em;

    public function __construct(WebFAQuestionRepository $webFAQuestionRepository, EntityManagerInterface $em)
    {
        $this->webFAQuestionRepository = $webFAQuestionRepository;
        $this->em = $em;
    }

    final public function create(WebFAQuestion $webFAQuestion): ?WebFAQuestion
    {
        try {
            $this->em->persist($webFAQuestion);
            $this->em->flush();

            return $webFAQuestion;
        } catch (Exception) {
            return null;
        }
    }

    public function getLastUpdatedAnsweredQuestion(): ?WebFAQuestion
    {
        $lastFaq = $this->getRepository()->getLastUpdatedAnsweredQuestions(1)->first();

        return empty($lastFaq) ? null : $lastFaq;
    }

    public function getRepository(): WebFAQuestionRepository
    {
        return $this->webFAQuestionRepository;
    }

    public function getAnsweredQuestions(?int $limit = null, ?int $offset = null): Collection
    {
        return $this->getRepository()->getAnsweredQuestions($limit, $offset);
    }
}