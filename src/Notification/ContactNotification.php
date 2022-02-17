<?php
namespace App\Notification;


use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactNotification{


    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer ){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact) {
        $message = (new Email())
            ->from('noreply@agence.fr')
            ->to('contact@agence.fr')
            ->subject('Agence' . $contact->getProperty()->getTitle())
            ->html($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]))
        ;

        dd($this->mailer->send($message));

//        $message = (new Email('Agence' . $contact->getProperty()->getTitle()))
//            ->setFrom('noreply@agence.fr')
//            ->setTo('contact@agence.fr')
//            ->setReplyTo($contact->getEmail())
//            ->setBody($this->renderer->render('emails/contact.html.twig', [
//                'contact' => $contact
//            ]), 'text/html' );
        $this->mailer->send($message);

    }
}