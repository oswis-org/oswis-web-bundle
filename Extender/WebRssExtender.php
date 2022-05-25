<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Extender;

use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\RssItem;
use OswisOrg\OswisCoreBundle\Interfaces\Web\RssExtenderInterface;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WebRssExtender implements RssExtenderInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly WebService $webService,
    ) {
    }

    public function getItems(): Collection
    {
        return $this->webService->getLastActualities()->map(function (mixed $actuality) {
            /** @var WebActuality $actuality */
            return new RssItem($this->urlGenerator->generate('oswis_org_oswis_web_page', ['slug' => $actuality->getSlug()],), $actuality->getName(),
                $actuality->getDateTime(), $actuality->getTextValue(),);
        });
    }
}