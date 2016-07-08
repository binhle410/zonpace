<?php

namespace AppBundle\Services\Paging;

use Pagerfanta\View\DefaultView;
use AppBundle\Services\Paging\Template\CustomAjaxTemplate;

class CustomAjaxView extends DefaultView
{
    protected function createDefaultTemplate()
    {
        return new CustomAjaxTemplate();
    }
}