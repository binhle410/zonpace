<?php

namespace AppBundle\Controller\Space\Api;

use AppBundle\Entity\Space\Space;
use AppBundle\Form\UploadType;
use Application\Sonata\MediaBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Core\ControllerService;
use Symfony\Component\HttpFoundation\JsonResponse;

class SpaceApiController extends ControllerService
{

    public function spaceImageAction(Request $request,Space $space)
    {
        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(UploadType::class);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $media = $form->get('image')->getData();
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($media);
                $em->flush();
            }
            return new JsonResponse(array(
//                'name' => $media->getName(),
            ));
        }
    }

}
