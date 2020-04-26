<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use OswisOrg\OswisWebBundle\Service\FaqWebService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqWebController extends AbstractController
{
    private FaqWebService $faqWebService;

    public function __construct(FaqWebService $webService)
    {
        $this->faqWebService = $webService;
    }

    /**
     * @return Response
     */
    public function showFaq(): Response
    {
        return $this->render(
            '@OswisOrgOswisWeb/web/pages/web-faq.html.twig',
            ['questions' => $this->faqWebService->getAnsweredQuestions()]
        );
    }
}
