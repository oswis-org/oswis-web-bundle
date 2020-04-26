<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisWebBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqWebController extends AbstractController
{
    /**
     * @return Response
     */
    public function showFaq(): Response
    {
        $data = [
            'questions' => new ArrayCollection(),
        ];

        return $this->render('@OswisOrgOswisWeb/web/pages/web-faq.html.twig', $data);
    }
}
