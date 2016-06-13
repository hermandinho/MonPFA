<?php

namespace PFA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                "label" => "Nom du document"
            ))
            ->add('image_file', "file", array(
                "label" => "Sélectionner un Fichier"
            ))
            ->add("description",'textarea', array(
                "label" => "Description du document",
                "attr" => array(
                    "class" => "materialize-textarea"
                ),
                "required" => true
            ))
            //->add('path')
            //->add('extention')
            //->add('version')
            //->add('parent')
            //->add('imageName', "file")
            //->add('updatedAt', 'datetime')
            //->add('shareZone')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\MainBundle\Entity\Documents'
        ));
    }
}
