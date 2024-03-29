<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $request->getSession()->getFlashBag()->add('note', 'You have to login in order to access this page.');

        return new JsonResponse([
            'message' => $authException->getMessage()
        ], Response::HTTP_UNAUTHORIZED);
    }
}