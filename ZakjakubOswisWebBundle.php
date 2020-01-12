<?php

namespace Zakjakub\OswisWebBundle;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zakjakub\OswisWebBundle\DependencyInjection\ZakjakubOswisWebExtension;

class ZakjakubOswisWebBundle extends Bundle
{
    final public function getContainerExtension(): Extension
    {
        return new ZakjakubOswisWebExtension();
    }
}
