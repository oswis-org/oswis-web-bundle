<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity;

use OswisOrg\OswisCoreBundle\Interfaces\Common\BasicInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="OswisOrg\OswisWebBundle\Repository\WebFAQuestionRepository")
 * @Doctrine\ORM\Mapping\Table(name="web_frequently_asked_question")
 * @ApiPlatform\Core\Annotation\ApiResource(
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
 * @ApiPlatform\Core\Annotation\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter::class)
 * @OswisOrg\OswisCoreBundle\Filter\SearchAnnotation({
 *     "id"
 * })
 * @author Jakub Zak <mail@jakubzak.eu>
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_page")
 */
class WebFAQuestion implements BasicInterface
{
    use BasicTrait;
    use TextValueTrait;
    use PriorityTrait;

    /**
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected ?string $answer = null;

    public function __construct(?string $textValue = null, ?string $answer = null, ?int $priority = null)
    {
        $this->setTextValue($textValue);
        $this->setAnswer($answer);
        $this->setPriority($priority);
    }

    public function isPublic(): ?bool
    {
        return !empty($this->getAnswer());
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): void
    {
        $this->answer = $answer;
    }
}
