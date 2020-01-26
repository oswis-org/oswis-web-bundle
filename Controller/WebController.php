<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Controller;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Zakjakub\OswisCoreBundle\Exceptions\OswisNotFoundException;
use Zakjakub\OswisWebBundle\Entity\WebActuality;
use Zakjakub\OswisWebBundle\Entity\WebMediaGallery;
use Zakjakub\OswisWebBundle\Service\WebService;

class WebController extends AbstractController
{
    public const PAGE_SIZE = 15;

    private WebService $webService;

    public function __construct(WebService $webService)
    {
        $this->webService = $webService;
    }

    /**
     * @param string|null $slug
     *
     * @return Response
     * @throws LogicException
     * @throws OswisNotFoundException
     */
    public function showPage(string $slug = null): Response
    {
        $data = [
            'page' => $this->webService->getAbstractWebPage(new DateTime(), null, null, $slug),
        ];
        if (empty($data['page'])) {
            throw new OswisNotFoundException("(požadovaná stránka: '$slug')");
        }
        if ($data['page'] instanceof WebActuality) {
            return $this->render('@ZakjakubOswisWeb/web/pages/web-actuality.html.twig', $data);
        }
        if ($data['page'] instanceof WebMediaGallery) {
            return $this->render('@ZakjakubOswisWeb/web/pages/web-media-gallery.html.twig', $data);
        }

        return $this->render('@ZakjakubOswisWeb/web/pages/web-page.html.twig', $data);
    }

    /**
     * @param int|null $limit
     * @param int      $page
     * @param bool     $pagination
     *
     * @return array
     * @throws OswisNotFoundException
     */
    public function getWebActualitiesData(?int $limit = null, int $page = 0, bool $pagination = false): array
    {
        if ($page < 0) {
            throw new OswisNotFoundException('Požadovaná stránka aktualit musí být kladným číslem.');
        }

        return [
            'page'        => $page,
            'pagination'  => $pagination,
            'actualities' => $this->webService->getAbstractWebPages(
                new DateTime(),
                $limit > 0 ? $limit : self::PAGE_SIZE,
                $page * self::PAGE_SIZE,
                null,
                WebActuality::class
            ),
        ];
    }

    /**
     * @param int|null $limit      Limit of items on page.
     * @param bool     $pagination Enables pagination.
     * @param int      $page       Number of page.
     *
     * @return Response
     * @throws LogicException
     * @throws OswisNotFoundException
     */
    public function showWebActualitiesChunk(?int $limit = null, int $page = 0, bool $pagination = false): Response
    {
        return $this->render(
            '@ZakjakubOswisWeb/web/parts/web-actualities.html.twig',
            $this->getWebActualitiesData($limit, $page, $pagination)
        );
    }

    /**
     * @param int|null $limit      Limit of items on page.
     * @param bool     $pagination Enables pagination.
     * @param int      $page       Number of page.
     *
     * @return Response
     * @throws LogicException
     * @throws OswisNotFoundException
     */
    public function showWebActualities(int $page = 0, bool $pagination = false, ?int $limit = null): Response
    {
        return $this->render(
            '@ZakjakubOswisWeb/web/pages/web-actualities.html.twig',
            $this->getWebActualitiesData($limit, $page, $pagination)
        );
    }

    /**
     * @return Response
     * @throws LogicException
     */
    public function showFaq(): Response
    {
        $data = [
            'questions' => new ArrayCollection(),
        ];

        return $this->render('@ZakjakubOswisWeb/web/parts/web-actualities.html.twig', $data);
    }
}
