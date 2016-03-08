<?php

namespace App\Services\Macros;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class Links
 * @package App\Services\Macros
 */
trait Forms
{
    public function bootWrapped($name, $label, $callback)
    {
        /** @var \Illuminate\Support\MessageBag $errors */
        $errors = Session::get('errors', new \Illuminate\Support\MessageBag);

        return sprintf(
            '<div class="form-group %s">
              <label class="control-label">%s</label>
              %s
              %s
            </div>',
            $errors->has($name) ? 'has-error' : '',
            $label,
            $callback($name),
            $errors->first($name, '<span class="help-block">:message</span>')
        );
    }

    /**
     * @param $name
     * @param $label
     * @return string
     */
    public function email($name, $label)
    {
        return $this->bootWrapped($name, $label, function() use ($name) {
            return $this->text($name, null, ['class' => 'form-control']);
        });
    }
}