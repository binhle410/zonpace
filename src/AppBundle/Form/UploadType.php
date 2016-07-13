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
use Application\Sonata\MediaBundle\Entity\Media;

class UploadType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('image', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.file',
                'context'  => 'default',
                'label' => false,
                'required'=> true
            ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_space_upload';
    }
}
