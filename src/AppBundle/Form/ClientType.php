<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\Client;
use AppBundle\Form\AddressType;
use AppBundle\Form\EmailType;
use AppBundle\Form\NameType;
use AppBundle\Form\PhoneNumberType;
use AppBundle\Form\PasswordType;

class ClientType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('username', TextType::class, ['required' => true])
      ->add('address', AddressType::class)
      ->add('email', EmailType::class)
      ->add('name', NameType::class)
      ->add('phone', PhoneNumberType::class)
      ->add('password', $options['password_class']);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Client::class,
      'password_class' => PasswordType::class,
      'locale' => 'fr_CA'
    ]);
  }
}
