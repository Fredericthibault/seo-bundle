<?php
/**
 * Created by PhpStorm.
 * User: pmdc
 * Date: 19/01/17
 * Time: 1:54 PM
 */

namespace Viweb\SeoBundle\Form\DataTransformer;


use Burgov\Bundle\KeyValueFormBundle\KeyValueContainer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Viweb\SeoBundle\Model\SeoTrait;

class SeoMetaTransformer implements DataTransformerInterface
{
    /**
     * @var  SeoTrait $data
     */
    private $data;

    private $passthrough = false;

    public function __construct($data)
    {
        if($data === null) {
            $this->passthrough = true;
        }
        elseif(!in_array("Viweb\\SeoBundle\\Model\\SeoTrait", class_uses($data))){
            throw new TransformationFailedException('The data must use "Viweb\SeoBundle\Model\SeoTrait" to work whit this transformer');
        }
        $this->data = $data;
    }


    public function transform($value)
    {
        if($this->passthrough){
            return new KeyValueContainer();
        }
        $collection = new KeyValueContainer();
        /*
         * <meta name="description" content="description de la page" />
         * name="description" content="description de la page"
         */
        if(strlen($this->data->getSeoData())){
         $buffer = explode('/>', $this->data->getSeoData());
         foreach ($buffer as $b) {
             if(strlen($b) > 10){
                 $g = explode("=",
                     str_replace('"', '',
                         trim(
                             substr($b, 5)
                         )
                     )
                 );
                 $k = str_replace(' content', '', $g[1]);
                 $v = $g[2];
                 $collection->offsetSet($k, $v);
             }
         }
        }

        return $collection;
    }

    /**
     * @param SeoTrait $data
     */
    public function reverseTransform($value)
    {

        if($this->passthrough){
            return '';
        }

        $out = '';
        foreach ($this->data->getSeoCollection() as $k => $v){
            $out .= "<meta name=\"{$k}\" content=\"{$v}\" />";
        }
        return $out;
    }
}