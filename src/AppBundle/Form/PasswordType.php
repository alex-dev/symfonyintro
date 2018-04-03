<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as PasswordType_;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\Password;

class PasswordType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('value', PasswordType_::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Password::class,
      'locale' => 'fr_CA'
    ]);
  }
}
