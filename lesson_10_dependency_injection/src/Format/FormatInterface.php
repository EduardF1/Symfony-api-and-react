<?php

namespace App\Format10;

interface FormatInterface
{
    public  function convert(): string;
    public function setData(array $data): void;
}