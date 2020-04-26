<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use DateTime;
use OswisOrg\OswisCoreBundle\Provider\OswisCoreSettingsProvider;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Service\WebActualityService;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RssFeedController extends AbstractController
{
    private OswisCoreSettingsProvider $coreSettings;

    private WebService $webService;

    public function __construct(OswisCoreSettingsProvider $coreSettings, WebService $webService)
    {
        $this->coreSettings = $coreSettings;
        $this->webService = $webService;
    }

    /**
     * @param int|null $limit Amount of messages.
     *
     * @return Response
     */
    public function showRss(?int $limit = null): Response
    {
        $data = [
            'title'       => $this->coreSettings->getWeb()['title'],
            'actualities' => $this->webService->getAbstractWebPages(new DateTime(), $limit ?? 15, 0, null, WebActuality::class),
            'image'       => $this->coreSettings->getApp()['logo'],
            // 'image'       => ['url' => '', 'width' => null, 'height' => null],
        ];
        $response = (new Response())->headers->set('Content-Type', 'application/xml; charset=utf-8');

        return $this->render('@OswisOrgOswisWeb/web/rss.xml.twig', $data, $response);
    }
}
