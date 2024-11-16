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
    public function runSqlQueryOnTable($table)
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName($table);
        $query = "SELECT * FROM " . $table;
        $result = $connection->fetchAll($query);
        return $result;
	/*
        $this->_logger->log(print_r($result, true));
        $id = 2;
        $query = "SELECT * FROM `" . $table . "` WHERE id = $id ";
        $result1 = $connection->fetchAll($query);
        $this->_logger->log(print_r($result1, true));
        //For Insert query
        $tableColumn = ['id', 'name', 'age'];
        $tableData[] = [5, 'xyz', '20'];
        $connection->insertArray($table, $tableColumn, $tableData);
        $query = "INSERT INTO `" . $table . "`(`id`, `name`, `age`) VALUES (7,'mtm',33)";
        $connection->query($query);
        // For Update query
        $id = 1;
        $query = "UPDATE `" . $table . "` SET `name`= 'test' WHERE id = $id ";
        $connection->query($query);
        $query1 = "UPDATE `" . $table . "` SET `name`= 'test', `age` = 14 WHERE id = $id ";
        $connection->query($query1);
        // For Delete query
        $id = 1;
        $query = "DELETE FROM `" . $table . "` WHERE id = $id ";
        $connection->query($query);
	 */
    }
}
