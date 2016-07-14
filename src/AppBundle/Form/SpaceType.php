<?php
namespace AppBundle\Form;

use AppBundle\Entity\Space\Location;
use AppBundle\Entity\Space\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\LocationType;
use AppBundle\Form\PriceType;
use AppBundle\Form\FeatureType;
use AppBundle\Form\DateBookingType;

class SpaceType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['step'] == 1) {
            $builder
                ->add('location', LocationType::class)
                ->add('shape', HiddenType::class);
        } else {
            $builder
                ->add('name', TextType::class)
                ->add('description', TextareaType::class)
                ->add('price', PriceType::class)
                ->add('shape', HiddenType::class)
                ->add('dateBooking', DateBookingType::class, ['dateBooking' => $options['dateBooking']])
                ->add('features', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Space\Feature',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'group_by' => function ($val, $key, $index) {
                        return $val->getCategory()->getName();
                    },
                ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Space\Space',
            'dateBooking' => null,
            'step'=>null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_space_space';
    }
}
