<?Php
class DBManager {
    var $link_Hnd = ""; //database link handle

    var $host_Str="localhost";
    var $user_Str="root";
    var $pass_Str="root";
    var $dbName_Str="carbonos";

    function DBManager(){
        if (!$this->connect()){
           exit("Error al conectarse a BD.");
        }
    }
    
/***********************************************************/
/*****************       Usuarios    ***********************/
/***********************************************************/

	function addUser($parameters_Dic){
        $sql = "Select * from usuario where nick = '$parameters_Dic[nick]'";
        $existe = $this->_readOne($sql);
        if (is_array($existe)){
            return "El Nick de usuario ya existe. Por favor, eliga otro.";
        }
	
	    $esAdmin=1;
       	if ($parameters_Dic[admin]!="1"){
           $tipoPermiso = 8;//solo lectura
           $esAdmin=0;
        }else{
           $tipoPermiso = 15;//permiso a todo
        }
        
		$sql_Str = "INSERT INTO usuario
						(nick, admin, nombre, apellido, password)
					VALUES
						('$parameters_Dic[nick]', $esAdmin, '$parameters_Dic[nombre]', '$parameters_Dic[apellido]', md5('$parameters_Dic[password]'))";
		$this->_executeQuery($sql_Str);

        $sql_Str = "Select id from usuario order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           $idUser = $result[id];
        }else{
           return "Unknown Error";
        }
        
		$windows = $this->listWindows();
        foreach($windows as $win){
              $sql_Insert = "Insert into usuarioventana (idusuario,idventana,tipoPermiso) values($idUser,$win[ID],$tipoPermiso)";
              $this->_executeQuery($sql_Insert);
        }
		return true;
	}

    function listUsers($where){

		$sql_Str = "SELECT * FROM usuario " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre";

		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function deleteUser($parameters_Dic){
		$sql_Str = "DELETE FROM usuario
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function havePermissionByWinName($oper,$idUser,$winName){
         $sql = "Select ID from ventanas where nombre = '$winName'";

         $win = $this->_readOne($sql);
         if (is_array($win)){
            $idWin = $win[ID];
         }else{
            return "No existe la funcion";
         }

         return $this->havePermission($oper,$idUser,$idWin);
    }
    
    function havePermission($oper,$idUser,$idWin){

         $operType = "(0)";
         if ($oper=="alta"){
            $operType = "(1,3,5,7,9,11,13,15)";
         }
         if ($oper=="baja"){
            $operType = "(2,3,6,7,10,11,14,15)";
         }
         if ($oper=="modificacion"){
            $operType = "(4,5,6,7,12,13,14,15)";
         }
         if ($oper=="lectura"){
            $operType = "(8,9,10,11,12,13,14,15)";
         }
         $sql = "SELECT count(*)as q from usuarioventana where idusuario=$idUser and idventana=$idWin and tipoPermiso in $operType ";
		 $data = $this->_readone($sql);
         if ($data[q]==0){
            return false;
         }else{
            return true;
         }
    }

    function updateUserPermissions($parameters_Dic){
        $windows = $this->listWindows();
        foreach($windows as $win){
              $tipoPermiso = 0;//ninguno
              if ($parameters_Dic["alta".str_replace(" ", "_", $win[nombre])]=="yes"){
                 $tipoPermiso +=1;//Alta
              }
              if ($parameters_Dic["baja".str_replace(" ","_",$win[nombre])]=="yes"){
                 $tipoPermiso +=2;//Baja
              }
              if ($parameters_Dic["modificacion".str_replace(" ","_",$win[nombre])]=="yes"){
                 $tipoPermiso +=4;//Modificacion
              }
              if ($parameters_Dic["lectura".str_replace(" ","_",$win[nombre])]=="yes"){
                 $tipoPermiso +=8;//Lectura
              }
              $sql_Delete = "Delete from usuarioventana where idusuario=$parameters_Dic[ID] and idventana=$win[ID] ";
              $sql_Insert = "Insert into usuarioventana (idusuario,idventana,tipoPermiso) values($parameters_Dic[ID],$win[ID],$tipoPermiso)";
              $this->_executeQuery($sql_Delete);
              $this->_executeQuery($sql_Insert);
        }
		return true;
	}

   	function updateUser($parameters_Dic){
        $esAdmin=1;
       	if ($parameters_Dic[admin]!="1"){
           $esAdmin=0;
        }
		$sql_Str = "Update usuario
                    Set
                    admin = $esAdmin,
                    nombre = '$parameters_Dic[nombre]',
                    apellido = '$parameters_Dic[apellido]'
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

    function isUserInGroup($groupId, $usuarioId){
   		$sql_Str = "SELECT * FROM usuariogrupo
					WHERE usuarioId=$usuarioId and grupoId=$groupId";

        $result = $this->_readAll($sql_Str);
        if(count($result)>0){
            return true;
        }
		return false;
    }
    
    function getUser($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM usuario
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

	function changePassword($parameters_Dic){
		$sql_Str = "UPDATE usuario
						SET password = md5('$parameters_Dic[password]')
						WHERE ID = $parameters_Dic[id]";

		return $this->_executeQuery($sql_Str);
	}

	function validateUser($parameters_Dic){

		$sql_Str = "SELECT * FROM usuario
						WHERE nick = '$parameters_Dic[nick]'
							AND password = md5('$parameters_Dic[pass]')";


		return $this->_readOne($sql_Str);
	}

/***********************************************************/
/****************       Mercados             ***************/
/***********************************************************/

    function listMercados(){
		$sql_Str = "SELECT * from mercado";
		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function deleteMercado($parameters_Dic){
		$sql_Str = "DELETE FROM mercado
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

/***********************************************************/
/***********************************************************/
/***********************************************************/
/***********************************************************/

	function _readOne($sql_Str){
		if ($result = mysql_query($sql_Str, $this->link_Hnd)){
			return mysql_fetch_array($result);
		} else {
			exit("Error: ".$sql_Str." / ".mysql_error());
		}
	}
	
	function _readAll($sql_Str){
		$return=array();
		if ($result = mysql_query($sql_Str, $this->link_Hnd)){
			while ( $register = mysql_fetch_array($result) ){
				$return[] = $register;
			}
			return $return;
		} else{
			//echo("<span style='color:darkblue;font-weight:bold;'>No hay datos");
            return false;
        };
    }

	function _executeQuery($sql_Str){
        mysql_query($sql_Str, $this->link_Hnd);
	    if (mysql_error()){
	       echo("Error: ". mysql_error());
           $this->rollbackTransaction();
           if (strlen(strstr(mysql_error(),"FOREIGN KEY"))>0){
              return "No puede eliminar el registro ya que esta relacionado con otros datos.";
           }else{
              echo(strstr(mysql_error(),"FOREIGN KEY"). "<br>". $sql_Str);
              die(mysql_error());
           }
        }
		return 1;
    }
    
    function connect(){
		$this->link_Hnd = mysql_connect($this->host_Str, $this->user_Str, $this->pass_Str);
		if (!$this->link_Hnd) {
			return false;
		}
		// make foo the current db
		$ok = mysql_select_db($this->dbName_Str, $this->link_Hnd);

		if (!$ok) {
			return false;
        }

		return true;
	}

	function disconnect(){
		return mysql_close($this->link_Hnd);
	}
	
	function beginTransaction(){
        mysql_query("BEGIN");
    }
    
    function commitTransaction(){
        mysql_query("COMMIT");
    }
    
    function rollbackTransaction(){
        mysql_query("ROLLBACK");
    }
    
}
?>
