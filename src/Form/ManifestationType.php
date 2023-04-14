<?php

namespace App\Form;

use App\Entity\Manifestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination')
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('lieu')
            ->add('organisateur')
            ->add('manifestationMateriels', CollectionType::class, [
                'entry_type' => ManifestationMaterielType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('manifestationEquipementSportifs', CollectionType::class, [
                'entry_type' => ManifestationEquipementSportifType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('manifestationTransports', CollectionType::class, [
                'entry_type' => ManifestationTransportType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('manifestationMainOeuvres', CollectionType::class, [
                'entry_type' => ManifestationMainOeuvreType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }
}
