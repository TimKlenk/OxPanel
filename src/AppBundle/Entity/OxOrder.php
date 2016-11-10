<?php

namespace AppBundle\Entity;


class OxOrder
{

    private $orderId;
    private $date;
    private $customerId;
    private $customer;
    private $billingEmail;

    private $article=array();

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return OxCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param OxCustomer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingEmail()
    {
        return $this->billingEmail;
    }

    /**
     * @param mixed $billingEmail
     */
    public function setBillingEmail($billingEmail)
    {
        $this->billingEmail = $billingEmail;
        return $this;
    }

    /**
     * @return OxArticle
     */
    public function getArticle()
    {
        return $this->article;
    }


    /**
     * @param $article
     * @return $this
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

}
