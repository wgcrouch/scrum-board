<?php

namespace Itsallagile\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ItsallagileUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
