<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/27/17
 * Time: 2:15 PM
 */

include "../includes/php/base.php";
include "../includes/php/general.php";

$action = get_value('action');

switch($action){
    case 'getCategories':

        break;
    case 'getEvents':
        $sql = "SELECT eventID, eventTitle FROM events WHERE categoryID=".get_value('category');
        $query = mysqli_query($conn, $sql);
        $json = array();
        while($result = mysqli_fetch_assoc($query)){
            array_push($json, array("id" => $result['eventID'], "label"=>$result['eventTitle']));
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
        exit;
        break;
    case 'getUnits':
        $sql = "SELECT unitID, unitTitle FROM units WHERE unitTitle LIKE '%".get_value('query')."%'";
        $query = mysqli_query($conn, $sql);
        $json = array();
        while($result = mysqli_fetch_assoc($query)){
            $curr = array("id" => $result['unitID'], "label"=>$result['unitTitle']);
            array_push($json, $curr);
        }
        echo json_encode($json);
        exit;
        break;
}