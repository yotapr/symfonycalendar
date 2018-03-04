<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
  public function login(Request $request, AuthenticationUtils $authUtils)
  {
    $error = $authUtils->getLastAuthenticationError();

    $lastUsername = $authUtils->getLastUsername();

    return $this->render('login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
  }
}
