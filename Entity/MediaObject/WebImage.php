<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity\MediaObject;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Mapping\Annotation\Uploadable;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Publicity;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Interfaces\Common\BasicInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\EntityPublicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TypeTrait;
use OswisOrg\OswisWebBundle\Controller\MediaObject\CreateWebImageAction;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[Entity]
#[Table(name: 'web_image')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_image')]
#[Uploadable]
#[ApiResource(collectionOperations: [
    'get'  => [
        'access_control'        => "is_granted('ROLE_MANAGER')",
        'normalization_context' => ['groups' => ["web_actualities_get"]],
    ],
    'post' => [
        'method'         => 'POST',
        'path'           => '/web_image',
        'controller'     => CreateWebImageAction::class,
        'access_control' => "is_granted('ROLE_MANAGER')",
        'defaults'       => ['_api_receive' => false],
    ],
])]
class WebImage extends AbstractImage
{
    use BasicTrait;
    use TypeTrait;
    use PriorityTrait;
    use EntityPublicTrait;

    #[NotNull]
    #[UploadableField(mapping: 'web_image', fileNameProperty: 'contentName', mimeType: 'contentMimeType')]
    public ?File $file = null;

    #[ManyToOne(targetEntity: AbstractWebPage::class, cascade: ['all'], inversedBy: 'images')]
    #[JoinColumn(name: 'abstract_web_page_id', referencedColumnName: 'id')]
    protected ?AbstractWebPage $webPage = null;

    /**
     * @param  File|null  $file
     * @param  string|null  $type
     * @param  int|null  $priority
     * @param  Publicity|null  $publicity
     *
     * @throws InvalidTypeException
     */
    public function __construct(?File $file = null, ?string $type = null, ?int $priority = null, ?Publicity $publicity = null)
    {
        $this->setFile($file);
        $this->setType($type);
        $this->setPriority($priority);
        $this->setFieldsFromPublicity($publicity);
    }

    public static function compareByPriority(self $item1, self $item2): int
    {
        if ($item1->getPriority() === $item2->getPriority()) {
            return $item1->getId() <=> $item2->getId();
        }

        return $item1->getPriority() <=> $item2->getPriority();
    }

    public static function sortByPriority(?Collection $webImages): Collection
    {
        $items = $webImages ? $webImages->toArray() : [];
        usort($items, static function (mixed $item1, mixed $item2) {
            assert($item1 instanceof BasicInterface);
            assert($item2 instanceof BasicInterface);

            return self::compare($item1, $item2);
        });

        return new ArrayCollection($items);
    }

    public function getWebPage(): ?AbstractWebPage
    {
        return $this->webPage;
    }

    public function setWebPage(?AbstractWebPage $webPage): void
    {
        if (null !== $this->webPage && $webPage !== $this->webPage) {
            $this->webPage->removeImage($this);
        }
        $this->webPage = $webPage;
        $webPage?->addImage($this);
    }
}
