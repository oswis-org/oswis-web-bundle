<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use OswisOrg\OswisCoreBundle\Provider\OswisCoreSettingsProvider;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Entity\WebPage;
use OswisOrg\OswisWebBundle\Service\WebActualityService;
use OswisOrg\OswisWebBundle\Service\WebPageService;

class SiteMapWebController extends AbstractController
{
    private WebPageService $pageService;

    private WebActualityService $actualityService;

    private OswisCoreSettingsProvider $coreSettings;

    public function __construct(
        WebPageService $pageService,
        WebActualityService $actualityService,
        OswisCoreSettingsProvider $coreSettings
    ) {
        $this->pageService = $pageService;
        $this->actualityService = $actualityService;
        $this->coreSettings = $coreSettings;
    }

    /**
     * @return Response
     * @throws LogicException
     */
    final public function showSitemapXml(): Response
    {
        $response = (new Response())->headers->set('Content-Type', 'application/xml; charset=utf-8');
        $pages = $this->pageService->getWebPages()->map(fn(WebPage $p) => ['url' => $p->getSlug()])->toArray();
        $actualities = $this->actualityService->getActualities()->map(fn(WebActuality $a) => ['url' => $a->getSlug()])->toArray();
        $otherItems = $this->getOtherItems();
        $data = [
            'url'   => $this->coreSettings->getWeb()['url'],
            'items' => [...$pages, ...$actualities, ...$otherItems],
        ];

        return $this->render('@OswisOrgOswisWeb/web/sitemap.xml.twig', $data, $response);
    }

    /**
     * Other (custom) items that may be exported to sitemap.
     */
    public function getOtherItems(): array
    {
        return []; // $item = ['url' => '', 'changeFrequency' => '', 'priority' => ''];
    }

}
