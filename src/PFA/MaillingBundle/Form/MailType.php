<?php

namespace PFA\MaillingBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('receivers', Select2EntityType::class, [
                    "mapped" => false,
                    'multiple' => true,
                    'remote_route' => 'get_user_list_json',
                    'class' => 'PFA\MainBundle\Entity\User',
                    'primary_key' => 'id',
                    //'text_property' => 'nom',
                    'minimum_input_length' => 2,
                    'page_limit' => 10,
                    'allow_clear' => true,
                    'delay' => 250,
                    'cache' => true,
                    //'cache_timeout' => 60000, // if 'cache' is true
                    'language' => 'fr',
                    'placeholder' => 'Select a User',
                 ]
            ) */
            ->add('subject', TextType::class)
            ->add('body', CKEditorType::class, array(
                "label" => " ",
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
