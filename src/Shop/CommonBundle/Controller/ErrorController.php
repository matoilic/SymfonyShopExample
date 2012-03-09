<?php

namespace Shop\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    public function csrfMismatchAction(Request $request)
    {
        $response = new Response();
        $response->setStatusCode(403, 'Access Denied');
        $response->setContent('403 Access denied: CSRF mismatch');
        $response->headers->set('Content-type', 'text/plain');

        return $response;
    }
}
