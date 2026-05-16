<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisCoreBundle\Filter\SearchAnnotation;
use OswisOrg\OswisCoreBundle\Interfaces\Common\BasicInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;
use OswisOrg\OswisWebBundle\Repository\WebFAQuestionRepository;

#[SearchAnnotation(['id'])]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['web_frequently_asked_questions_get']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Post(
            denormalizationContext: ['groups' => ['web_frequently_asked_questions_post']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Get(
            normalizationContext: ['groups' => ['web_frequently_asked_question_get']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Put(
            denormalizationContext: ['groups' => ['web_frequently_asked_question_put']],
            security: "is_granted('ROLE_MANAGER')"
        ),
        new Delete(
            denormalizationContext: ['groups' => ['web_frequently_asked_question_delete']],
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    filters: ['search'],
    security: "is_granted('ROLE_MANAGER')"
)]
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
