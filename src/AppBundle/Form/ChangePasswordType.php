<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DataObject\ChangePassword;
use AppBundle\Form\NewPasswordType;

class ChangePasswordType extends NewPasswordType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('confirm', PasswordType::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => ChangePassword::class,
      'locale' => 'fr_CA'
    ]);
  }
}
