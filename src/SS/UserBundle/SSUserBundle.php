<?php

namespace SS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SSUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
