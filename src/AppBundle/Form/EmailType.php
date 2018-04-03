<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType as EmailType_;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\Email;

class EmailType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('value', EmailType_::class, ['required' => true]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Email::class,
      'locale' => 'fr_CA'
    ]);
  }
}
