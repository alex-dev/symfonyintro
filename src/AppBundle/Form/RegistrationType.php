<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use AppBundle\Entity\Client\Client;
use AppBundle\Form\AddressType;
use AppBundle\Form\NameType;

class RegistrationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('phone', TelType::class, ['label' => 'phone', 'translation_domain' => 'userforms'])
      ->add('address', AddressType::class, ['label' => 'address.name', 'translation_domain' => 'userforms'])
      ->add('name', NameType::class, ['label' => 'name.name', 'translation_domain' => 'userforms']);
  }

  public function getParent()
  {
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  public function getBlockPrefix()
  {
    return 'app_user_registration';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Client::class,
      'validation_groups' => ['App']
    ]);
  }
}
