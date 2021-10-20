<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use ApiPlatform\Core\Validator\Exception\ValidationException;

use App\Entity\Image;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\ImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
class UploadImageAction
{
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ){
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function __invoke(Request $request){
        //  Create a new Image instance
        $image = new Image();
        //  Validate the form
        $form = $this->formFactory->create(ImageType::class, $image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //  Persist the new Image entity
            $this->entityManager->persist($image);
            $this->entityManager->flush();

            $image->setFile(null);

            return $image;
        }
        // Uploading done in the background through VichUploader

        // Throw a validation exception if something went wrong during form validation.
        throw new ValidationException(
          $this->validator->validate($image)
        );
    }
}