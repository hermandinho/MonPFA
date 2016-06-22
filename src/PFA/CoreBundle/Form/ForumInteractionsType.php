<?php

namespace PFA\CoreBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumInteractionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', "text" ,
                array(
                    "label" => "Sujet",
                    "attr" => array(
                        "autocomplete" =>"off"
                    )
                )
            )
            ->add('content', CKEditorType::class, array(
                "label" => " "
            ))
            //->add('parent')
            //->add('forum')
            //->add('owner')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\CoreBundle\Entity\ForumInteractions'
        ));
    }
}
