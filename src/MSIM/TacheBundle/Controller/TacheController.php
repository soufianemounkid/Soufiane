<?php

namespace MSIM\TacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MSIM\TacheBundle\Entity\Tache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TacheController extends Controller
{
    public function listAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
		    'SELECT t
		    FROM MSIMTacheBundle:Tache t
		    WHERE t.dateTache <= CURRENT_TIMESTAMP()');

		$taches = $query->getResult();
		foreach ($taches as $key => $value) {
			$em->remove($value);
			$em->flush();
		}
    	$taches=$em->getRepository('MSIMTacheBundle:Tache')->findall();
        return $this->render('MSIMTacheBundle:Tache:list.html.twig', array('taches' => $taches));
    }

    public function ajouterAction(){

    	$request = $this->getRequest();
        

      	if($request->isMethod('POST')){
            $name = $request->request->get('name');
            $dateT = $request->request->get('dateTache');
            $timeT = $request->request->get('timeTache');
            $desc = $request->request->get('description');

            $tache=new Tache;

            $tache->setName($name);
            $date =new \DateTime($dateT.' '.$timeT);
            $tache->setDateTache($date);
            $tache->setDescription($desc);
            $em = $this->getDoctrine()->getManager();
           	$em->persist($tache);
        	$em->flush();
        	return $this->render("MSIMTacheBundle:Tache:afficher.html.twig",array("tache"=>$tache));

         }
        $date=new \DateTime();
    	return $this->render('MSIMTacheBundle:Tache:ajouter.html.twig',array("date"=>$date->format('Y-m-d')));
    }

    public function afficherAction($id){
    	$em = $this->getDoctrine()->getManager();
    	$tache=$em->getRepository('MSIMTacheBundle:Tache')->find($id);
        return $this->render('MSIMTacheBundle:Tache:afficher.html.twig', array('tache' => $tache));
    }

    
}
