<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use DateTime;
use OswisOrg\OswisCoreBundle\Exceptions\OswisNotFoundException;
use OswisOrg\OswisWebBundle\Entity\WebActuality;
use OswisOrg\OswisWebBundle\Entity\WebMediaGallery;
use OswisOrg\OswisWebBundle\Service\WebService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WebController extends AbstractController
{
    public const PAGE_SIZE = 10;

    private WebService $webService;

    public function __construct(WebService $webService)
    {
        $this->webService = $webService;
    }

    /**
     * @param string|null $slug
     *
     * @return Response
     * @throws OswisNotFoundException
     */
    public function showPage(string $slug = null): Response
    {
        $data = [
            'pageData' => $this->webService->getAbstractWebPage(new DateTime(), null, null, $slug),
        ];
        if (empty($data['pageData'])) {
            throw new OswisNotFoundException("(požadovaná stránka: '$slug')");
        }
        if ($data['pageData'] instanceof WebActuality) {
            return $this->render('@OswisOrgOswisWeb/web/pages/web-actuality.html.twig', $data);
        }
        if ($data['pageData'] instanceof WebMediaGallery) {
            return $this->render('@OswisOrgOswisWeb/web/pages/web-media-gallery.html.twig', $data);
        }

        return $this->render('@OswisOrgOswisWeb/web/pages/web-page.html.twig', $data);
    }

    /**
     * @param int|null $limit      Limit of items on page.
     * @param bool     $pagination Enables pagination.
     * @param int      $page       Number of page.
     *
     * @return Response
     * @throws OswisNotFoundException
     */
    public function showWebActualitiesChunk(int $page = 0, ?int $limit = null, bool $pagination = false): Response
    {
        return $this->render(
            '@OswisOrgOswisWeb/web/parts/web-actualities.html.twig',
            $this->getWebActualitiesData($page, $limit, $pagination)
        );
    }

    /**
     * @param int|null $limit
     * @param int      $page
     * @param bool     $pagination
     *
     * @return array
     * @throws OswisNotFoundException
     */
    public function getWebActualitiesData(int $page = 0, ?int $limit = null, bool $pagination = false): array
    {
        if ($page < 0) {
            throw new OswisNotFoundException('Požadovaná stránka aktualit musí být kladným číslem.');
        }
        $limit = $limit > 0 ? $limit : self::PAGE_SIZE;
        $offset = $page * $limit;

        return [
            'page'        => $page,
            'pagination'  => $pagination,
            'limit'       => $limit,
            'actualities' => $this->webService->getAbstractWebPages(new DateTime(), $limit, $offset, null, WebActuality::class),
        ];
    }

    /**
     * @param int|null $limit      Limit of items on page.
     * @param bool     $pagination Enables pagination.
     * @param int      $page       Number of page.
     *
     * @return Response
     * @throws OswisNotFoundException
     */
    public function showWebActualities(int $page = 0, ?int $limit = null, bool $pagination = true): Response
    {
        return $this->render(
            '@OswisOrgOswisWeb/web/pages/web-actualities.html.twig',
            $this->getWebActualitiesData($limit ?? self::PAGE_SIZE, $page, $pagination)
        );
    }
}
