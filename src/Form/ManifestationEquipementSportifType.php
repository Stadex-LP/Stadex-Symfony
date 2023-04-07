<?php

namespace App\Form;

use App\Entity\EquipementSportif;
use App\Entity\ManifestationEquipementSportif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManifestationEquipementSportifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipementSportif', EntityType::class, [
                'class' => EquipementSportif::class,
                'row_attr' => ['class' => 'mb-3 col'],
            ])
            ->add('heure', IntegerType::class, [
                'row_attr' => ['class' => 'mb-3 col-2'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManifestationEquipementSportif::class,
        ]);
    }
}
