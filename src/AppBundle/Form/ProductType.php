<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Manufacturer;
use AppBundle\Entity\Product\Product;
use AppBundle\Form\ImageType_ as ImageType;
use AppBundle\Form\ProductTranslationType;

class ProductType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('translations', CollectionType::class, [
        'entry_type' => ProductTranslationType::class,
        'label' => 'product.translations',
        'translation_domain' => 'userforms',
        'allow_add' => true,
        'by_reference' => false])
      ->add('code', TextType::class, [
        'label' => 'product.code',
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('manufacturer', EntityType::class, [
        'label' => 'manufacturer',
        'translation_domain' => 'userforms',
        'class' => Manufacturer::class,
        'choice_label' => 'name',
        'required' => true])
      ->add('images', CollectionType::class, [
        'entry_type' => ImageType::class,
        'label' => 'product.images',
        'translation_domain' => 'userforms',
        'allow_add' => true,
        'by_reference' => false]);
  }

  public function getBlockPrefix()
  {
    return 'product';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Product::class,
      'validation_groups' => ['App']
    ]);
  }
}
