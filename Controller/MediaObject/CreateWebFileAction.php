<?php

namespace OswisOrg\OswisWebBundle\Controller\MediaObject;

use OswisOrg\OswisCoreBundle\Controller\AbstractClass\AbstractFileAction;
use OswisOrg\OswisWebBundle\Entity\MediaObject\WebFile;

final class CreateWebFileAction extends AbstractFileAction
{
    public static function getFileClassName(): string
    {
        return WebFile::class;
    }

    public static function getFileNewInstance(): WebFile
    {
        return new WebFile();
    }
}
