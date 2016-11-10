<?php

namespace AppBundle\Entity;
class OxArticle
{
    private $articleID;
    private $articleTitle;
    private $artDesc;
    private $price;
    private $artNumber;
    /**
     * @return mixed
     */
    public function getArticleID()
    {
        return $this->articleID;
    }

    /**
     * @param mixed $articleID
     */
    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticleTitle()
    {
        return $this->articleTitle;
    }

    /**
     * @param mixed $articleTitle
     */
    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArtDesc()
    {
        return $this->artDesc;
    }

    /**
     * @param mixed $artDesc
     */
    public function setArtDesc($artDesc)
    {
        $this->artDesc = $artDesc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArtNumber()
    {
        return $this->artNumber;
    }

    /**
     * @param mixed $artNumber
     */
    public function setArtNumber($artNumber)
    {
        $this->artNumber = $artNumber;
        return $this;
    }


}
