<?php

namespace PFA\MaillingBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receiver', EntityType::class, [
                "class" => "PFAMainBundle:User",
                "choice_label" => "username",
                "attr" => [
                    "multiple" => true
                ]
            ])
            ->add('subject', TextType::class)
            ->add('body', CKEditorType::class, array(
                "attr" => [
                    "class" => "materialize-textarea characterCounter"
                ]
            ))
            //->add('isRead')
            //->add('date', 'datetime')
            //->add('attachements')
            //->add('sender')
            //->add('receiver')
            //->add('mailBox')
            //->add('folder')
            //->add('parent')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\MaillingBundle\Entity\Mail'
        ));
    }
}
