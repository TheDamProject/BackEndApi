<?php


namespace App\Serializer;


use App\Entity\Shop;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShopListNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;


    public function __construct( ObjectNormalizer $normalizer){

        $this->normalizer = $normalizer;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {

        return $data instanceof Shop;
    }

    public function normalize($shop, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($shop,$format,$context);

        return $data;
    }
}