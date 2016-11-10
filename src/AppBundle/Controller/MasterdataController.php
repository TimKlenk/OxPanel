<?php


namespace AppBundle\Controller;

use AppBundle\Repository\OxCustomerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class MasterdataController extends Controller
{
    /**
     * @Route("/masterdata", name="masterdata")
     */

    public function MasterdataAction(Request $request)
    {
        $oxCustomerRepository = new OxCustomerRepository($this->get('oxPdo'));
        $oxCustomer = $oxCustomerRepository->getCustomerByCustomerId($this->get('session')->get('customerId'));
        $form = $this->createFormBuilder()
            ->add('Firstname', TextType::class, array(
                'data'=>$oxCustomer->getFirstname()
            ))
            ->add('Lastname', TextType::class, array(
                'data'=>$oxCustomer->getLastname()
            ))
            ->add('E-Mail', TextType::class, array(
                'data'=>$oxCustomer->getUsername()
            ))
            ->add('Company', TextType::class, array(
                'data'=>$oxCustomer->getCompany()
            ))
            ->add('Streetname', TextType::class, array(
                'data'=>$oxCustomer->getSteetname()
            ))
            ->add('Streetnumber', TextType::class, array(
                'data'=>$oxCustomer->getStreetnumber()
            ))
            ->add('City', TextType::class, array(
                'data'=>$oxCustomer->getCity()
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save changes',
                'attr' => array(
                    'class' => 'success button'
                )
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $oxCustomerRepository->save($task,$oxCustomer->getCustomerId());
            return $this->redirect($request->getUri());
        }

        return $this->render('panel/masterdata.html.twig', array(
            'masterdata'=>$oxCustomer,
            'form'=>$form->createView(),
        )
        );
    }

}
