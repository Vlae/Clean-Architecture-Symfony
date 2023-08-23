<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractRequest
{
    /**
     * @param RequestStack       $requestStack
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private readonly RequestStack $requestStack,
        protected ValidatorInterface $validator,
    ) {
        $this->attachRequestDataToProperties();
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function validate(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this);
    }

    /**
     * Check does inherit class has properties from request in it and makes assigments
     *
     * @return void
     */
    protected function attachRequestDataToProperties(): void
    {
        $payload = $this->requestStack->getCurrentRequest()->getPayload();
        foreach ($payload as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}