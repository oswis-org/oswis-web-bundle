<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Service;

use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisWebBundle\Entity\WebFAQuestion;
use OswisOrg\OswisWebBundle\Repository\WebFAQuestionRepository;

class WebFAQuestionService
{
    protected WebFAQuestionRepository $webFAQuestionRepository;

    public function __construct(WebFAQuestionRepository $webFAQuestionRepository)
    {
        $this->webFAQuestionRepository = $webFAQuestionRepository;
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