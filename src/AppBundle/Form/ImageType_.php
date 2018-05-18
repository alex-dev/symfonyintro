<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ImageType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Image;

class ImageType_ extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('image', ImageType::class, [
        'label' => 'image',
        'translation_domain' => 'userforms',
        'required' => true,
        'constraints' => [
          new Assert\File(['mimeTypes' => 'image/png', 'maxSize' => '75k', 'groups' => ['App']])
        ]])
      ->add('isMain', ChoiceType::class, [
        'label' => 'image.isMain',
        'translation_domain' => 'userforms',
        'choice_translation_domain' => true,
        'choice' => ['yes' => true, 'no' => false],
        'expanded' => true,
        'required' => true]);
  }

  public function getBlockPrefix()
  {
    return 'image';
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Image::class,
      'validation_groups' => ['App']
    ]);
  }
}
