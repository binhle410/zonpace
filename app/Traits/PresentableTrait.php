<?php

namespace App\Traits;

use App\Exceptions\PresenterException;

Trait PresentableTrait
{
    protected static $_presenterInstance = null;

    /**
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (!$this->presenter or !class_exists($this->presenter)) {
            throw new PresenterException('Please set the $protected property to your presenter path.');
        }

        if (null === static::$_presenterInstance) {
            static::$_presenterInstance = new $this->presenter($this);
        }

        return static::$_presenterInstance;
    }
}