<?php

namespace tandrewcl\ApiRequestConvertBundle\ArgumentResolver;

use tandrewcl\ApiRequestConvertBundle\DTO\ResolvableInputDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\{Controller\ArgumentValueResolverInterface, ControllerMetadata\ArgumentMetadata};
use Symfony\Component\Security\Core\{Security, User\UserInterface};
use Symfony\Component\Validator\{Constraint, ConstraintViolation, Validator\ValidatorInterface};
use tandrewcl\ApiRequestConvertBundle\Exception\ValidationException;

class InputDTOResolver implements ArgumentValueResolverInterface
{
    public function __construct(private readonly ValidatorInterface $validator, private readonly Security $security)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();
        if (!$type) {
            return false;
        }

        return is_subclass_of($type, ResolvableInputDTOInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var ResolvableInputDTOInterface $DTO */
        $DTO = new ($argument->getType())();
        $DTO->handleRequest($request);
        $this->validateObject($DTO);
        yield $DTO;
    }

    /**
     * @throws ValidationException
     */
    protected function validateObject(ResolvableInputDTOInterface $object): void
    {
        $user = $this->security->getUser();
        $groups = [
            Constraint::DEFAULT_GROUP,
            $user instanceof UserInterface ? 'LoggedIn' : 'NotLoggedIn',
        ];
        $violationList = $this->validator->validate($object, groups: $groups);
        if ($violationList->count()) {
            $validationException = new ValidationException();
            /** @var ConstraintViolation $violation */
            foreach ($violationList as $violation) {
                $validationException->setError($violation->getPropertyPath(), $violation->getMessage());
            }
            if ($validationException->hasErrors()) {
                throw $validationException;
            }
        }
    }
}
