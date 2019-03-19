<?php

require "db.php";





/*
  if(isset($_POST['searchUsers']))
  {
          //$search = htmlspecialchars($_POST['searchInput'],ENT_COMPAT | ENT_XHTML,'utf-8');
          $search = $_POST['searchInput'];
          SearchUser($pdo, $search);
  }*/

  function SearchUser ($pdo, $search){
  //$search = htmlspecialchars($search,ENT_COMPAT | ENT_XHTML,'utf-8');
  $statement = $pdo->prepare('SELECT * FROM `employee`  WHERE `employee_Id` LIKE ? OR `display_name` LIKE ?');
  $statement->execute((array('%'.$search.'%','%'.$search.'%' )));
  $result = $statement->fetchAll();
  return $result;
//  $_SESSION['searchResult'] = $result;
  }


//("SELECT * FROM `employee`  WHERE `employee_Id` LIKE `%".$search."%` ")
