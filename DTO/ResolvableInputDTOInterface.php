<?php

namespace tandrewcl\ApiRequestConvertBundle\DTO;

use Symfony\Component\HttpFoundation\Request;

interface ResolvableInputDTOInterface
{
    public function handleRequest(Request $request): void;
}
