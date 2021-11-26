<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity\MediaObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Publicity;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\EntityPublicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TypeTrait;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_image")
 * @ApiPlatform\Core\Annotation\ApiResource(
 *     iri="http://schema.org/ImageObject",
 *     collectionOperations={
 *         "get"={
 *           "access_control"="is_granted('ROLE_MANAGER')",
 *           "normalization_context"={"groups"={"web_actualities_get"}},
 *         },
 *         "post"={
 *           "method"="POST",
 *           "path"="/web_image",
 *           "controller"=OswisOrg\OswisWebBundle\Controller\MediaObject\CreateWebImageAction::class,
 *           "defaults"={"_api_receive"=false},
 *           "access_control"="is_granted('ROLE_MANAGER')",
 *         },
 *     }
 * )
 * @Vich\UploaderBundle\Mapping\Annotation\Uploadable()
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_image")
 */
class WebImage extends AbstractImage
{
    use BasicTrait;
    use TypeTrait;
    use PriorityTrait;
    use EntityPublicTrait;

    /**
     * @Symfony\Component\Validator\Constraints\NotNull()
     * @Vich\UploaderBundle\Mapping\Annotation\UploadableField(
     *     mapping="web_image", fileNameProperty="contentName", mimeType="contentMimeType"
     * )
     */
    public ?File $file = null;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(
     *     targetEntity="OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage", inversedBy="images", cascade={"all"}
     * )
     * @Doctrine\ORM\Mapping\JoinColumn(name="abstract_web_page_id", referencedColumnName="id")
     */
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
        usort($items, static fn(self $item1, self $item2) => self::compare($item1, $item2));

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
