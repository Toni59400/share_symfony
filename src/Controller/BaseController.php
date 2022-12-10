<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Form\AvisType;
use App\Entity\Avis;

class BaseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $repoAvis = $this->getDoctrine()->getRepository(Avis::class);
        $avis = $repoAvis->findAll();
        return $this->render('base/index.html.twig', [
            'avis' => $avis
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $contact->setdate_envoi(new \Datetime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
            }
        }

        return $this->render('base/contact.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/donnez-mon-avis', name: 'donnez-mon-avis')]
    public function donnez_mon_avis(Request $request): Response{

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($avis);
                $em->flush();
                $this->addFlash('notice','Votre avis est pris en compte');
                return $this->redirectToRoute('donnez-mon-avis');
            }
        }

        return $this->render('base/donnez-mon-avis.html.twig', [
            'form_avis' => $form->createView()
        ]);
    }

    #[Route('/mentions-legales', name: 'mentions-legales')]
    public function mentions_legales(): Response
    {
        return $this->render('base/mentions-legales.html.twig', [
          
        ]);
    }

    #[Route('/a-propos', name: 'a-propos')]
    public function a_propos(): Response
    {
        return $this->render('base/a-propos.html.twig', [
          
        ]);
    }
}