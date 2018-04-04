<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Client\Address;

class AddressType extends AbstractType
{
  private $locale;

  public function __construct(RequestStack $request) {
    $locale = $request->getCurrentRequest()->getLocale();
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('civic', TextType::class, [
        'label' => 'address.civic',
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('city', TextType::class, [
        'label' => 'address.city',
        'translation_domain' => 'userforms',
        'required' => true])
      ->add('province', ChoiceType::class, [
        'label' => 'address.province',
        'translation_domain' => 'userforms',
        'choices' => array_flip(Address::getAllProvinces($this->locale)),
        'required' => true])
      ->add('postalCode', TextType::class, [
        'label' => 'address.postal',
        'translation_domain' => 'userforms',
        'required' => true]);
  }

  public function getBlockPrefix()
  {
    return 'name';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Address::class,
      'validation_groups' => ['App']
    ]);
  }
}
