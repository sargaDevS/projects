<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Studentdetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Form\FormValidationType;

class studentController extends Controller
{
    /**
      * @Route("/student/display" ,name = "app_student_display" )
      */
    public function displayAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Studentdetails')->createQueryBuilder('bp');
        if ($request->query->getAlnum('filter')) {
            $queryBuilder->where('bp.name LIKE :name')
            ->setParameter('name', '%' . $request->query->getAlnum('filter') . '%');
        }
        $query = $queryBuilder->getQuery();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        $request->query->getInt('limit', 5));
        return $this->render('datadisplay.html.twig', array('pagination' => $pagination));
    }

    /**
      * @Route("/student/insertpage", name="app_student_new")
      */
    public function newAction(Request $request) {
        $stud = new Studentdetails();
        $form = $this->createFormBuilder($stud)
        ->add('name', TextType::class)
        ->add('email', EmailType::class)
        ->add('phone', NumberType::class)
        ->add('age', IntegerType::class)
        ->add('save', SubmitType::class, array('label' => 'Submit'))
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $stud = $form->getData();
            $stud = $this->getDoctrine()
            ->getRepository('AppBundle:Studentdetails')
            -> newAction($stud);
             return $this->redirectToRoute('app_student_display');
             }
             else
             {
                return $this->render('datainsert.html.twig', array(
                'form' => $form->createView(),));
             }
    }

    /**
      * @Route("/student/delete/{id}", name="app_student_delete")
     */
    public function deleteAction($id) {
         $stud = $this->getDoctrine()
         ->getRepository('AppBundle:Studentdetails')
         ->find($id);
         $this->getDoctrine()
         ->getRepository('AppBundle:studentdetails')
         ->deleteAction($stud);
         return $this->redirectToRoute('app_student_display');
    }
    /**
      * @Route("/student/update/{id}", name = "app_student_update" )
     */
    public function updateAction($id, Request $request) {
         $stud = $this->getDoctrine()
         ->getRepository('AppBundle:Studentdetails')
         ->find($id);
         $form = $this->createFormBuilder($stud)
         ->add('name', TextType::class)
         ->add('email', EmailType::class)
         ->add('phone', NumberType::class)
         ->add('age', IntegerType::class)
         ->add('save', SubmitType::class, array('label' => 'Submit'))
         ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $stud = $form->getData();
             $stud = $this->getDoctrine()
             ->getRepository('AppBundle:Studentdetails')
             ->updateAction($stud);
             return $this->redirectToRoute('app_student_display');
        }
         else
        {
             return $this->render('dataupdate.html.twig', array(
                      'form' => $form->createView(),));
        }
    }
}
?>
