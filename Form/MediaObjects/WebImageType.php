<?php
/**
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Form\MediaObjects;

use Zakjakub\OswisCoreBundle\Form\AbstractClass\AbstractImageType;
use Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage;

final class WebImageType extends AbstractImageType
{
    public static function getImageClassName(): string
    {
        return WebImage::class;
    }

    public function getBlockPrefix(): string
    {
        return 'web_web_image';
    }
}
