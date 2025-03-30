<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Terrain;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder



            ->add('dateCreation', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de reservation',
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual ([
                        'value' => new \DateTime('today'),
                        'message' => 'La date de création ne peut pas être antérieure à aujourd\'hui.',
                    ] ),

                ],
            ])
            ->add('datefin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateDates']),
                ],
            ])
            ->add('Terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'NomTerrain',

            ])



            ->add('Capacite', IntegerType::class, [
                'label' => 'Nombre de Participant',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'min' => 1, // Minimum participants
                    'max' => 60, // Maximum participants
                ],
            ])
            ->add('reserver', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'is_user_connected' => false,
        ]);
        $resolver->setRequired('is_user_connected');
    }
    public function validateDates($value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();
        $dateCreation = $form->get('dateCreation')->getData();

        if ($dateCreation && $value && $value < $dateCreation) {
            $context->buildViolation('La date de fin doit être postérieure à la date de réservation.')
                ->addViolation();
        }
    }
}
