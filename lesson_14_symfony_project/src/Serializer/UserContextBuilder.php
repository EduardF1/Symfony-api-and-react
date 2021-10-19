<?php

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserContextBuilder implements SerializerContextBuilderInterface
{

    private SerializerContextBuilderInterface $decorated;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(
        SerializerContextBuilderInterface $decorated,
        AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(
        Request $request,
        bool $normalization,
        array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest(
          $request, $normalization, $extractedAttributes
        );

        // Class being serialized/deserialized
        $resourceClass = $context['resource_class'] ?? null;    // Default to null if not set

        if(
            User::class === $resourceClass &&
            isset($context['groups']) &&
            $normalization === true &&
            $this->authorizationChecker->isGranted(User::ROLE_ADMIN)
        ){
            $context['groups'][] = 'get-admin';
        }
        return $context;
    }
}