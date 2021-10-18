<?php

namespace App\Entity;

interface IPublishedDateEntity
{
    public function setPublished(\DateTimeInterface $published): IPublishedDateEntity;
}