<?php


namespace AppBundle\Repository;
use AppBundle\Database\OxPdo;
use AppBundle\Entity\OxCustomer;

class OxCustomerRepository
{
    private $connection;

    /**
     * OxCustomerRepository constructor.
     */
    function __construct(OxPdo $database)
    {
            $this->connection=$database;
    }

    public function getAll()
    {
        $sql = "
            Select *
            From oxuser
        ";
        $results = $this->connection->query($sql);
        $customerList=[];
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $customer = new OxCustomer();
            $customer
                ->setCustomerId($row['OXCUSTNR'])
                ->setUsername($row['OXUSERNAME'])
                ->setFirstname($row['OXFNAME'])
                ->setLastname($row['OXLNAME'])
                ->setCompany($row['OXCOMPANY'])
                ->setCity($row['OXCITY'])
                ->setSteetname($row['OXSTREET'])
                ->setStreetnumber($row['OXSTREETNR'])
                ->setRights($row['OXRIGHTS']);
            array_push($customerList,$customer);
        }
    }

    public function getCustomerByCustomerId($customerId)
    {
        $sql = "
            Select *
            From oxuser
            where oxid like (:customerId)
        ";

        $results = $this->connection->prepare($sql);
        $results->bindParam(':customerId', $customerId);
        $results->execute();
        $customer = new OxCustomer();
        while ($row = $results->fetch(\PDO::FETCH_ASSOC))
        {
            $customer
                ->setCustomerId($row['OXCUSTNR'])
                ->setUsername($row['OXUSERNAME'])
                ->setFirstname($row['OXFNAME'])
                ->setLastname($row['OXLNAME'])
                ->setCompany($row['OXCOMPANY'])
                ->setCity($row['OXCITY'])
                ->setSteetname($row['OXSTREET'])
                ->setStreetnumber($row['OXSTREETNR'])
                ->setRights($row['OXRIGHTS']);
        }
        return $customer;
    }

    public function loginCustomer($username, $password)
    {
        $salt = $this->getSalt($username);
        $sql=" SELECT *
            FROM oxuser
            WHERE oxactive = 1
            AND oxpassword like (:password)
            AND oxusername like (:username)
        ";
        $results = $this->connection->prepare($sql);
        $password = hash('sha512',$password.$salt);
        $results->bindParam(':password',$password);
        $results->bindParam(':username', $username);
        $results->execute();
        $row = ($results->fetch(\PDO::FETCH_ASSOC));

        return $row !== false ? $row['OXID']:false;
    }

    private function getSalt($username)
    {
        $sql="
            SELECT oxpasssalt
            From oxuser
            where oxusername like (:username)
        ";
        $results = $this->connection->prepare($sql);
        $results->bindParam(':username', $username);
        $results->execute();
        $row=$results->fetch(\PDO::FETCH_ASSOC);
        return $row['oxpasssalt'];

    }

    public function save(array $customerData,$customerId)
    {
        $sql="
            UPDATE oxuser
            SET
            `OXUSERNAME` = :username,
            `OXFNAME` = :firtstname,
            `OXLNAME` = :lastname,
            `OXCOMPANY` = :company,
            `OXCITY` = :city,
            `OXSTREET` = :street,
            `OXSTREETNR` = :streetnr
            where `OXCUSTNR` = :customerid
        ";

        $results = $this->connection->prepare($sql);
        $results->bindParam(':username',$customerData['E-Mail']);
        $results->bindParam(':firtstname',$customerData['Firstname']);
        $results->bindParam(':lastname',$customerData['Lastname']);
        $results->bindParam(':company',$customerData['Company']);
        $results->bindParam(':city',$customerData['City']);
        $results->bindParam(':street',$customerData['Streetname']);
        $results->bindParam(':streetnr',$customerData['Streetnumber']);
        $results->bindParam(':customerid',$customerId);
        $results->execute();

    }
}
