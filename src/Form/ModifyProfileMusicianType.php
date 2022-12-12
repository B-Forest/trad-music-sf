<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Musician;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ModifyProfileMusicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('instruments', EntityType::class, [
                'class' => Instrument::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            //->add('imageFile', FileType::class, [
            //    'attr' => ['accept' => 'image/*'],
            //    'mapped' => false,
            //    'required' => false,
            //    'constraints' => [
            //        new File(['maxSize' => '1058k',])
            //    ]
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Musician::class,
        ]);
    }
}
