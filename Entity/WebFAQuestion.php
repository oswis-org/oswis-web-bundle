<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisCoreBundle\Interfaces\Common\BasicInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;
use OswisOrg\OswisWebBundle\Repository\WebFAQuestionRepository;

/**
 * @author Jakub Zak <mail@jakubzak.eu>
 * @OswisOrg\OswisCoreBundle\Filter\SearchAnnotation({
 *     "id"
 * })
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
 */
#[Entity(repositoryClass: WebFAQuestionRepository::class)]
#[Table(name: 'web_frequently_asked_question')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
#[ApiFilter(OrderFilter::class)]
class WebFAQuestion implements BasicInterface
{
    use BasicTrait;
    use TextValueTrait;
    use PriorityTrait;

    #[Column(type: 'text', nullable: true)]
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
