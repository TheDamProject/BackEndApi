<?php


namespace App\Serializer;


use App\Entity\Post;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PostNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;


    public function __construct( ObjectNormalizer $normalizer){

        $this->normalizer = $normalizer;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {

        return $data instanceof Post;
    }

    public function normalize($post, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($post,$format,$context);
        $data['UIDshop'] =  $post->getshopId()->getUid();
        return $data;
    }
}