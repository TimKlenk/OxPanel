<?php

namespace AppBundle\Controller;


use AppBundle\Entity\OxOrder;
use AppBundle\Repository\OxOrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class OrderController extends Controller
{
    /**
     * @Route("/order", name="order")
     */
    public function OrderAction()
    {
        $order=new OxOrderRepository($this->get('oxPdo'));
        $order=$order->getCustomerOrdersByCustomerId($this->get('session')->get('customerId'));
        return $this->render('panel/orderOverview.html.twig', array(
                'order'=>$order
             )
        );
    }
}
