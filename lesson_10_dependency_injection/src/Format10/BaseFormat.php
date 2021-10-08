<?php

namespace App10\Format10;

abstract class BaseFormat {
    protected $data;

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public abstract function convert(): string;

    public function __toString()
    {
        return $this->convert();
    }
}