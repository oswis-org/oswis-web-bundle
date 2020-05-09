<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Entity\AbstractClass;

use DateTime;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Nameable;
use OswisOrg\OswisCoreBundle\Interfaces\Common\NameableEntityInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\DateRangeTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\DateTimeTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\NameableBasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;
use OswisOrg\OswisWebBundle\Entity\MediaObject\ContactImage;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Entity\WebMediaGallery;
use OswisOrg\OswisWebBundle\Entity\WebPage;

/**
 * Abstract web page (page, actuality, web gallery...).
 *
 * Abstract web page is base for many kind of web pages (ie. web page, web actuality, web gallery...).
 * Page is visible on website in interval given by startDateTime and endDateTime (no need to use publicOnWeb property).
 * Page is deleted by setting endDateTime (no need to use deleted property).
 * Column dateTime is used for overwriting createdDateTime on website.
 *
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="OswisOrg\OswisWebBundle\Repository\AbstractWebPageRepository")
 * @Doctrine\ORM\Mapping\Table(name="web_abstract_web_page")
 * @Doctrine\ORM\Mapping\InheritanceType("JOINED")
 * @Doctrine\ORM\Mapping\DiscriminatorColumn(name="discriminator", type="text")
 * @Doctrine\ORM\Mapping\DiscriminatorMap({
 *   "web_page" = "OswisOrg\OswisWebBundle\Entity\WebPage",
 *   "web_actuality" = "OswisOrg\OswisWebBundle\Entity\WebActuality",
 *   "web_media_gallery" = "OswisOrg\OswisWebBundle\Entity\WebMediaGallery"
 * })
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_page")
 */
abstract class AbstractWebPage implements NameableEntityInterface
{
    use NameableBasicTrait;
    use DateTimeTrait {
        getDateTime as protected traitGetDateTime;
    }
    use DateRangeTrait;
    use PriorityTrait;
    use TextValueTrait;

    /**
     * @Doctrine\ORM\Mapping\OneToOne(
     *     targetEntity="OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage",
     *     cascade={"all"},
     *     fetch="EAGER"
     * )
     */
    protected ?WebImage $image = null;

    public function __construct(
        ?Nameable $nameable = null,
        ?DateTime $dateTime = null,
        ?DateTime $startDateTime = null,
        ?DateTime $endDateTime = null,
        ?int $priority = null
    ) {
        $this->setFieldsFromNameable($nameable);
        $this->setDateTime($dateTime);
        $this->setStartDateTime($startDateTime);
        $this->setEndDateTime($endDateTime);
        $this->setPriority($priority);
    }

    public function getImage(): ?WebImage
    {
        return $this->image;
    }

    public function setImage(?WebImage $image): void
    {
        $this->image = $image;
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
        return $this->traitGetDateTime() ?? $this->getCreatedDateTime();
    }
}
