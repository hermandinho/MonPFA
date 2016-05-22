<?php

namespace PFA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalenderEventsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                "attr" => [
                    "class" => "validate characterCounter",
                    "autocomplete" => "off",
                    "length" => 100
                ],
                "label" => "Titre de l'événement. "
            ))
            ->add('description', TextareaType::class, array(
                "attr" => [
                    "class" => "materialize-textarea characterCounter",
                    "length" => 255
                ],
                "label" => "Description de l'événement"
            ))
            ->add('start', "date", array(
                "attr" => [
                    "class" => "datepicker",
                    "required" => true
                ],
                "label" => "Date de début",
                "widget" => "single_text",
            ))
            ->add('end', "date", array(
                "attr" => [
                    "class" => "datepicker",
                    "required" => true
                ],
                "label" => "Date de Fin",
                "widget" => "single_text"
            ))
            ->add('place', null, array(
                "attr" => [],
                "label" => "Lieux",
                "required" => false
            ))
            ->add('priority', "choice", array(
                "attr" => [
                    "class" => "browser-default"
                ],
                "label" => "",
                "choices" => ["" => "Priorité","low" => "Basse","medium" => "Moyenne", "high" => "Haute"]
            ))
            ->add('allDay', CheckboxType::class, array(
                "attr" => [
                    "class" => "switch",
                    "required" => false
                ],
                "label" => "Journnée Entière ?",
                "required" => false
            ))
            ->add('url', UrlType::class, array(
                "attr" => [
                    "required" => false
                ],
                "label" => "URL.",
                "required" => false
            ))
            ->add('color', ChoiceType::class , array(
                "attr" => [
                    "class" => "browser-default"
                ],
                "label" => "",
                "choices" => ["" => "Couleur", "#69f0ae" => "Verte", "#2196f3" => "Blue", "#f44336" => "Rouge"]
            ))
            //->add('calender')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PFA\MainBundle\Entity\CalenderEvents'
        ));
    }
}
