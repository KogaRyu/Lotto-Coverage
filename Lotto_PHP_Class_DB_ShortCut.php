<?php
    include_once("Lotto_PHP_Class_DB_Connection.php");

    class EXT_PDO extends PDO{
        public function __construct($dbConfigFileName = 'Lotto_PHP_DB_Config.php', $dbName = 'db_lottery'){        
            $dbConfigFileObj    = include($dbConfigFileName);
            $dsnDetails         = $dbConfigFileObj[$dbName];
            parent::__construct($this->getDsn($dsnDetails), $this->getUser($dsnDetails), $this->getPwd($dsnDetails), $this->getOptions($dsnDetails));
        }
        protected function getDsn($cfg){
            $dbDsn = $cfg['Driver'].":host=".$cfg['Host'].";dbname=".$cfg['DB'].";charset=".$cfg['charset'];                            
            return $dbDsn;
        }
        protected function getUser($dsnDetails){            
            return $dsnDetails['User'];
        }
        protected function getPwd($dsnDetails){
            return $dsnDetails['Password'];
        }        
        protected function getOptions($dsnDetails){            
            return $dsnDetails['Options'];
        }
        public function run($sqlStatement, $stmtParams = NULL){
            if (!$stmtParams){ // Query has no Parameters
                return $this->query($sqlStatement);
            }
            else { // Query has Parameters       
                $stmt = $this->prepare($sqlStatement);
                $stmt->execute($stmtParams);
                return $stmt;
            }
        }
    }
?>
