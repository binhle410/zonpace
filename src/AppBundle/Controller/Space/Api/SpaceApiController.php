<?php

namespace AppBundle\Controller\Space\Api;

use AppBundle\Entity\Space\Space;
use AppBundle\Form\UploadType;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\MediaBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use Symfony\Component\HttpFoundation\JsonResponse;

class SpaceApiController extends ControllerService
{

    public function spaceImageAction(Request $request,Space $space)
    {
        if ($request->isXmlHttpRequest()) {
            $file = $request->files->get('app_space_upload')['image']['binaryContent'];
            $mediaManager = $this->get('sonata.media.manager.media');
            $media = new Media;
            $media->setBinaryContent($file);
            $media->setContext('default'); // video related to the user
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media);

            $gallery = $space->getPhoto();
            $galleryMedia = new GalleryHasMedia();
            $galleryMedia->setEnabled(1);
            $galleryMedia->setGallery($gallery);
            $galleryMedia->setMedia($media);
            $em = $this->getDoctrine()->getManager();
            $em->persist($galleryMedia);
            $em->flush();

            $url = $this->get('app.media.retriever')->getPublicURL($media);

//            $form = $this->createForm(UploadType::class);
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//                $media = $form->get('image')->getData();
//                $em = $this->getDoctrine()->getEntityManager();
//                $em->persist($media);
//                $em->flush();
//            }
            return new JsonResponse(['status'=>true,'url'=>$url]);
        }
    }

}
