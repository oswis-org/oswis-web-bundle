<?php

namespace OswisOrg\OswisWebBundle\Form\MediaObjects;

use OswisOrg\OswisCoreBundle\Form\AbstractClass\AbstractImageType;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebImage;

final class WebImageType extends AbstractImageType
{
    public static function getFileClassName(): string
    {
        return WebImage::class;
    }

    public function getBlockPrefix(): string
    {
        return 'web_web_image';
    }
}
