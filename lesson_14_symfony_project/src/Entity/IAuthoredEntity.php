<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface IAuthoredEntity
{
    public function setAuthor(UserInterface $user): IAuthoredEntity;
}