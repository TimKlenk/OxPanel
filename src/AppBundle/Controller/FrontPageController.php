<?php

namespace AppBundle\Controller;

use AppBundle\Repository\OxCustomerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\OxCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FrontPageController extends Controller
{
    /**
     * @Route("/frontpage", name="front_page")
     */
    public function frontPageAction(Request $request)
    {
        if(!$this->get('session')->has('customerId'))
        {
            return $this->redirectToRoute('login');
        }
        $form = $this->createFormBuilder()
            ->add('save', SubmitType::class, array('label' => 'Logout','attr' => array('class' => 'alert button')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->get('session')->remove('customerId');
            return $this->redirectToRoute('login');
        }

        $customer = new OxCustomerRepository($this->get('oxPdo'));
        $customer = $customer->getCustomerByCustomerId($this->get('session')->get('customerId'));

        return $this->render('panel/frontpage.html.twig', array(
            'customer'=>$customer,
            'form'=>$form->createView(),
            )
        );
    }

}
