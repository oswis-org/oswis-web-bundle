<?php

namespace Zakjakub\OswisWebBundle\Controller\MediaObject;

use Zakjakub\OswisCoreBundle\Controller\AbstractClass\AbstractImageAction;
use Zakjakub\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage;

final class CreateWebImageAction extends AbstractImageAction
{
    public static function getImageClassName(): string
    {
        return WebImage::class;
    }

    public static function getImageNewInstance(): AbstractImage
    {
        return new WebImage();
    }
}
