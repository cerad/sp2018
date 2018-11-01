<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionDeleteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    // Don't really need this but keep for now
    // POST /region/delete/id
    $builder
      ->add('id', HiddenType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'App\Entity\Region'
    ));
  }
}
