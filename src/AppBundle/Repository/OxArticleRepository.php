<?php

/**
 * Created by PhpStorm.
 * User: Tim Klenk
 * Date: 18.10.2016
 * Time: 10:20
 */
namespace AppBundle\Repository;
use AppBundle\Entity\OxArticle;
use AppBundle\Database\OxPdo;

class OxArticleRepository
{

    private $databaseConnection;

    function __construct($database)
    {
        $this->connection=$database;
    }

    public function getAll()
    {
        $sql = "
            Select *
            From oxarticles
        ";
        $results = $this->databaseConnection->query($sql);
        $articleList=[];
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $oxArticle = new OxArticle();
            $oxArticle
                    ->setArticleID($row['OXID'])
                    ->setArtDesc($row['OXSHORTDESC'])
                    ->setArticleTitle($row['OXTITLE'])
                    ->setArtNumber($row['OXARTNUM'])
                    ->setPrice($row['OXPRICE']);
            array_push($articleList,$oxArticle);
        }
        $this->writeToCsvFile($articleList);
        return $articleList;
    }

    public function getArticlesByArtNumber($artNumber)
    {
        $sql = "
            Select *
            From oxarticles
            where OXARTNUM IN (:artNumber)
        ";

        $results = $this->databaseConnection->prepare($sql);
        $results->bindParam(':artNumber', $artNumber[1]);
        $results->execute();
        $articleList=[];
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $oxArticle = new OxArticle();
            $oxArticle
                ->setArticleID($row['OXID'])
                ->setArtDesc($row['OXSHORTDESC'])
                ->setArticleTitle($row['OXTITLE'])
                ->setArtNumber($row['OXARTNUM'])
                ->setPrice($row['OXPRICE']);
            array_push($articleList,$oxArticle);
        }
        $this->writeToCsvFile($articleList);
        return $articleList;
    }

    /**
     * @param array $articleList
     */
    private function writeToCsvFile(array $articleList)
    {
        $file = fopen('export/Article_'.date('Y-m-d_H-i-s').'.csv','w');
        foreach($articleList as $article)
        {
            fputcsv($file,(array)$article,';');
        }
    }
}