<?php
namespace Pico\NewsBundle\Controller;

use Pico\NewsBundle\Entity\NewsImages;
use Pico\NewsBundle\Form\NewsImagesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Pico\NewsBundle\Entity\Article;
use Pico\NewsBundle\Form\Type\ArticleFormType;

class NewsImagesController extends Controller {


    public function __init()
    {
        # Entity Manager
        $this->em = $this->getDoctrine()->getManager();

    }

    public function showImageAction($ArticleId){
    //    $this->__init();
        $article = $this->getDoctrine()->getManager()->getRepository('PicoNewsBundle:Article')->findOneById($ArticleId);
        $imageId = $article->getImageId();

        $image = $this->getDoctrine()->getManager()->getRepository('PicoNewsBundle:NewsImages')->findOneById($imageId);

        $images[] = $image;
        return $this->render("PicoNewsBundle:NewsImage:showImage.html.twig", $images);
    }

    public function updateAction(Request $request){
        # Instanciation of the NewsImages
        $this->__init();

        $image = new NewsImages();

        $form = $this->createForm(new NewsImagesType(), $image);
        $form->handleRequest($request);
        $response["form"] = $form->createView();

        if($form->isValid()){
            # Get the extension of the file if exists
            if($form["picture"]->getData() != null){
                $extension = $form["picture"]->getData()->guessExtension();
                if(!$extension){
                    $extension = "bin";
                }
                # Randomly name the file to prevent injection
                $fileName = $this->user->getId()."_".rand(1, 99999).".".$extension;
                $picture->upload($fileName);
                $picture->setUser($this->user);
                $this->em->persist($picture);
                $this->em->flush();
                $response["alert_info"] = "Votre image a été uploadée.";
                $response["alert_class"] = "success";
            }
        }

        return $this->render("PicoUserBundle:NewsImage:createImage.html.twig", $response);
    }
}
