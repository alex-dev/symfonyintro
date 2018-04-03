<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\Name;

class NameType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('first', TextType::class, ['required' => true])
      ->add('last', TextType::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Name::class,
      'locale' => 'fr_CA'
    ]);
  }
}
