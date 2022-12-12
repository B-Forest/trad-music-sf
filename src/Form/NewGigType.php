<?php

namespace App\Form;

use App\Entity\Gig;
use App\Entity\Pub;
use App\Repository\PubRepository;
use PhpParser\Node\Name;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewGigType extends AbstractType
{

    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->token->getToken()?->getUser();
        $builder
            ->add('dateStart', DateTimeType::class,  [
                'date_widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ],
            ])
            ->add('dateEnd', DateTimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ],
            ])
            ->add('pub', EntityType::class, [
                'class' => Pub::class,
                'query_builder' => function (PubRepository $pubRepository) use($user) {
                    return $pubRepository->createQueryBuilder('pub')
                        ->where('pub.manager = :id')
                            ->setParameter(':id', $user->getId());
                },
                'choice_label' => 'name',
            ] )

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gig::class,
        ]);
    }
}
