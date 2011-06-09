<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("db/DBManager.php");
$db = new DBManager();
$user = $db->validateUser($_REQUEST);
if ($user[ID]!=""){
   $_SESSION[user]=$user;
   header("location:usuarios_admin.php");
   exit;
}else{
   header("location:login.php?error=Datos incorrectos");
   exit;
}

?>
