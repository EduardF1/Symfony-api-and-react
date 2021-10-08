<?php
declare(strict_types=1);
namespace App\Format9;

abstract class BaseFormat
{
    protected $data;

    public function __construct(?array $data = [])
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

    public abstract function convert();


    public function __toString(){
        return $this->convert();
    }
}