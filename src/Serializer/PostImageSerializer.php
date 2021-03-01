<?php


namespace App\Serializer;


use App\Entity\Post;
use App\Form\Type\Model\PostDto;
use App\Utils\Constants;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PostImageSerializer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private UrlHelper $helper;

    /**
     * PostImageSerializer constructor.
     * @param ObjectNormalizer $normalizer
     * @param UrlHelper $helper
     */
    public function __construct(ObjectNormalizer $normalizer, UrlHelper $helper)
    {
        $this->normalizer = $normalizer;
        $this->helper = $helper;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object,$format,$context);
        $data['image'] = $this->helper->getAbsoluteUrl(constants::pathOfImagesByDefault . $object->getImage());
        $data['type'] = $object->getType()->getId();
        $data['shopRelated'] = $object->getShopRelated()->getId();
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
       return $data instanceof Post;
    }

}