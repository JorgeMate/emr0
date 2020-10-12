<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LogoutListener{

    public function logout(Request $request, Response $response, TokenInterface $token, SessionInterface $session)
    {

        var_dump($session);die;

        $idLogin = $session->get('idLogin');

        var_dump($idLogin);die;

        if($idLogin){ // Exite una variable de sesión almacenando idLogin


        }
    }

}
