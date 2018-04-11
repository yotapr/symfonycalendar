<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
class MailController extends Controller
{
public function welcomeuser($name, $mail, \Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Welcome Email'))
        ->setFrom("zavaroni@nolitaweb.it")
        ->setTo("parmalibera@gmail.com")
        ->setBody(
            $this->renderView(
                'email.html.twig',
                array('name' => $name)
            ),
            'text/html'
        )
    ;
    $mailer->send($message);
    return $this->render('email.html.twig', array('name' => $name));
}
public function recoverpassword($mail, $recoverurl, \Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Welcome Email'))
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                'recoverpasswordemail.html.twig',
                array('recoverurl' => $recoverurl)
            ),
            'text/html'
        )
    ;
    $mailer->send($message);
    return $this->render('recoverpasswordemail.html.twig', array('recoverurl' => $recoverurl));
}
}
