<?php

namespace OswisOrg\OswisWebBundle\Controller\MediaObject;

use OswisOrg\OswisCoreBundle\Controller\AbstractClass\AbstractFileAction;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebFile;
use OswisOrg\OswisWebBundle\Form\MediaObjects\WebFileType;

final class CreateWebFileAction extends AbstractFileAction
{
    public static function getFileClassName(): string
    {
        return WebFile::class;
    }

    public static function getFileFormClass(): string
    {
        return WebFileType::class;
    }

    public static function getFileNewInstance(): WebFile
    {
        return new WebFile();
    }
}
