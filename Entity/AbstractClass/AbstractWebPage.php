<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Entity\AbstractClass;

use DateTime;
use OswisOrg\OswisCoreBundle\Entity\Nameable;
use OswisOrg\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use OswisOrg\OswisCoreBundle\Traits\Entity\DateRangeTrait;
use OswisOrg\OswisCoreBundle\Traits\Entity\DateTimeTrait;
use OswisOrg\OswisCoreBundle\Traits\Entity\NameableBasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Entity\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Entity\TextValueTrait;
use OswisOrg\OswisWebBundle\Entity\MediaObject\ContactImage;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Entity\WebMediaGallery;
use OswisOrg\OswisWebBundle\Entity\WebPage;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="OswisOrg\OswisWebBundle\Repository\AbstractWebPageRepository")
 * @Doctrine\ORM\Mapping\Table(name="web_abstract_web_page")
 * @Doctrine\ORM\Mapping\InheritanceType("JOINED")
 * @Doctrine\ORM\Mapping\DiscriminatorColumn(name="discriminator", type="text")
 * @Doctrine\ORM\Mapping\DiscriminatorMap({
 *   "web_page" = "OswisOrg\OswisWebBundle\Entity\WebPage",
 *   "web_actuality" = "OswisOrg\OswisWebBundle\Entity\WebActuality",
 *   "web_media_gallery" = "OswisOrg\OswisWebBundle\Entity\WebMediaGallery"
 * })
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_abstract_web_page")
 */
abstract class AbstractWebPage
{
    use BasicEntityTrait;
    use NameableBasicTrait;
    use DateTimeTrait;
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
}
