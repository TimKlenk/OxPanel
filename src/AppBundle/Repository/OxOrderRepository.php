
namespace AppBundle\Repository;


use AppBundle\Database\OxPdo;
use AppBundle\Entity\OxArticle;
use AppBundle\Entity\OxOrder;

class OxOrderRepository
{
    private $connection;

    /**
     * OxOrderRepository constructor.
     * @param OxPdo $database
     */
    function __construct($database)
    {
        $this->connection=$database;
    }


    public function getAll()
    {
        $sql="
            Select *
            From oxorder
        ";
        $results = $this->connection->query($sql);
        $orderList=[];
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $user = new OxCustomerRepository();
            $order = new OxOrder();
            $order
                ->setCustomerId($row['OXUSERID'])
                ->setCustomer($user->getCustomerByCustomerId($row['OXUSERID']))
                ->setArticle($this->getArticlesIDsByOrderId($row['OXID']))
                ->setBillingEmail($row['OXBILLEMAIL'])
                ->setDate($row['OXORDERDATE'])
                ->setOrderId($row['OXORDERNR']);
            array_push($orderList,$order);
        }
        var_dump($orderList);
        return $orderList;
    }

    public function getCustomerOrdersByCustomerId($customerId)
    {
        $sql="
            Select *,oo.oxid as `orderid`, oa.oxid as `oaid`
            From oxorder oo
            inner join oxorderarticles oa
            on oo.oxid=oa.oxorderid
            where oo.oxuserid=:customerId;
        ";
        $results = $this->connection->prepare($sql);
        $results->bindParam(':customerId', $customerId);
        $results->execute();
        $orderList=[];
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $user = new OxCustomerRepository(new OxPdo());
            $order = new OxOrder();
            $order
                ->setCustomerId($customerId)
                ->setCustomer($user->getCustomerByCustomerId($customerId))
                ->setArticle($this->getArticlesIDsByOrderId($row['oaid']))
                ->setBillingEmail($row['OXBILLEMAIL'])
                ->setDate($row['OXORDERDATE'])
                ->setOrderId($row['OXORDERNR']);
            array_push($orderList,$order);
        }
        return $orderList;
    }

    public function getArticlesIDsByOrderId($orderID)
    {
        $sql="
            SELECT *
            FROM oxorderarticles
            WHERE oxid like :orderID
        ";
        $results = $this->connection->prepare($sql);
        $results->bindParam(':orderID',$orderID);
        $results->execute();
        $articleList=[];
        while($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $article = new OxArticle();
            $article
                ->setArticleID($row['OXARTID'])
                ->setArtDesc($row['OXSHORTDESC'])
                ->setArticleTitle($row['OXTITLE'])
                ->setArtNumber($row['OXARTNUM'])
                ->setPrice($row['OXPRICE']);
            ;
            array_push($articleList,$article);
        }
        return $articleList;
    }

}
