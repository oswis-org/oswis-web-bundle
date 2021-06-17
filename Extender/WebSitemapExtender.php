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
    protected UrlGeneratorInterface $urlGenerator;

    private WebService $webService;

    private WebFAQuestionService $faqWebService;

    public function __construct(UrlGeneratorInterface $urlGenerator, WebService $webService, WebFAQuestionService $faqWebService)
    {
        $this->urlGenerator = $urlGenerator;
        $this->webService = $webService;
        $this->faqWebService = $faqWebService;
    }

    public function getItems(): Collection
    {
        $sitemapItems = new ArrayCollection();
        $this->webService->getAbstractWebPages()->map(
            fn(AbstractWebPage $page) => $sitemapItems->add(
                new SiteMapItem(
                    $this->urlGenerator->generate('oswis_org_oswis_web_page', ['slug' => $page->getSlug()]), SiteMapItem::CHANGE_FREQUENCY_WEEKLY, null, 0.9, $page
                )
            )
        );
        try {
            $lastFaqAnswered = $this->faqWebService->getLastUpdatedAnsweredQuestion();
            $lastFaqAnsweredAt = $lastFaqAnswered ? $lastFaqAnswered->getUpdatedAt() : null;
            $sitemapItems->add(
                new SiteMapItem(
                    $this->urlGenerator->generate('oswis_org_oswis_web_faq'), SiteMapItem::CHANGE_FREQUENCY_DAILY, $lastFaqAnsweredAt
                )
            );
        } catch (RouteNotFoundException | InvalidParameterException | MissingMandatoryParametersException) {
        }

        return $sitemapItems;
    }
}