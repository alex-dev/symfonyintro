<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as PasswordType_;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DataObject\NewPassword;
use AppBundle\Form\PasswordType;

class NewPasswordType extends PasswordType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('confirm', PasswordType_::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => NewPassword::class,
      'locale' => 'fr_CA'
    ]);
  }
}
