<?php

declare(strict_types=1);

namespace Denal05\EavExerciseGetDobViaCli\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;

class RawSqlQuery extends AbstractHelper
{
    protected $resourceConnection;

    public function __construct(Context $context, ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function runSqlQueryGetDobByEmail($email)
    {
        $connection = $this->resourceConnection->getConnection();

	/*
	 * How to get the customer Date of Birth using the Entity-Attribute-Value data model:
	 * If we need the DoB (attribute) of a customer (entity) we should retrieve the
	 * customer ID using their email by querying the customer_entity table, the dob 
	 * attribute ID in the eav_attribute table, and finally use both the entity_id and 
	 * attribute_id to retrieve the DoB (value) in the customer_entity_datetime table. 
	 * However, the example is old, and dob exists directly in the customer_entity table.
	 */

        // select entity_id from customer_entity where email="roni_cost@example.com";
        // select attribute_id from eav_attribute where attribute_code='dob'; <- unnecessary
        // select dob from customer_entity where entity_id=1;

        $entityIdQuery= "select entity_id from customer_entity where email='$email';";
        $entityIdResult = $connection->fetchAll($entityIdQuery);

        $dobQuery = "select dob from customer_entity where entity_id=" . (int) $entityIdResult . ";";
        $dobResult = $connection->fetchAll($dobQuery);

        return $dobResult;
    }
}
