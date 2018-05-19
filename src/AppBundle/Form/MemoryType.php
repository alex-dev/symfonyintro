<?php
namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Architecture\MemoryArchitecture;
use AppBundle\Entity\Product\Memory;
use AppBundle\Form\ScalarType;
use AppBundle\Form\ProductType;
use AppBundle\Service\Factory\DimensionsFactory;

class MemoryType extends AbstractType
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
    $builder->add('architecture', EntityType::class, [
        'label' => 'architecture',
        'translation_domain' => 'userforms',
        'class' => MemoryArchitecture::class,
        'choice_label' => function ($value, $key, $index) { return $value->getName($this->locale); },
        'required' => true])
      ->add('size', ScalarType::class, [
        'label' => 'product.size',
        'translation_domain' => 'userforms',
        'dimensions' => $temp(Memory::sizeUnit),
        'constraints' => [
          new Assert\GreaterThanOrEqual(['value' => 0, 'message' => 'product.size.toosmall'])
        ],
        'required' => true])  
      ->add('frequency', ScalarType::class, [
        'label' => 'product.frequency',
        'translation_domain' => 'userforms',
        'dimensions' => $temp(Memory::frequencyUnit),
        'constraints' => [
          new Assert\GreaterThanOrEqual(['value' => 0, 'message' => 'product.frequency.toosmall'])
        ],
        'required' => true]);
  }

  public function getParent()
  {
    return ProductType::class;
  }

  public function getBlockPrefix()
  {
    return 'memory';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Memory::class,
      'validation_groups' => ['App']
    ]);
  }
}
