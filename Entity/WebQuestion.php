<?php /** @noinspection PhpUnused */

namespace Zakjakub\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\TextValueTrait;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_question")
 * @ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_MANAGER')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_questions_get"}},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_questions_post"}}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_question_get"}},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "denormalization_context"={"groups"={"web_question_put"}}
 *     },
 *     "delete"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"web_question_delete"}}
 *     }
 *   }
 * )
 * @ApiFilter(OrderFilter::class)
 * @Searchable({
 *     "id"
 * })
 */
class WebQuestion
{
    use BasicEntityTrait;
    use TextValueTrait;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(
     *     targetEntity="Zakjakub\OswisWebBundle\Entity\WebFrequentlyAskedQuestion",
     *     inversedBy="webQuestions",
     *     fetch="EAGER"
     * )
     * @Doctrine\ORM\Mapping\JoinColumn(nullable=true)
     */
    protected ?WebFrequentlyAskedQuestion $frequentlyAskedQuestion = null;

    final public function getFrequentlyAskedQuestion(): ?WebFrequentlyAskedQuestion
    {
        return $this->frequentlyAskedQuestion;
    }

    final public function setFrequentlyAskedQuestion(?WebFrequentlyAskedQuestion $frequentlyAskedQuestion): void
    {
        if ($this->frequentlyAskedQuestion && $frequentlyAskedQuestion !== $this->frequentlyAskedQuestion) {
            $this->frequentlyAskedQuestion->removeWebQuestion($this);
        }
        if ($frequentlyAskedQuestion && $this->frequentlyAskedQuestion !== $frequentlyAskedQuestion) {
            $this->frequentlyAskedQuestion = $frequentlyAskedQuestion;
            $frequentlyAskedQuestion->addWebQuestion($this);
        }
    }
}
