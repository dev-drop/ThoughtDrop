<?php
require "Includes/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 'On');

  /*function SearchUser ($pdo, $search){
  //$search = htmlspecialchars($search,ENT_COMPAT | ENT_XHTML,'utf-8');
  $statement = $pdo->prepare('SELECT * FROM `employee`  WHERE `employee_Id` LIKE ? OR `display_name` LIKE ?');
  $statement->execute((array('%'.$search.'%','%'.$search.'%' )));
  $result = $statement->fetchAll();
  return $result;
}*/

$action = isset($_GET['action']) ? $_GET['action'] : null;

$json = ['status' => 'failed'];

switch ($action)
{
  case 'search':
    //required parameter of userID
    if(!isset($_POST['searchInput']))
    {
      $json['error'] = 'A search is required';
    }else
    {
      $search = $_POST['searchInput'];
      $json['search_string'] = $search;
      //get users from DB here
      $json['status'] = 'success';
      $json['users'] = [];
      $statement = $pdo->prepare('SELECT * FROM `employee`  WHERE `employee_Id` LIKE ? OR `display_name` LIKE ?');
      if($statement->execute(array('%'.$search.'%','%'.$search.'%' )))
       	{
       	$json['users'] = $statement->fetchAll();
      }else
       	{
       	$json['status'] = 'failed';
       	$json['error'] = 'Database error';
       	}
    }
    break;

  default:
    $json['error'] = 'Action "' .$action. '" does not exsist';
    break;
}

header('Content-type: application/json');
die(json_encode($json));