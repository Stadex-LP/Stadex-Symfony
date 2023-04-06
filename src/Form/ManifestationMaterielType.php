<?php

namespace App\Form;

use App\Entity\ManifestationMateriel;
use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManifestationMaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'row_attr' => ['class' => 'mb-3 col'],
            ])
            ->add('qte', IntegerType::class, [
                'row_attr' => ['class' => 'mb-3 col-2'],
            ])
            ->add('jour', IntegerType::class, [
                'row_attr' => ['class' => 'mb-3 col-2'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManifestationMateriel::class,
        ]);
    }
}
