<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordAction
{
    private ValidatorInterface $validator;
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private JWTTokenManagerInterface $tokenManager;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $tokenManager,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->validator = $validator;
        $this->tokenManager = $tokenManager;
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function  __invoke(User $data): JsonResponse{
//        var_dump(
//            $data->getNewPassword(),
//            $data->getNewRetypedPassword(),
//            $data->getOldPassword()
//        );die;
        $this->validator->validate($data);

        $data->setPassword(
            $this->userPasswordHasher->hashPassword(
                $data,
                $data->getNewPassword()
            )
        );
        $data->setPasswordChangeDate(time());

        $this->entityManager->flush();
        $token = $this->tokenManager->create($data);

        return new JsonResponse(['token' => $token]);
    }
}