<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends AbstractController
{
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
