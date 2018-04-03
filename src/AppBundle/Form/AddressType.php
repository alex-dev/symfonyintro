<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client\Address;

class AddressType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('civic', TextType::class, ['required' => true])
      ->add('city', TextType::class, ['required' => true])
      ->add('province', ChoiceType::class, [
        'choices' => array_flip(Address::getAllProvinces($options['locale'])),
        'required' => true])
      ->add('postalcode', TextType::class, ['required' => true]);      
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Address::class,
      'locale' => 'fr_CA'
    ]);
  }
}
