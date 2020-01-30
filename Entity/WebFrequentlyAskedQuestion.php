<?php /** @noinspection MethodShouldBeFinalInspection */

/** @noinspection PhpUnused */

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
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="Zakjakub\OswisWebBundle\Entity\WebFrequentlyAskedQuestionAnswer", fetch="EAGER")
     * @Doctrine\ORM\Mapping\JoinColumn(name="web_faq_answer_id", referencedColumnName="id")
     */
    protected ?Collection $answers = null;

    public function __construct(?string $textValue = null, ?Collection $answers = null)
    {
        $this->setTextValue($textValue);
        $this->answers = $answers ?? new ArrayCollection();
    }

    public function isPublic(): ?bool
    {
        return $this->getAnswers(true)->count() > 0;
    }

    public function getAnswers(bool $onlyPublic = false): Collection
    {
        if ($onlyPublic) {
            return $this->getAnswers()->filter(fn(WebFrequentlyAskedQuestionAnswer $a) => $a->isPublicOnWeb());
        }

        return $this->answers ?? new ArrayCollection();
    }

    public function addAnswer(?WebFrequentlyAskedQuestionAnswer $answer): void
    {
        if (null !== $answer && !$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }
    }

    public function removeAnswer(?WebFrequentlyAskedQuestionAnswer $answer): void
    {
        $this->answers->removeElement($answer);
    }
}
