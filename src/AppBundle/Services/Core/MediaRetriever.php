<?php
// src/Solutions/AppBundle/Services/Core/Media/MediaRetriever.php

namespace AppBundle\Services\Core;

use Sonata\MediaBundle\Model\Media;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class MediaRetriever extends ControllerService
{

    /**
     * @param int $id
     * @return Media
     */
    public function findOneById($id)
    {
        $mediaManager = $this->get('sonata.media.manager.media');
        return $mediaManager->findOneBy(array('id' => $id));
    }

    public function getPublicURL(Media $media)
    {
        $provider = $this->get('sonata.media.provider.file');
        $dir = $this->get('sonata.media.adapter.filesystem.s3')->getDirectory();
        $cdnPath = str_replace('http', 'https', $provider->getCdnPath($dir . '/' . $provider->generatePath($media), true));
        $fileName = $media->getProviderReference();
        return $cdnPath . '/' . $fileName;
    }


}