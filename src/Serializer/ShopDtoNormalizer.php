<?php
namespace App\Serializer;


use App\Form\Model\ShopDto;
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

        return $data instanceof ShopDto;
    }

    public function normalize($shopDto, string $format = null, array $context = [])
    {


        $data = $this->normalizer->normalize($shopDto,$format,$context);
        $data['type'] = 'SHOP';
        $data['uid'] = $shopDto->getUid();
        $data['name'] = $shopDto->getName();
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
                    'UIDshop' => $shopDto->getUid(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent(),
                    'type' => $post->getType()->getType(),
                    'image' => $post->getImage()
                    ]) ;
            }
        $data["posts"] = $postList;




        return $data;
    }

}