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
     * @var array
     */
    private $options = [];


    /**
     * MailType constructor.
     */
    public function __construct($options = null)
    {
        $this->options = $options;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!isset($this->options['is_answer'])) {
            $builder
                ->add('subject', TextType::class);
        }
        $builder
            ->add('body', CKEditorType::class, array(
                "label" => " ",
                "data" =>"",
                "attr" => [
                    "class" => "materialize-textarea characterCounter"
                ]
            ))
            ->add('attachements', "file", array(
                "label" => "",
                "required" => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'PFA\MaillingBundle\Entity\Mail'
            'data_class' => null
        ));
    }
}
