<?php

namespace AppBundle\Services\Paging;

use Pagerfanta\View\DefaultView;
use AppBundle\Services\Paging\Template\CustomTemplate;

class CustomView extends DefaultView
{
    protected function createDefaultTemplate()
    {
        return new CustomTemplate();
    }
}