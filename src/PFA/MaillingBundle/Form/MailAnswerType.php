<?php

namespace PFA\MaillingBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailAnswerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', CKEditorType::class, array(
                "label" => " ",
                "data" =>"",
                "attr" => [
                    "class" => "materialize-textarea characterCounter"
                ]
            ))
            ->add('attachements', FileType::class, array(
                "label" => "",
                "required" => false
            ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\MaillingBundle\Entity\MailAnswer'
        ));
    }
}
