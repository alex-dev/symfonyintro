<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Image;
use AppBundle\Form\Transformer\FileToFilenameTransformer;

class ImageType extends AbstractType
{
  private $transformer;

  public function __construct(FileToFilenameTransformer $transformer)
  {
      $this->transformer = $transformer;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('filename', FileType::class, [
        'label' => 'image',
        'translation_domain' => 'userforms',
        'invalid_message' => 'file.must.be.png',
        'required' => false])
      ->add('isMain', ChoiceType::class, [
        'label' => 'image.isMain',
        'translation_domain' => 'userforms',
        'choice_translation_domain' => true,
        'choices' => ['yes' => true, 'no' => false],
        'expanded' => true,
        'required' => true]);

    $builder->get('filename')->addModelTransformer($this->transformer);
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
