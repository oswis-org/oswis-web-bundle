<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Extender;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\SiteMapItem;
use OswisOrg\OswisCoreBundle\Interfaces\Web\SiteMapExtenderInterface;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use OswisOrg\OswisWebBundle\Service\WebFAQuestionService;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WebSitemapExtender implements SiteMapExtenderInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly WebService $webService,
        private readonly WebFAQuestionService $faqWebService,
    ) {
    }

    public function getItems(): Collection
    {
        $sitemapItems = new ArrayCollection();
        $this->webService->getAbstractWebPages()->map(
            function (mixed $page) use ($sitemapItems) {
                /** @var AbstractWebPage $page */
                $sitemapItems->add(
                    new SiteMapItem(
                        $this->urlGenerator->generate('oswis_org_oswis_web_page', ['slug' => $page->getSlug()]),
                        SiteMapItem::CHANGE_FREQUENCY_WEEKLY,
                        null,
                        0.9,
                        $page
                    ),
                );
            }
        );
        try {
            $lastFaqAnswered = $this->faqWebService->getLastUpdatedAnsweredQuestion();
            $lastFaqAnsweredAt = $lastFaqAnswered?->getUpdatedAt();
            $sitemapItems->add(
                new SiteMapItem(
                    $this->urlGenerator->generate('oswis_org_oswis_web_faq'), SiteMapItem::CHANGE_FREQUENCY_DAILY, $lastFaqAnsweredAt
                )
            );
        } catch (RouteNotFoundException|InvalidParameterException|MissingMandatoryParametersException) {
        }

        return $sitemapItems;
    }
}