<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("db/DBManager.php");
$db = new DBManager();

if ($_REQUEST[action]=="alta"){
   $res = $db->addUser($_REQUEST);
   if ($res!=1){
      header("location:usuarios_alta.php?mess=".$res);
      exit;
   }
}else if ($_REQUEST[action]=="baja"){
   $db->deleteUser($_REQUEST);
}else if ($_REQUEST[action]=="edit"){
   $db->updateUser($_REQUEST);
}else if ($_REQUEST[action]=="permissions"){
   $db->updateUserPermissions($_REQUEST);
}

header("location:usuarios_admin.php");

?>
