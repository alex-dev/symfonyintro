<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\PhoneNumber;

class PhoneNumberType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('value', TelType::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => PhoneNumber::class,
      'locale' => 'fr_CA'
    ]);
  }
}
