<?php


require '../../../config.php';
require '../../../lib/parse/vendor/autoload.php';
session_start();
require '../../../class/member.php';
require '../../../function/global/global.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParseUser;
use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParseSession;
use Parse\ParseSessionStorage;
use Parse\ParseStorageInterface;
$app_id="KSAFJCER1243FDEDASD111";
$rest_key="KSAFJCER1243FDEDASD111";
$master_key="KSAFJCER1243FDEDASD111";
$url="http://192.168.1.202:1339";
ParseClient::initialize($app_id,$rest_key, $master_key);
ParseClient::setServerURL($url,'parse');



$idcard = $_GET["idcard"];
$date = $_GET["date"];
// $data=array();
$data_object = new stdClass;

//-----------หาประวัติ-----
$query = new ParseQuery("csvupload");
$query->equalTo("idcard",$idcard);
$query->equalTo("date",$date);
// $query->limit(20);
  $results = $query->find();
  $object = $results[0];
  for ($i = 0; $i < count($results); $i++) {



    $object = $results[$i];
     $id = $object->get('idcard');
     // echo "<td>".$id." </td>";
     $user = $object->get('userid');
     // echo "<td>".$user." </td>";
     $stations = $results[$i]->get('stations');
     // for ($r = 0; $r < count($stations); $r++) {
     // echo $stations[$r]." ";
     //  }


//-----
      $MoblieCheckup = new ParseQuery('MoblieCheckup');
      $MoblieCheckup->equalTo("userid",$user);
      $Moblieresults = $MoblieCheckup->find();
      $Moblieobject = $Moblieresults[0];
      for ($r = 0; $r < count($stations); $r++) {
        if ($stations[$r] == "gslsmale" || $stations[$r] == "gslsfemale" ){
          $stations[$r] = "gsls";
        }
        $station = $Moblieobject->get($stations[$r]);
        if (!$station){
          continue;
        }
        // echo "<td>".$stations[$r]." </td>";

          // print_r($station);
          // array_push($data,$station);
          // echo json_encode($station);
          // echo "<br>";
          if($stations[$r] == "checkup"){
            $data_object->checkup = $station;
          }elseif($stations[$r] == "blood"){
            $data_object->blood = $station;
          }elseif($stations[$r] == "xray"){
            $data_object->xray = $station;
          }elseif($stations[$r] == "checkupeye"){
            $data_object->checkupeye = $station;
          }elseif($stations[$r] == "eyes"){
            $data_object->eyes = $station;
          }elseif($stations[$r] == "colorblindness"){
            $data_object->colorblindness = $station;
          }elseif($stations[$r] == "ear"){
            $data_object->ear = $station;
          }elseif($stations[$r] == "checkupspirometry"){
            $data_object->checkupspirometry = $station;
          }elseif($stations[$r] == "spirometry"){
            $data_object->spirometry = $station;
          }elseif($stations[$r] == "gsls"){
            $data_object->gsls = $station;
          }

      }

   }

// echo "<br><br><br><br><br><br><br>";
// echo json_encode($data);
echo json_encode($data_object);
?>
