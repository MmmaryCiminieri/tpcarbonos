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
	function validarNick($parameters_Dic){
        $sql = "Select * from usuario where nick = '$parameters_Dic[nick]'";
        $existe = $this->_readOne($sql);
        if (is_array($existe)){
           return "El Nick de usuario ya existe. Por favor, eliga otro.";
        }else{
           return "";
        }
    }
    
	function addUsuario($parameters_Dic){
		$sql_Str = "INSERT INTO usuario
						(nick, admin, nombre, apellido, password, idEmpresa, mail, documento)
					VALUES
						('$parameters_Dic[nick]', 0, '$parameters_Dic[nombre]', '$parameters_Dic[apellido]', md5('$parameters_Dic[password]'),$parameters_Dic[idempresa], '$parameters_Dic[mail]', '$parameters_Dic[documento]')";
		$this->_executeQuery($sql_Str);
        $sql_Str = "Select id from usuario order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }else{
           return "Unknown Error";
        }
	}

    function listUsuarios($where){

		$sql_Str = "SELECT * FROM usuario " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre";

		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function deleteUsuario($parameters_Dic){
		$sql_Str = "DELETE FROM usuario
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

   	function updateUsuario($parameters_Dic){
        $esAdmin=1;
       	if ($parameters_Dic[admin]!="1"){
           $esAdmin=0;
        }
		$sql_Str = "Update usuario
                    Set
                    admin = $esAdmin,
                    nombre = '$parameters_Dic[nombre]',
                    apellido = '$parameters_Dic[apellido]',
                    mail = '$parameters_Dic[mail]',
                    documento = '$parameters_Dic[documento]'
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}
    
    function getUsuario($id){
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

	function validateUsuario($parameters_Dic){

		$sql_Str = "SELECT * FROM usuario
						WHERE nick = '$parameters_Dic[nick]'
							AND password = md5('$parameters_Dic[password]')";
                                      echo($sql_Str);
		return $this->_readOne($sql_Str);
	}
	
	function aprobarUsuario($id, $aprobar){

             $sql_Str = "UPDATE usuario
						SET aprobado = $aprobar
						WHERE ID = $id";

		    return $this->_executeQuery($sql_Str);
	}

/***********************************************************/
/*****************     Empresas      ***********************/
/***********************************************************/

	function addEmpresa($parameters_Dic){
        $sql = "Select * from empresa where razonsocial = '$parameters_Dic[razonsocial]' and idpais='$parameters_Dic[idpais]' ";
        $existe = $this->_readOne($sql);
        if (is_array($existe)){
            return "El empresa ya se encuentra registrada.";
        }

		$sql_Str = "INSERT INTO empresa
						(razonsocial, direccion, idpais, codigovalidacion, telefono, descripcion, web)
					VALUES
						('$parameters_Dic[razonsocial]', '$parameters_Dic[direccion]', $parameters_Dic[idpais], '$parameters_Dic[codigovalidacion]', '$parameters_Dic[telefono]', '$parameters_Dic[descripcion]', '$parameters_Dic[web]')";
		$this->_executeQuery($sql_Str);
        $sql_Str = "Select id from empresa order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }else{
           return "Unknown Error: $sql_Str" ;
        }
	}

    function listEmpresas($where){

		$sql_Str = "SELECT * FROM empresa " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY pais, razonsocial";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

	function deleteEmpresa($parameters_Dic){
		$sql_Str = "DELETE FROM empresa
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

   	function updateEmpresa($parameters_Dic){
        $esAdmin=1;
       	if ($parameters_Dic[admin]!="1"){
           $esAdmin=0;
        }
		$sql_Str = "Update empresa
                    Set
                    razonsocial = '$parameters_Dic[razonsocial]',
                    direccion = '$parameters_Dic[direccion]',
                    idpais = $parameters_Dic[idpais],
                    codigovalidacion = '$parameters_Dic[codigovalidacion]',
                    telefono = '$parameters_Dic[telefono]',
                    descripcion = '$parameters_Dic[descripcion]',
                    web = '$parameters_Dic[web]',
                    aprobado = $parameters_Dic[aprobado]
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

    function getEmpresa($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM empresa
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

/***********************************************************/
/*****************       Paises      ***********************/
/***********************************************************/

    function listPaises($where){

		$sql_Str = "SELECT * FROM pais " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre ";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

    function getPais($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM pais
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

/***********************************************************/
/***************** Organismo Certificante ******************/
/***********************************************************/

    function listOrganismosCertificantes($where){

		$sql_Str = "SELECT * FROM organismocertificante " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre ";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

    function getOrganismoCertificante($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM organismocertificante
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

/***********************************************************/
/*****************         tipo bono      ******************/
/***********************************************************/

    function listTipoBono($where){

		$sql_Str = "SELECT * FROM tipobono " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre ";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

    function getTipoBono($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM tipobono
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

/***********************************************************/
/*****************       Bono        ***********************/
/***********************************************************/

	function addBono($parameters_Dic){
		$sql_Str = "INSERT INTO bono
						(cer, precio, idusuario, fechacreacion, idorganismocertificante)
					VALUES
						('$parameters_Dic[cer]', '$parameters_Dic[precio]', $parameters_Dic[idusuario], '$parameters_Dic[fechacreacion]',$parameters_Dic[idorganismocertificante])";
		$this->_executeQuery($sql_Str);

        $sql_Str = "Select id from bono order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }else{
           return "Unknown Error";
        }
	}

    function listBonos($where){

		$sql_Str = "SELECT * FROM bonos " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY id ";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

	function deleteBono($parameters_Dic){
		$sql_Str = "DELETE FROM bono
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

   	function updateBono($parameters_Dic){
		$sql_Str = "Update bono
                    Set
                    cer='$parameters_Dic[cer]',
                    precio=$parameters_Dic[precio],
                    idusuario=$parameters_Dic[idUsuario]
					WHERE ID = $parameters_Dic[id]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

    function getBono($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM bono
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
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
           if (strlen(strstr(mysql_error(),"FOREIGN KEY"))>0){
              echo "No puede eliminar el registro ya que esta relacionado con otros datos.";
           }else{
              echo(strstr(mysql_error(),"FOREIGN KEY"). "<br>". $sql_Str);
              //die(mysql_error());
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
