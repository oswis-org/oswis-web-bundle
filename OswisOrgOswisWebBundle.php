<?php

namespace OswisOrg\OswisWebBundle;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use OswisOrg\OswisWebBundle\DependencyInjection\OswisOrgOswisWebExtension;

class OswisOrgOswisWebBundle extends Bundle
{
    final public function getContainerExtension(): Extension
    {
        return new OswisOrgOswisWebExtension();
    }
}
