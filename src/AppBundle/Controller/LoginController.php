<?php

namespace AppBundle\Controller;

use AppBundle\Repository\OxCustomerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\Session;
class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if($this->get('session')->has('customerId'))
        {
            return $this->redirectToRoute('front_page');
        }

        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, array('label' => 'Login','attr' => array('class' => 'button')))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $user = new OxCustomerRepository($this->get('oxPdo'));
            $login = $user->loginCustomer($task['username'],$task['password']);
            if($login)
            {
                $session = $this->get('session');
                $session->set('customerId',$login);
                return $this->redirectToRoute('front_page');
            }else {
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('login/login.html.twig', array(
                'form'=>$form->createView(),
            )

        );
    }

}
