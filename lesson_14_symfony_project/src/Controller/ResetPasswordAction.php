<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;

class ResetPasswordAction
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator){
        $this->validator = $validator;
    }

    public function  __invoke(User $data){
//        var_dump(
//            $data->getNewPassword(),
//            $data->getNewRetypedPassword(),
//            $data->getOldPassword()
//        );die;
        $this->validator->validate($data);
        return $data;
    }
}