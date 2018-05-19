<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\QuantityPattern\Unit\Unit;
use AppBundle\Entity\QuantityPattern\Value\Scalar;
use AppBundle\Repository\QuantityPattern\UnitRepository;

class ScalarType extends AbstractType
{
  private $locale;
  private $units;

  public function __construct(RequestStack $request, UnitRepository $repo) {
    $this->locale = $request->getCurrentRequest()->getLocale();
    $this->units = $repo;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('value', NumberType::class, [
        'label' => 'value',
        'translation_domain' => 'userforms',
        'constraints' => $options['constraints'],
        'required' => true])
      ->add('unit', ChoiceType::class, [
        'label' => 'unit',
        'translation_domain' => 'userforms',
        'choices' => $this->units->findSimilar($options['dimensions']),
        'choice_label' => function ($value, $key, $index) { return $value->getSymbol($this->locale); },
        'required' => true]);
    }

  public function getBlockPrefix()
  {
    return 'scalar';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setRequired('constraints');
    $resolver->setAllowedTypes('constraints', 'array');
    $resolver->setRequired('dimensions');
    $resolver->setAllowedTypes('dimensions', 'array');
    $resolver->setDefaults([
      'data_class' => Scalar::class,
      'validation_groups' => ['App']
    ]);
  }
}
