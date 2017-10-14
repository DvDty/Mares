<?php

namespace AppBundle\Service;

use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Kernel;

class UploadPicture
{
    protected $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function uploadPicture($object, string $path)
    {

        $time = new DateTime('now');

        /** @var UploadedFile $image */
        if ($image = $object->getImage()) {
            $imgPath = '/../public_html/' . $path;

            $filename = $time->format('d-m-Y-s') . md5($time->format('s')) . uniqid();

            $image->move($this->kernel->getRootDir() . $imgPath, $filename . '.png');

            $object->setImage($path . $filename . '.png');
        }
    }
}