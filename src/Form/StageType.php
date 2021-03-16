<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Entreprise;
use App\Entity\Formation;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('description')
            ->add('competenceRequise')
            ->add('dateDebut')
            ->add('duree')
            ->add('emailEntreprise')
            ->add('entreprise', EntrepriseType::class)
            ->add('formations', EntityType::class, array(
                'class' => Formation::class,
                'choice_label' => function(Formation $formation)
                {return $formation->getVille().' - '.$formation->getIntitule();},
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
