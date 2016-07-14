<?php

namespace AppBundle\Services\Space\Mgmt\CreationStep\Steps;

use AppBundle\Form\SpaceType;
use AppBundle\Services\Space\Mgmt\CreationStep\Step;
use Application\Sonata\MediaBundle\Entity\Media;

class Step1 extends Step
{

    public function process()
    {
        $form = $this->createForm(SpaceType::class,$this->space,['step'=>1]);
        $form->handleRequest($this->getRequest());
        if($form->isSubmitted() && $form->isValid()){
            //Get the base-64 string from data
            $filteredData=substr($form->get('spaceImageTmp')->getData(), strpos($form->get('spaceImageTmp')->getData(), ",")+1);
            //Decode the string
            $unencodedData=base64_decode($filteredData);
            file_put_contents('img.png', $unencodedData);
            $mediaManager = $this->get('sonata.media.manager.media');
            $media = new Media;
            $media->setBinaryContent('img.png');
            $media->setContext('default'); // video related to the user
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media);


            $entityManager = $this->getDoctrine()->getManager();
            $this->space->setUser($this->getUser());
            $this->space->setSpaceImage($media);
            $entityManager->persist($this->space);
            $entityManager->flush();
            return $this->redirectToRoute('app_space_create',['space' => $this->space->getId(),'step' => 2]);
        }
        return $this->render('AppBundle:Space/Steps:step1.html.twig', array(
            'space'=>$this->space,
             'form' => $form->createView(),
        ));
    }

}
