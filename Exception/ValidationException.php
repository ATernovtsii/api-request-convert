<?php

namespace tandrewcl\ApiRequestConvertBundle\Exception;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    /**
     * Array of errors [$field => $error]
     */
    private array $errors = [];
    /**
     * Array of error params for translation [$field => [$identifier => $value]]
     */
    private array $errorParams = [];

    public function __construct()
    {
        parent::__construct('', 422);
    }

    /**
     * @param string $field
     * @param string $error
     * @param array  $errorParams
     * @return ValidationException
     */
    public function setError(string $field, string $error, array $errorParams = []): ValidationException
    {
        $this->errors[$field] = $error;
        if ($errorParams) {
            $this->addErrorParams($field, $errorParams);
        }

        return $this;
    }

    /**
     * @param array $errors
     * @param array $errorParams
     * @return ValidationException
     */
    public function setErrors(array $errors, array $errorParams = []): ValidationException
    {
        foreach ($errors as $field => $error) {
            $this->setError($field, $error);
        }

        foreach ($errorParams as $field => $errorParam) {
            $this->addErrorParams($field, $errorParam);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return (bool)$this->errors;
    }

    /**
     * @param string $field
     * @return bool
     */
    public function isFieldInvalid(string $field): bool
    {
        return !empty($this->errors[$field]);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $field
     * @return array
     */
    public function getFieldErrorParams(string $field): array
    {
        return $this->errorParams[$field] ?? [];
    }

    /**
     * @param string $field
     * @param array  $errorParams
     */
    public function addErrorParams(string $field, array $errorParams): void
    {
        $this->errorParams[$field] = $errorParams;
    }

    /**
     * @return array
     */
    public function getErrorParams(): array
    {
        return $this->errorParams;
    }
}