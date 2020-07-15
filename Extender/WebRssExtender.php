<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Extender;

use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\RssItem;
use OswisOrg\OswisCoreBundle\Interfaces\Common\RssExtenderInterface;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WebRssExtender implements RssExtenderInterface
{
    protected UrlGeneratorInterface $urlGenerator;

    private WebService $webService;

    public function __construct(UrlGeneratorInterface $urlGenerator, WebService $webService)
    {
        $this->urlGenerator = $urlGenerator;
        $this->webService = $webService;
    }

    public function getItems(): Collection
    {
        return $this->webService->getLastActualities()->map(
            fn(WebActuality $actuality) => new RssItem(
                $this->urlGenerator->generate('oswis_org_oswis_web_page', ['slug' => $actuality->getSlug()]),
                $actuality->getName(),
                $actuality->getDateTime(),
                $actuality->getTextValue()
            )
        );
    }
}