<?php

namespace PFA\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('code')
            ->add('name',null, array(
                "label" => "Titre du Project"
            ))
            ->add('description', TextareaType::class, array(
                "label" => "Desctiption Du project",
                "attr" => array(
                    "class" => "materialize-textarea"
                )
            ))
            //->add('status')
            //->add('ressources')
            //->add('forum')
            //->add('chatRoom')
            //->add('calender')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\CoreBundle\Entity\Project'
        ));
    }
}
