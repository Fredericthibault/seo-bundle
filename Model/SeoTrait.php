<?php
namespace Viweb\SeoBundle\Model;

use Burgov\Bundle\KeyValueFormBundle\KeyValueContainer;

trait SeoTrait
{
    protected $seoData;

    protected $seoCollection;

    /**
     * SeoTrait constructor.
     */
    public function __construct()
    {

        $this->seoCollection = [];
    }

    /**
     * Gets the default Keys to seed the empty form
     * @return array
     */
    public abstract function getDefaultKeys() : array;

    /**
     * @return array
     */
    public function getSeoCollection()
    {
        if(!count($this->seoCollection)) {
            $this->seoCollection = [];
            foreach ($this->getDefaultKeys() as $k) {
                $this->addSeoItem($k, '');
            }
        }
        return $this->seoCollection;
    }

    /**
     * @param KeyValueContainer $seoCollection
     * @return SeoTrait
     */
    public function setSeoCollection($seoCollection)
    {
        $this->seoCollection = $seoCollection instanceof KeyValueContainer ? $seoCollection->toArray() : $seoCollection;
        return $this;
    }

    public function addSeoItem($key, $value)
    {
        $this->seoCollection[$key] = $value;
        return $this;
    }

    public function getSeoItem($key)
    {
        return $this->seoCollection[$key];
    }

}