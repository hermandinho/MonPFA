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
use PFA\CoreBundle\Entity\Project;
use PFA\MaillingBundle\Entity\Mail;
use PFA\MainBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        /** @var UploadedFile $attachement */
        foreach ($mail->getAttachements() as $attachement) {
            $message->attach(\Swift_Attachment::fromPath($attachement->getPathname()));
        }

        $this->mailer->send($message);
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

    public function sendMemberLeaveProjectMail(Project $project, User $member)
    {
        $body = $this->renderMemberLeaveProjectMail($project, $member);
        $message = \Swift_Message::newInstance()
            ->setSubject("PFA Notice: " . $project->getName() ."")
            ->setFrom($member->getEmail())
            ->setTo($project->getOwner()->getEmail())
            ->setBody($body)
            ->setContentType("text/html");

        $this->mailer->send($message);
    }

    private function renderMemberLeaveProjectMail(Project $project, User $member)
    {
        return $this->twig->render(
            'PFAMaillingBundle:partials:send_member_leave_project.html.twig',
            array(
                'project' => $project,
                "member" => $member
            )
        );
    }

    public function sendNewModeratorMail(Project $project, User $sender, User $receiver)
    {
        $body = $this->renderNewModeratorMail($project, $sender, $receiver);
        $message = \Swift_Message::newInstance()
            ->setSubject("PFA Notice:" . $project->getName() ."")
            ->setFrom($sender->getEmail())
            ->setTo($receiver->getEmail())
            ->setBody($body)
            ->setContentType("text/html");

        $this->mailer->send($message);
    }

    private function renderNewModeratorMail(Project $project, User $sender, User $receiver)
    {
        return $this->twig->render(
            'PFAMaillingBundle:partials:send_new_moderator_mail.html.twig',
            array(
                'project' => $project,
                "sender" => $sender,
                "receiver" => $receiver
            )
        );
    }




    public function loadSentMails(User $owner) {
        return $this->mailRepo->findBy(['sender' => $owner->getId()],["date" => "DESC"]);
    }


    /**
     * @param Mail $mail
     * @return array
     */
    public function getMailChildren(Mail $mail)
    {
        return $this->mailRepo->getMailChildren($mail);
    }
}