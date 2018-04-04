<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Client\Name;

class NameType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('firstName', TextType::class, ['label' => 'name.first', 'translation_domain' => 'userforms'])
      ->add('lastName', TextType::class, ['label' => 'name.last', 'translation_domain' => 'userforms']);
  }

  public function getBlockPrefix()
  {
    return 'name';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Name::class,
      'validation_groups' => ['App']
    ]);
  }
}
