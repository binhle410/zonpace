<?php

namespace App\Presenters;

abstract class Presenter
{
    protected $entity;

    /**
     * AbstractPresenter constructor.
     *
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Present the createdAt property
     * using a different format
     *
     * @return string
     */
    public function createdAt()
    {
        return $this->entity->created_at->format('Y-m-d');
    }

    /**
     * Present the updatedAt property
     * using a different format
     *
     * @return string
     */
    public function updatedAt()
    {
        return $this->entity->updated_at->format('Y-m-d');
    }

    /**
     * Check to see if there is a presenter
     * method. If not pass to the object
     *
     * @param string $key
     */
    public function __get($property)
    {
        if (method_exists($this, $property))
        {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }
}
