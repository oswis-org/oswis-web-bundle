<?php
/**
 * @noinspection PhpUnused
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity\AbstractClass;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use InvalidArgumentException;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractWebContent;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\DateTimeRange;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Nameable;
use OswisOrg\OswisCoreBundle\Interfaces\Common\NameableInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\DateRangeTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\DateTimeTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\NameableTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;
use OswisOrg\OswisWebBundle\Entity\MediaObject\ContactImage;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebFile;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Entity\WebContent;
use OswisOrg\OswisWebBundle\Entity\WebMediaGallery;
use OswisOrg\OswisWebBundle\Entity\WebPage;
use OswisOrg\OswisWebBundle\Repository\AbstractWebPageRepository;

/**
 * Abstract web page (page, actuality, web gallery...).
 *
 * Abstract web page is base for many kind of web pages (i.e. web page, web actuality, web gallery...).
 * Page is visible on website in interval given by startDateTime and endDateTime (no need to use publicOnWeb property).
 * Page is deleted by setting endDateTime (no need to use deleted property).
 * Column dateTime is used for overwriting createdAt on website.
 */
#[Entity(repositoryClass: AbstractWebPageRepository::class)]
#[Table(name: 'web_abstract_web_page')]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discriminator', type: 'text')]
#[DiscriminatorMap([
    'web_page'          => WebPage::class,
    'web_actuality'     => WebActuality::class,
    'web_media_gallery' => WebMediaGallery::class,
])]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_page')]
abstract class AbstractWebPage implements NameableInterface
{
    use NameableTrait;
    use DateTimeTrait {
        getDateTime as protected traitGetDateTime;
    }
    use DateRangeTrait;
    use PriorityTrait;
    use TextValueTrait;

    /**
     * @var Collection<WebImage>
     */
    #[OneToMany(mappedBy: 'webPage', targetEntity: WebImage::class, cascade: ['all'], orphanRemoval: true)]
    protected Collection $images;

    /**
     * @var Collection<WebFile>
     */
    #[OneToMany(mappedBy: 'webPage', targetEntity: WebFile::class, cascade: ['all'], orphanRemoval: true)]
    protected Collection $files;

    /**
     * @var Collection<WebContent>
     */
    #[OneToMany(mappedBy: 'webPage', targetEntity: WebContent::class, cascade: ['all'], fetch: 'EAGER')]
    protected Collection $contents;

    public function __construct(?Nameable $nameable = null, ?DateTime $dateTime = null, ?DateTimeRange $range = null, ?int $priority = null)
    {
        $this->images = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->contents = new ArrayCollection();
        $this->setFieldsFromNameable($nameable);
        $this->setDateTime($dateTime);
        $this->setDateTimeRange($range);
        $this->setPriority($priority);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        if (!empty($this->getTextValue())) {
            $this->addContent(new WebContent($this->getTextValue(), AbstractWebContent::HTML));
        }
    }

    public function addContent(?WebContent $webContent): void
    {
        if (null !== $webContent && !$this->getContents()->contains($webContent)) {
            $this->removeContent($this->getContent($webContent->getType()));
            $this->getContents()->add($webContent);
            $webContent->setWebPage($this);
        }
    }

    public function getContents(?string $type = null): Collection
    {
        $contents = $this->contents;
        if (null !== $type) {
            $contents = $contents->filter(fn(mixed $webContent) => $webContent instanceof WebContent && $webContent->isType($type),);
        }

        return $contents;
    }

    public function removeContent(?WebContent $webContent): void
    {
        if (null !== $webContent && $this->getContents()->removeElement($webContent)) {
            $webContent->setWebPage(null);
        }
    }

    public function getContent(?string $type = 'html'): ?WebContent
    {
        $content = $this->getContents($type)->first();

        return $content instanceof WebContent ? $content : null;
    }

    public function getHtmlContent(): ?string
    {
        $htmlContent = $this->getContent(AbstractWebContent::HTML);

        return null !== $htmlContent ? $htmlContent->getTextValue() : $this->getTextValue();
    }

    public function addImage(?WebImage $image): void
    {
        if (null !== $image && !$this->getImages()->contains($image)) {
            $this->getImages()->add($image);
            $image->setWebPage($this);
        }
    }

    public function getImages(?string $type = null, ?bool $onlyPublic = false): Collection
    {
        $images = WebImage::sortByPriority($this->images);
        if (!empty($type)) {
            $images = $images->filter(static fn(mixed $image) => $image instanceof WebImage && $image->getType() === $type,);
        }
        if ($onlyPublic) {
            $images = $images->filter(static fn(mixed $image) => $image instanceof WebImage && $image->isPublicOnWeb(),);
        }

        return $images;
    }

    public function removeImage(?WebImage $image): void
    {
        if (null !== $image && $this->getImages()->removeElement($image)) {
            $image->setWebPage(null);
        }
    }

    public function addFile(?WebFile $file): void
    {
        if (null !== $file && !$this->getFiles()->contains($file)) {
            $this->getFiles()->add($file);
            $file->setWebPage($this);
        }
    }

    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function removeFile(?WebFile $file): void
    {
        if (null !== $file && $this->getFiles()->removeElement($file)) {
            $file->setWebPage(null);
        }
    }

    public function isWebPage(): bool
    {
        return $this instanceof WebPage;
    }

    public function isWebActuality(): bool
    {
        return $this instanceof WebActuality;
    }

    public function isWebMediaGallery(): bool
    {
        return $this instanceof WebMediaGallery;
    }

    /**
     * Date and time of actuality.
     *
     * Date and time of creation is returned if it's not overwritten by dateTime property.
     * This method overrides method from trait.
     *
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->traitGetDateTime() ?? $this->getCreatedAt();
    }

    public function getOneImage(): ?WebImage
    {
        return ($image = $this->getImages()->first()) instanceof WebImage ? $image : null;
    }
}
