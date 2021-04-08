<?php
namespace App\Serializer;


use App\Form\Model\ShopDto;
use App\Repository\ShopRepository;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShopDtoNormalizer implements ContextAwareNormalizerInterface
{

    private $normalizer;


    public function __construct( ObjectNormalizer $normalizer){

        $this->normalizer = $normalizer;

    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        // TODO: Implement supportsNormalization() method.
        return $data instanceof ShopDto;
    }

    public function normalize($shopDto, string $format = null, array $context = [])
    {
        // TODO: Implement normalize() method.


        $data = $this->normalizer->normalize($shopDto,$format,$context);
        $data['shopCategory'] = $shopDto->getCategory();
        $data['location'] =
            [
            'address' => $shopDto->getAddress(),
            'latitude' => $shopDto->getLatitude(),
            'longitude' => $shopDto->getLongitude()
            ];
        $data['shopData'] =
            [
               'description' => $shopDto->getDescription(),
                'phone' => $shopDto->getPhone(),
                'isWhatsapp' => $shopDto->getIsWhatsapp(),
                'logo' => $shopDto->getLogo()
            ];
         $postList = [];
            foreach ( $shopDto->getPosts() as $post){
                array_push($postList , [
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent(),
                    'type' => $post->getType()->getType(),
                    'image' => $post->getImage()
                    ]) ;
            }
        $data["posts"] = $postList;

;

        return $data;
    }

}