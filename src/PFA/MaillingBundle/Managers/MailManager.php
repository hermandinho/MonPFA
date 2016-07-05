<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 18/05/2016
 * Time: 16:26
 */

namespace PFA\MaillingBundle\Managers;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use PFA\MaillingBundle\Entity\Mail;
use PFA\MainBundle\Entity\User;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MailManager
{
    /**
     * @var EntityManager
     */
    private $em;
    /** @var string $fromAddress */
    protected $fromAddress;
    /** @var \Twig_Environment */
    protected $twig;
    /** @var \Swift_Mailer */
    protected $mailer;
    /** @var TokenGeneratorInterface */
    protected $tokenGenerator;
    /** @var TokenStorage */
    protected $tokenStorage;

    /**
     * MailManager constructor.
     * @param EntityManager $entityManager
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     * @param Router $router
     * @param TokenGeneratorInterface $tokenGenerator
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManager $entityManager,
                                \Twig_Environment $twig,
                                \Swift_Mailer $mailer,
                                Router $router,
                                TokenGeneratorInterface $tokenGenerator,
                                TokenStorage $tokenStorage)
    {
        $this->em = $entityManager;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenStorage = $tokenStorage;

        $this->userRepo = $this->em->getRepository("PFAMainBundle:User");
        $this->mailRepo = $this->em->getRepository("PFAMaillingBundle:Mail");
    }

    public function sendNormalMail(User $from, User $to, Mail $mail)
    {
        $body = $this->renderConfirmationEmail($mail);

        $message = \Swift_Message::newInstance()
                ->setSubject($mail->getSubject())
                ->setFrom($from->getEmail())
                ->setTo($to->getEmail())
                ->setBody($body)
                ->setContentType("text/html");
        $this->mailer->send($message);
    }

    /**
     * @param Mail $mail
     * @return array
     */
    public function getMailChildren(Mail $mail)
    {
        return $this->mailRepo->getMailChildren($mail);
    }

    private function renderConfirmationEmail(Mail $mail)
    {
        return $this->twig->render(
            'PFAMaillingBundle:partials:send_normal_mail.html.twig',
            array(
                'mail' => $mail
            )
        );
    }
}