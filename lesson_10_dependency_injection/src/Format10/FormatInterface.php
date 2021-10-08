<?php

namespace App10\Format10;

interface FormatInterface
{
    public  function convert(): string;
    public function setData(array $data): void;
}