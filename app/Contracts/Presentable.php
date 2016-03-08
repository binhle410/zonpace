<?php

namespace App\Contracts;

interface Presentable
{
    /**
     * @return mixed
     */
    public function createdAt();

    /**
     * @return mixed
     */
    public function updatedAt();
}
