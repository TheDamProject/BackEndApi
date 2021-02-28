<?php


namespace App\Service;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

class ImageHandlerService
{
    private FilesystemOperator $defaultStorage;

    /**
     * ImageHandlerService constructor.
     * @param FilesystemOperator $defaultStorage
     */
    public function __construct(FilesystemOperator $defaultStorage)
    {
        $this->defaultStorage = $defaultStorage;
    }


    public function saveImage(String $imageBase64, String $classPath): string

    {

        $extension = explode('/', mime_content_type($imageBase64))[1];


        $data = explode(',' , $imageBase64);
        $fileName = sprintf('/'.$classPath.'/'.'%s.%s', uniqid($classPath.'_', true),$extension);
        try {
            $this->defaultStorage->write($fileName, base64_decode($data[1]));
        } catch (FilesystemException $e) {
        }
        return $fileName;
    }

    public function deleteImage(String $fileName): bool
    {
        try {
            $this->defaultStorage->delete($fileName);
        } catch (FilesystemException $e) {
            return false;
        }
        return true;
    }

}