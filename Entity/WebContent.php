<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity;

use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractWebContent;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_content")
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_content")
 */
class WebContent extends AbstractWebContent
{

    /**
     * Parent event (if this is not top level event).
     * @Doctrine\ORM\Mapping\ManyToOne(
     *     targetEntity="OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage", inversedBy="contents", fetch="EAGER"
     * )
     * @Doctrine\ORM\Mapping\JoinColumn(nullable=true)
     */
    protected ?AbstractWebPage $webPage = null;


    public function getWebPage(): ?AbstractWebPage
    {
        return $this->webPage;
    }

    public function setWebPage(?AbstractWebPage $webPage): void
    {
        if ($this->webPage && $webPage !== $this->webPage) {
            $this->webPage->removeContent($this);
        }
        $this->webPage = $webPage;
        $this->webPage?->addContent($this);
    }

}
