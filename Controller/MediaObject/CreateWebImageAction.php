<?php

namespace Zakjakub\OswisWebBundle\Controller\MediaObject;

use Zakjakub\OswisCoreBundle\Controller\AbstractClass\AbstractImageAction;
use Zakjakub\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage;

final class CreateWebImageAction extends AbstractImageAction
{
    public static function getFileClassName(): string
    {
        return WebImage::class;
    }

    public static function getFileNewInstance(): AbstractImage
    {
        return new WebImage();
    }
}
