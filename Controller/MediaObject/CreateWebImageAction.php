<?php

namespace OswisOrg\OswisWebBundle\Controller\MediaObject;

use OswisOrg\OswisCoreBundle\Controller\AbstractClass\AbstractImageAction;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage;

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
