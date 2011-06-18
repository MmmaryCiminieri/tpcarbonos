<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("DBManager.php");
$db = new DBManager();

$_SESSION[register]=$_REQUEST;
$mess=$db->validarNick($_REQUEST);
$db->beginTransaction();
if ($mess!=""){
   $db->rollbackTransaction();
   header("location:register.php?mess=Error al registrar empresa. Por Favor, comuniquese con el administrador del sistema. (mail: admin@carbonos.com)<br>Error: $mess");
}else{
      $idEmpresa = $db->addEmpresa($_REQUEST);
      $_REQUEST[idempresa]=$idEmpresa;
      echo("idEmpresa: $_REQUEST[idEmpresa] <br>");
      if (!is_numeric($idEmpresa)){
         $db->rollbackTransaction();
         header("location:register.php?mess=Error al registrar empresa. Por Favor, comuniquese con el administrador del sistema. (mail: admin@carbonos.com)<br>Error: $idEmpresa");
      }else{
            $idUsuario = $db->addUsuario($_REQUEST);
            if (!is_numeric($idUsuario)){
               $db->rollbackTransaction();
               header("location:register.php?mess=Error al registrar usuario. Por Favor, comuniquese con el administrador del sistema. (mail: admin@carbonos.com)<br>Error: $idUsuario");
            }else{
               $_SESSION[register]=NULL;
               $db->commitTransaction();
               header("location:registerOk.php?mess=Se ha registrado con exito. Se le comunicara por e-mail cuando el usuario este habilitado.");
            }
      }
}

?>
