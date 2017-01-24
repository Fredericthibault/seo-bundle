<?php
/**
 * Created by PhpStorm.
 * User: pmdc
 * Date: 19/01/17
 * Time: 3:49 PM
 */

namespace Viweb\SeoBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;


class SeoFieldSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();

        if (!in_array('Viweb\SeoBundle\Model\SeoTrait', class_uses($metadata->getName()))) {
            return;
        }

        $metadata->mapField([
           'fieldName' => 'seoCollection',
            'type' => 'array',
            'nullable' => 'true'
        ]);
    }

}