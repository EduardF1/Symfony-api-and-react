<?php

namespace App12\Format12;

interface FormatInterface
{
    public  function convert(): string;
    public function setData(array $data): void;
}