<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Architecture\MemoryArchitecture;
use AppBundle\Entity\Item;
use AppBundle\Form\MemoryType;
use AppBundle\Service\Factory\DimensionsFactory;

class ItemType extends AbstractType
{
  private $locale;
  private $dimensions;

  public function __construct(RequestStack $request, DimensionsFactory $factory) {
    $this->locale = $request->getCurrentRequest()->getLocale();
    $this->dimensions = $factory;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $temp = $this->dimensions;
    $builder->add('product', $options['product_class'], [
        'label' => false,
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('cost', ScalarType::class, [
        'label' => 'product.cost',
        'translation_domain' => 'userforms',
        'dimensions' => $temp(Item::currencyUnit),
        'constraints' => [
          new Assert\GreaterThanOrEqual(['value' => 0, 'message' => 'product.cost.toosmall'])
        ],
        'required' => true])  
      ->add('count', NumberType::class, [
        'label' => 'product.count',
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('minimalcount', NumberType::class, [
        'label' => 'product.count.minimal',
        'translation_domain' => 'userforms',
        'required' => true]);
  }

  public function getBlockPrefix()
  {
    return 'item';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setRequired('product_class');
    $resolver->setDefaults([
      'data_class' => Item::class,
      'validation_groups' => ['App']
    ]);
  }
}
