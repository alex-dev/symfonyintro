<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Product\ProductTranslation;

class ProductTranslationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('locale', LocaleType::class, [
        'label' => 'locale',
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('name', TextType::class, [
        'label' => 'product.name',
        'translation_domain' => 'userforms',
        'required' => true]);
  }

  public function getBlockPrefix()
  {
    return 'producttranslation';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => ProductTranslation::class,
      'validation_groups' => ['App']
    ]);
  }
}
