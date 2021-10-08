<?php

namespace App13\Format13;

interface FormatInterface
{
    public  function convert(): string;
    public function setData(array $data): void;
}