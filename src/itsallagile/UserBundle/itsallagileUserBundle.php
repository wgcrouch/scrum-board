<?php

namespace itsallagile\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class itsallagileUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
