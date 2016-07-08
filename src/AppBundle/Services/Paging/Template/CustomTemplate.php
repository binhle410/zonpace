<?php

namespace AppBundle\Services\Paging\Template;

use Pagerfanta\View\Template\DefaultTemplate;

class CustomTemplate extends DefaultTemplate
{
    static protected $defaultOptions = array(
        'previous_message'   => 'Previous',
        'next_message'       => 'Next',
        'css_disabled_class' => 'disabled',
        'css_dots_class'     => 'dots',
        'css_current_class'  => 'current',
        'dots_text'          => '...',
        'container_template' => '<ul class="pagination">%pages%</ul>',
        'page_template'      => '<li class="paginate_button"><a href="%href%">%text%</a></li>',
        'span_template'      => '<li class="paginate_button disabled active"><a href="javascript:void(0)">%text%</a></li>',
    );
}