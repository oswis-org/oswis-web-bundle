<?php

namespace OswisOrg\OswisWebBundle;

use OswisOrg\OswisWebBundle\DependencyInjection\OswisOrgOswisWebExtension;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OswisOrgOswisWebBundle extends Bundle
{
    final public function getContainerExtension(): Extension
    {
        return new OswisOrgOswisWebExtension();
    }
}
