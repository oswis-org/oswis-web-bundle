<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use OswisOrg\OswisCoreBundle\Provider\OswisCoreSettingsProvider;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use OswisOrg\OswisWebBundle\Service\WebActualityService;
use OswisOrg\OswisWebBundle\Service\WebPageService;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteMapWebController extends AbstractController
{
    private WebService $webService;

    private OswisCoreSettingsProvider $coreSettings;

    public function __construct(OswisCoreSettingsProvider $coreSettings, WebService $webService)
    {
        $this->coreSettings = $coreSettings;
        $this->webService = $webService;
    }

    /**
     * @return Response
     */
    final public function showSitemapXml(): Response
    {
        $response = (new Response())->headers->set('Content-Type', 'application/xml; charset=utf-8');
        $items = $this->webService->getAbstractWebPages()
            ->map(fn(AbstractWebPage $p) => ['slug' => $p->getSlug()])
            ->toArray();
        $otherItems = $this->getOtherItems();
        $data = [
            'items' => [...$items, ...$otherItems],
        ];

        return $this->render('@OswisOrgOswisWeb/web/sitemap.xml.twig', $data, $response);
    }

    /**
     * Other (custom) items that may be exported to sitemap.
     */
    public function getOtherItems(): array
    {
        return []; // $item = ['url' => '', 'changeFrequency' => '', 'priority' => (0.0...1.0)];
    }

}
