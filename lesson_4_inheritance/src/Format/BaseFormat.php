<?php

namespace App\Format4;

class BaseFormat
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function convert(): string
    {
        return "I'm not converting anything";
    }

    public function __toString(){
        return $this->convert();
    }
}