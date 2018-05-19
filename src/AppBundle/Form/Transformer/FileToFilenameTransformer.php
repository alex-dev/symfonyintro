<?php
namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Image;

class FileToFilenameTransformer implements DataTransformerInterface {
  private $databasemediapath;

  public function __construct($databasemediapath) {
    $this->databasemediapath = $databasemediapath;
  }

  public function transform($filename)
  {
    return $filename
      ? new File($this->databasemediapath.'/'.$filename.'.png')
      : null;
  }

  public function reverseTransform($file)
  {
    if ($file == null) {
      return null;
    } else if ($file->getMimeType() != 'image/png') {
      throw new TransformationFailedException('Invalid mime type.');
    } else {
      $name = md5(uniqid());
      $file->move($this->databasemediapath, $name.'.png');
      return $name;
    }
  }
}