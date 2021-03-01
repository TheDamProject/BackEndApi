<?php

namespace App\Serializer;

use App\Form\Type\Model\CompleteShopDataDto;
use App\Utils\Constants;
use ArrayObject;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class ShopLogoNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private UrlHelper $helper;

    /**
     * ShopLogoNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param UrlHelper $helper
     */
    public function __construct(ObjectNormalizer $normalizer , UrlHelper $helper)
    {
        $this->normalizer = $normalizer;
        $this->helper = $helper;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object,$format,$context);

        $data['logo'] =$this->helper->getAbsoluteUrl( constants::pathOfImagesByDefault. $object->getLogo());
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof CompleteShopDataDto;
    }

}