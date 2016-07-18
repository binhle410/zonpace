<?php
namespace AppBundle\Form;

use AppBundle\Entity\Space\Location;
use AppBundle\Entity\Space\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LocationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetAddress', TextType::class)
            ->add('typeSpaceOptional', TextType::class)
            ->add('typeSpace', ChoiceType::class,[
                'choices'=>[
                   'Vacant Land' =>Location::TYPE_SPACE_EVENT_SPACE,
                    'Space attached to property' =>Location::TYPE_SPACE_SPACE_ATTACHED_TO_PROPERTY,
                    'Event place' =>Location::TYPE_SPACE_VACANT_LAND,
                ],
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('zipCode', NumberType::class)
            ->add('squareFeet', NumberType::class)
            ->add('state', EntityType::class,[
                'class' => 'AppBundle:Core\State',
                'choice_label' => 'name',
            ])
            ->add('city', EntityType::class,[
                'class' => 'AppBundle:Core\City',
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Space\Location'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_space_location';
    }
}
