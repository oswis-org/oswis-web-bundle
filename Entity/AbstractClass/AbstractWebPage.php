<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Entity\AbstractClass;

use DateTime;
use Zakjakub\OswisCoreBundle\Entity\Nameable;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\DateRangeTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\DateTimeTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\NameableBasicTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\PriorityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\TextValueTrait;
use Zakjakub\OswisWebBundle\Entity\MediaObject\ContactImage;
use Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage;
use Zakjakub\OswisWebBundle\Entity\WebActuality;
use Zakjakub\OswisWebBundle\Entity\WebMediaGallery;
use Zakjakub\OswisWebBundle\Entity\WebPage;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="Zakjakub\OswisWebBundle\Repository\AbstractWebPageRepository")
 * @Doctrine\ORM\Mapping\Table(name="web_abstract_web_page")
 * @Doctrine\ORM\Mapping\InheritanceType("JOINED")
 * @Doctrine\ORM\Mapping\DiscriminatorColumn(name="discriminator", type="text")
 * @Doctrine\ORM\Mapping\DiscriminatorMap({
 *   "web_web_page" = "Zakjakub\OswisWebBundle\Entity\WebPage",
 *   "web_web_actuality" = "Zakjakub\OswisWebBundle\Entity\WebActuality",
 *   "web_web_media_gallery" = "Zakjakub\OswisWebBundle\Entity\WebMediaGallery"
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
     *     targetEntity="Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage",
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
