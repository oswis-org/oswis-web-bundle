<?php /** @noinspection PhpUnused */

namespace Zakjakub\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zakjakub\OswisCoreBundle\Filter\SearchAnnotation as Searchable;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\TextValueTrait;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_frequently_asked_question")
 * @ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MANAGER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_frequently_asked_questions_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_frequently_asked_questions_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_frequently_asked_question_get"}},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_frequently_asked_question_put"}}
 *     },
 *     "delete"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"web_frequently_asked_question_delete"}}
 *     }
 *   }
 * )
 * @ApiFilter(OrderFilter::class)
 * @Searchable({
 *     "id"
 * })
 */
class WebFrequentlyAskedQuestion
{
    use BasicEntityTrait;
    use TextValueTrait;

    /**
     * @Doctrine\ORM\Mapping\OneToOne(targetEntity="Zakjakub\OswisWebBundle\Entity\WebFrequentlyAskedQuestionAnswer", fetch="EAGER")
     * @Doctrine\ORM\Mapping\JoinColumn(name="web_faq_answer_id", referencedColumnName="id")
     */
    protected ?WebFrequentlyAskedQuestionAnswer $answer = null;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(
     *     targetEntity="Zakjakub\OswisWebBundle\Entity\WebQuestion",
     *     mappedBy="frequentlyAskedQuestion",
     *     cascade={"all"},
     *     fetch="EAGER"
     * )
     */
    protected ?Collection $webQuestions = null;

    final public function getWebQuestions(): Collection
    {
        return $this->webQuestions ?? new ArrayCollection();
    }

    final public function addWebQuestion(?WebQuestion $webQuestion): void
    {
        if (null !== $webQuestion && !$this->webQuestions->contains($webQuestion)) {
            $this->webQuestions->add($webQuestion);
            $webQuestion->setFrequentlyAskedQuestion($this);
        }
    }

    final public function removeWebQuestion(?WebQuestion $webQuestion): void
    {
        if (null !== $webQuestion && $this->webQuestions->removeElement($webQuestion)) {
            $webQuestion->setFrequentlyAskedQuestion(null);
        }
    }

    final public function isPublic(): ?bool
    {
        return $this->getAnswer() && $this->getAnswer()->isPublicOnWeb();
    }

    final public function getAnswer(): ?WebFrequentlyAskedQuestionAnswer
    {
        return $this->answer;
    }

    final public function setAnswer(?WebFrequentlyAskedQuestionAnswer $answer): void
    {
        $this->answer = $answer;
    }
}
