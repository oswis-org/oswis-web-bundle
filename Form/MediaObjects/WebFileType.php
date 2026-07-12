<?php

namespace OswisOrg\OswisWebBundle\Form\MediaObjects;

use OswisOrg\OswisCoreBundle\Form\AbstractClass\AbstractFileType;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebFile;

final class WebFileType extends AbstractFileType
{
    public static function getFileClassName(): string
    {
        return WebFile::class;
    }

    public function getBlockPrefix(): string
    {
        return 'web_web_file';
    }
}
