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
