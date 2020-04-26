<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use DateTime;
use LogicException;
use OswisOrg\OswisCoreBundle\Provider\OswisCoreSettingsProvider;
use OswisOrg\OswisWebBundle\Service\WebActualityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RssFeedController extends AbstractController
{
    private OswisCoreSettingsProvider $coreSettings;

    private WebActualityService $actualityService;

    public function __construct(OswisCoreSettingsProvider $coreSettings, WebActualityService $actualityService)
    {
        $this->coreSettings = $coreSettings;
        $this->actualityService = $actualityService;
    }

    /**
     * @param int|null $limit Amount of messages.
     *
     * @return Response
     * @throws LogicException
     */
    public function showRss(?int $limit = null): Response
    {
        $data = [
            'title'       => $this->coreSettings->getWeb()['title'],
            'base'        => $this->coreSettings->getWeb()['url'],
            'actualities' => $this->actualityService->getRepository()
                ->getActualities(new DateTime(), $limit ?? 15),
            // 'image'       => ['url' => '', 'width' => null, 'height' => null],
        ];
        $response = (new Response())->headers->set('Content-Type', 'application/xml; charset=utf-8');

        return $this->render('@OswisOrgOswisWeb/web/rss.xml.twig', $data, $response);
    }
}
