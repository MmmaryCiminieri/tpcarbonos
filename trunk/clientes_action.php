<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("db/DBManager.php");
$db = new DBManager();

if ($_REQUEST[action]=="alta"){
   if ($_REQUEST[ID]==""){
      $db->addClient($_REQUEST,true);
   }else{
      $db->updateClient($_REQUEST);
   }
}else if ($_REQUEST[action]=="baja"){
   $res = $db->deleteClient($_REQUEST);
}

if ($res==1){
   header("location:clientes_admin.php");
}else{
   header("location:clientes_admin.php?mess=".$res);
}

?>
