<?php

namespace bits\DI;

trait TDIContainer
{
    /**@var DI */
    private $di;

    public function setDI(DI $di)
    {
        $this->di = $di;
    }
}