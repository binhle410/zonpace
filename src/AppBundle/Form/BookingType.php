<?php
namespace AppBundle\Form;

use AppBundle\Entity\Booking\Booking;
use AppBundle\Entity\Space\Location;
use AppBundle\Entity\Space\State;
use AppBundle\Form\Transformer\DateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\DependencyInjection\Container;

class BookingType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $period['Select Period'] = '';
        for ($i=1;$i<=30;$i++){
            $period[$i]=$i;
        }
        $space = $options['space'];
        $choices['Daily']= Booking::BOOKING_TYPE_DAILY;
        if($space->getPrice()->getWeeklyDiscount() != null) {
            $choices['Weekly'] = Booking::BOOKING_TYPE_WEEKLY;
        }
        if($space->getPrice()->getMonthlyDiscount() != null) {
            $choices['Monthly'] = Booking::BOOKING_TYPE_MONTHLY;
        }
        $builder
            ->add('dateFrom', DateType::class, ['format' => 'MM/dd/yyyy', 'widget' => 'single_text'])
            ->add('dateTo', DateType::class, ['format' => 'MM/dd/yyyy', 'widget' => 'single_text'])
            ->add('bookingType', ChoiceType::class,[
                'choices'=>$choices,
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('bookingPeriod', ChoiceType::class,[
                'choices'=>$period,
                'required'=>true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Booking\Booking',
            'space'=>null
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_booking';
    }
}
