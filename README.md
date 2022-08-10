Request Convert Bundle
========================

About bundle
---------------------------
This bundle is a simple solution to convert request to DTO classes


Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
    $ composer require tandrewcl/api-request-convert
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Config and Usage
--------------------------

Thanks for Symfony flex Bundle is auto enabled in config/bundles.php

```php
...
use tandrewcl\ApiRequestConvertBundle\DTO\ResolvableInputDTOInterface;
...

class LoginDTO implements ResolvableInputDTOInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 16)]
    public ?string $login = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 16)]
    public ?string $password = null;

    public function handleRequest(Request $request): void
    {
        $params = $request->request->all();
        $this->login = $params['login'] ?? null;
        $this->password = $params['password'] ?? null;
    }
}
```
```php
...
use tandrewcl\ApiResponseConvertBundle\Handler\ResponseHandler;
...

class FooController
{
    public function loginAction(LoginDTO $loginDTO): Response
    {
        ...
        $authResult = $authService->auth($loginDTO->login, $loginDTO->password);
        ...
    }

```

