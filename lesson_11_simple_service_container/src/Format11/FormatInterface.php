<?php

namespace App11\Format11;

interface FormatInterface
{
    public  function convert(): string;
    public function setData(array $data): void;
}