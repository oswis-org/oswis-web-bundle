<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractWebContent;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;

#[Entity]
#[Table(name: 'web_content')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_content')]
class WebContent extends AbstractWebContent
{
    /**
     * Parent event (if this is not top level event).
     */
    #[ManyToOne(targetEntity: AbstractWebPage::class, fetch: 'EAGER', inversedBy: 'contents')]
    #[JoinColumn(nullable: true)]
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
