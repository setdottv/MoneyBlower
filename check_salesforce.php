#!/usr/bin/php
<?php
define('BASE_PATH', dirname(__FILE__));
define("SOAP_CLIENT_BASEDIR", BASE_PATH."/soapclient");

define("USERNAME", "SF API USERNAME HERE");
define("PASSWORD", "SF PASSWORD HERE");
define("SECURITY_TOKEN", "SF TOKEN");

require_once (SOAP_CLIENT_BASEDIR.'/SforceEnterpriseClient.php');
require_once (SOAP_CLIENT_BASEDIR.'/SforceHeaderOptions.php');
try {
    $mySforceConnection = new SforceEnterpriseClient();
    $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR."/enterprise.wsdl.xml");
    $mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);

    $query = "SELECT ID, SystemModstamp, Name, StageName FROM Opportunity ";
    $query.= "WHERE SystemModstamp > ".gmdate("Y-m-d\TH:i:s+0000", (time()-900))." ";
    $query.= "AND StageName='Closed Won: IO Signed' ";
    $query.= "ORDER BY SystemModstamp DESC limit 5";
    $response = $mySforceConnection->query(($query));

    if($response->size<1){
        print date('m.d.Y H:i:s').": no recent modifications found.\n";
        exit;
    }
   
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:'.BASE_PATH.'/done.sqlite');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);

    foreach ($response->records as $record) {
        // Select all data from file db messages table 
        $result = $file_db->query('SELECT id FROM sales WHERE id="'.$record->Id.'"');
        //if we found a record
        if(sizeof($result->fetchAll())>0){
            print date('m.d.Y H:i:s').": already alerted for ID ".$record->Id." this sale, boo hoo no alarm\n";
        }
        else{
            print date('m.d.Y H:i:s').": Sale ID ".$record->Id."Closed...Ringing The Bell!\n";
            $count = $file_db->exec("INSERT INTO sales (id) VALUES ('".$record->Id."')");
            exec(BASE_PATH.'/alert.pl');      
      }
    }

} catch (Exception $e) {
    print_r($e);
  echo $e->faultstring;
}

?>
