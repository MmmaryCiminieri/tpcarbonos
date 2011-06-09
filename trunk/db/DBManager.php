<?Php
class DBManager {
    var $link_Hnd = ""; //database link handle

    var $host_Str="gasmed20101130.db.3404023.hostedresource.com";
    var $user_Str="gasmed20101130";
    var $pass_Str="ANTgasmed2010";
    var $dbName_Str="gasmed20101130";
  /*
    var $host_Str="localhost";
    var $user_Str="root";
    var $pass_Str="root";
    var $dbName_Str="dbcel";
    */
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

/****************************************************************/
/***********               Ventanas                     *********/
/****************************************************************/

    function listWindows($where){
		$sql_Str = "SELECT * FROM ventanas ";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .= " ORDER BY nombre ";

		$data = $this->_readAll($sql_Str);
		return $data;
	}


/***********************************************************/
/****************       Cliente              ***************/
/***********************************************************/

	function addClient($parameters_Dic, $useTrans){
    	if ($useTrans){
           $this->beginTransaction();
        }
        $addressId = $this->addAddress($parameters_Dic);
        if ($parameters_Dic[nroMedidor]==""){
           $meterId = $parameters_Dic[medidorId];
        }else{
           $sql_Str = "INSERT INTO medidor
						(numero,estadomedidorId,observaciones)
					   VALUES
						('$parameters_Dic[nroMedidor]', (Select id from estadomedidor LIMIT 1), '')";
           //echo $sql_Str;
           $this->_executeQuery($sql_Str);
           $sql_Str = "Select id from medidor order by id desc LIMIT 1";
           $result = $this->_readOne($sql_Str);
           if (is_array($result)){
              $meterId = $result[id];
           }
        }

		$sql_Str = "INSERT INTO cliente
						(nombre, codigo, direccionId, zonaId, ordenDeseadoEnZona, medidorId)
					VALUES
						('$parameters_Dic[nombre]', $parameters_Dic[codigo], $addressId, $parameters_Dic[zonaId], $parameters_Dic[orden], $meterId)";

        $this->_executeQuery($sql_Str);
		
		$sql_Str = "Select id from cliente order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);

        if (is_array($result)){
           if ($useTrans){
              $this->commitTransaction();
           }
           return $result[id];
        }
        $this->rollbackTransaction();
        
		return $result;
	}

    function listClient($from, $quantity, $filters, $order){
        $from = $from * $quantity;
		$sql_Str = "SELECT c.*, z.descripcion as nombreZona, m.numero as nroMedidor,
                   CONCAT(d.calle,' ',d.altura,' ',d.piso,' ',d.departamento) as direccionStr
                             FROM cliente c,direccion d,zona z,medidor m
                   Where c.medidorId = m.id and c.zonaId = z.id and c.direccionId = d.id ";

		if (!empty($filters)){
			$sql_Str .=" and " . $filters;
        }

		if (!empty($order)){
			$sql_Str .=" $order ";
		}else{
			$sql_Str .=" order by nombre ";
        }
        
        if ($quantity > 0){
           $sql_Str = $sql_Str . " LIMIT $from,$quantity";
        }
//        echo ($sql_Str);
		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function countAllClients($filters){
		$sql_Str = "SELECT count(*)as q FROM cliente c,direccion d,zona z,medidor m
                   Where c.medidorId = m.id and c.zonaId = z.id and c.direccionId = d.id ";

        if (!empty($filters)){
			$sql_Str .=" and " . $filters;
        }

		$data = $this->_readone($sql_Str);
		return $data[q];
	}

    function listClientWithoutRoad($zoneId, $order){
        $zoneClause="";
        if ($zoneId!=""){
          $zoneClause = " and z.ID = $zoneId ";
        }
		$sql_Str = "SELECT c.*, z.descripcion as nombreZona, m.numero as nroMedidor,
                  CONCAT(d.calle,' ',d.altura,' ',d.piso,' ',d.departamento) as direccionStr
                             FROM cliente c,direccion d,zona z,medidor m
                   Where c.medidorId = m.id and c.zonaId = z.id and c.direccionId = d.id $zoneClause and
                         c.ID not in (Select clienteId from rutaClientes)";

		if (!empty($order)) {
			$sql_Str .=" $order ";
		}else{
			$sql_Str .=" order by nombre ";
        }
		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
    function listClientsFromRoad($roadId, $orderClause){
		$sql_Str = "SELECT rc.orden, c.*, z.descripcion as nombreZona, m.numero as nroMedidor, r.descripcion as rutaDescripcion,
                   CONCAT(d.calle,' ',d.altura,' ',d.piso,' ',d.departamento) as direccionStr,
                   (Select lectura from medicion mn where mn.medidorId = c.medidorId order by fecha limit 1)as ultimaMedicion
                             FROM cliente c,direccion d,zona z,medidor m, rutaclientes rc, ruta r
                   Where c.medidorId = m.id and c.zonaId = z.id and c.direccionId = d.id and r.ID = rc.rutaId and
                         rc.clienteId = c.ID and rc.rutaId = ". $roadId .$orderClause;
        //echo( $sql_Str);
		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function deleteClient($parameters_Dic){
		$sql_Str = "DELETE FROM cliente
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    /**
    * El cambio de medidor se hace con el metodo de crear asignar medidor
    */
   	function updateClient($parameters_Dic){

		$sql_Str = "Update cliente
                    Set
                    nombre = '$parameters_Dic[nombre]',
                    codigo = $parameters_Dic[codigo],
                    tipoClienteId = $parameters_Dic[tipoClienteId]
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}
	
	function assignMeterToClient($meterId, $clientId){
          $sql_Str = "Update cliente
                    Set
                    medidorId = $meterId
					WHERE ID = $clientId";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);
    }

    function getClient($id){
        if ($id!=""){

            $sql_Str = "SELECT c.*, z.descripcion, m.numero,
                   CONCAT(d.calle,' ',d.altura,' ',d.piso,' ',d.departamento) as direccionStr
                             FROM cliente c,direccion d,zona z,medidor m
                   Where c.medidorId = m.ID and c.zonaId = z.ID and c.direccionId = d.ID and c.ID = $id";

	     	$result = $this->_readOne($sql_Str);
	     	
   			return ($result);
        }else{
            return array();
        }
	}
	
	function getClientByMeterId($id){
        if ($id!=""){

            $sql_Str = "SELECT c.*, z.descripcion, m.numero as medidorNro,
                   CONCAT(d.calle,' ',d.altura,' ',d.piso,' ',d.departamento) as direccionStr
                             FROM cliente c,direccion d,zona z,medidor m
                   Where c.medidorId = m.ID and c.zonaId = z.ID and c.direccionId = d.ID and m.ID = $id";

	     	$result = $this->_readOne($sql_Str);

   			return ($result);
        }else{
            return array();
        }
	}

    function deleteClientFromRoad($clientId){
         $this->beginTransaction();
         $sql_Str = "SELECT orden FROM rutaClientes
                    where clienteId=$clientId";
         $result = $this->_readOne($sql_Str);
         $orden = $result[0];
         
         $sql_Str = "UPDATE Cliente set ordenDeseadoEnZona = $orden
                    where ID=$clientId";
         $this->_executeQuery($sql_Str);
                    
         $sql_Str = "DELETE FROM rutaClientes
					WHERE clienteId = $clientId";

         $mess = $this->_executeQuery($sql_Str);
         $this->commitTransaction();
         return $mess;
    }
    
/***********************************************************/
/****************       Direccion            ***************/
/***********************************************************/

	function addAddress($parameters_Dic){

		$sql_Str = "INSERT INTO direccion
						(calle, altura, piso, departamento, latitud, longitud)
					VALUES
						('$parameters_Dic[calle]', '$parameters_Dic[altura]', '$parameters_Dic[piso]',
                         '$parameters_Dic[departamento]', 0, 0)";

        $this->_executeQuery($sql_Str);
        
        $sql_Str = "Select id from direccion order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}
	
   	function updateAddress($parameters_Dic){

		$sql_Str = "Update direccion
                    Set
                    calle = '$parameters_Dic[calle]',
                    altura = $parameters_Dic[altura],
                    piso = '$parameters_Dic[piso]',
                    departamento = '$parameters_Dic[departamento]',
                    latitud = $parameters_Dic[latitud],
                    longitud = $parameters_Dic[longitud]
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

    function listAddress($where){

		$sql_Str = "SELECT * FROM direccion " ;

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY nombre";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

	function deleteAddress($parameters_Dic){
		$sql_Str = "DELETE FROM direccion
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}
	
    function getAddress($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM direccion
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }


	}
	
/***********************************************************/
/****************       Medidor              ***************/
/***********************************************************/

	function addMeter($parameters_Dic){

		$sql_Str = "INSERT INTO medidor
						(numero,estadomedidorId,observaciones)
					VALUES
						('$parameters_Dic[numero]', $parameters_Dic[estadomedidorId], '$parameters_Dic[observaciones]')";
        //echo($sql_Str);
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select id from medidor order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

   	function updateMeter($parameters_Dic){

		$sql_Str = "Update medidor
                    Set
                    numero = '$parameters_Dic[numero]',
                    estadomedidorId = $parameters_Dic[estadomedidorId],
                    observaciones = '$parameters_Dic[observaciones]'
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

	function deleteMeter($parameters_Dic){
		$sql_Str = "DELETE FROM medidor
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function getMeter($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM medidor
						WHERE ID = $id";
	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

    function getMeterByNumber($num){
        if ($num!=""){
    		$sql_Str = "SELECT * FROM medidor
						WHERE numero = $num";
	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}
	
	function listMeter($from, $quantity, $where){
        $from = $from * $quantity;
		$sql_Str = "SELECT * FROM medidor";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY numero";

        if ($quantity > 0){
           $sql_Str = $sql_Str . " LIMIT $from,$quantity";
        }
        //echo($sql_Str);
		$data = $this->_readAll($sql_Str);
		return $data;
	}
	
	function countAllMeters($where){

		$sql_Str = "SELECT count(*) as q FROM medidor";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}

		$data = $this->_readOne($sql_Str);
		return $data[q];
	}

	function listMeterNotInUse($where){

		$sql_Str = "SELECT distinct * FROM medidor where ID not in (Select medidorId from cliente)";
		$sql_Str .=" ORDER BY numero";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

/***********************************************************/
/****************        Mediciones       ******************/
/***********************************************************/

	function addMeassure($datePhoneMillis,$meterNr,$meassure,$obs){
	
        $phoneDate = date("Y-m-d H:i:s",($datePhoneMillis/1000));
    	$importDate = date ("Y-m-d H:i:s");
    	
    	
        $meter = $this->getMeterByNumber($meterNr);
		$sql_Str = "INSERT INTO medicion
						(fechaImportacion, fecha, lectura, observacion, medidorId, estadoLecturaId)
					VALUES
						('$importDate', '$phoneDate','$meassure', '$obs', $meter[ID], 2)";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select ID from medidor order by ID desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

    function getConsume($meter, $meassure){
		$sql_Str = "SELECT lectura FROM medicion
                    WHERE lectura < $meassure and medidorId = $meter order by lectura desc";

        //echo $sql_Str;
		$data = $this->_readAll($sql_Str);
		
		if (count($data) > 0){
           return $meassure - $data[0][lectura];
        }
		return "-";
	}
	
    function listMeassures($from, $quantity, $where, $order){
        $from = $from * $quantity;
		$sql_Str = "SELECT * FROM medicion, medidor, cliente WHERE medicion.medidorId = medidor.ID and cliente.medidorId = medidor.Id";

		if (!empty($where)) {
			$sql_Str .=" and $where";
		}
		if (!empty($order)) {
			$sql_Str .=" $order";
		}

        if ($quantity > 0){
           $sql_Str = $sql_Str . " LIMIT $from,$quantity";
        }
		$data = $this->_readAll($sql_Str);

		return $data;
	}

    function countAllMeassures($where){
        $sql_Str = "SELECT count(*) as q FROM medicion, medidor, cliente WHERE medicion.medidorId = medidor.ID and cliente.medidorId = medidor.Id ";

		if (!empty($where)) {
			$sql_Str .=" and $where";
		}

		$data = $this->_readOne($sql_Str);

		return $data[q];
    }
    
/***********************************************************/
/****************          zona           ******************/
/***********************************************************/

	function addZone($parameters_Dic){

        if ($parameters_Dic[zonaContenedoraId]==""){
           $zonaCont = "null";
        }else{
           $zonaCont = $parameters_Dic[zonaContenedoraId];
        }
		$sql_Str = "INSERT INTO zona
						(descripcion, zonaContenedoraId)
					VALUES
						('$parameters_Dic[descripcion]', $zonaCont)";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select id from zona order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

   	function updateZone($parameters_Dic){

		$sql_Str = "Update zona
                    Set
                    descripcion = '$parameters_Dic[descripcion]',
                    zonaContenedoraId = $parameters_Dic[zonaContenedoraId]
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

	function deleteZone($parameters_Dic){
		$sql_Str = "DELETE FROM zona
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function getZone($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM zona
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

    function getZoneByDesc($desc){
        if ($desc!=""){
    		$sql_Str = "SELECT * FROM zona
						WHERE descripcion = '$desc'";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
    }
    
    function listZone($where){

		$sql_Str = "SELECT * FROM zona";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY descripcion";

		$data = $this->_readAll($sql_Str);
		return $data;
	}
/***********************************************************/
/****************        TipoCliente      ******************/
/***********************************************************/

	function addClientType($parameters_Dic){

		$sql_Str = "INSERT INTO tipoCliente
						(descripcion)
					VALUES
						('$parameters_Dic[descripcion]')";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select id from tipoCliente order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

   	function updateClientType($parameters_Dic){

		$sql_Str = "Update tipoCliente
                    Set
                    descripcion = '$parameters_Dic[descripcion]'
					WHERE ID = $parameters_Dic[ID]";
					//echo $sql_Str;
         $this->_executeQuery($sql_Str);

		 return true;
	}

	function deleteClientType($parameters_Dic){
		$sql_Str = "DELETE FROM tipoCliente
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function getClientType($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM tipoCliente
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

/***********************************************************/
/****************      Estado Medidor     ******************/
/***********************************************************/

	function addMeterState($parameters_Dic){
        if ($parameters_Dic[funciona]!="1"){
           $funca = 0;
        } else{
           $funca = 1;
        }
		$sql_Str = "INSERT INTO estadomedidor
						(descripcion, funciona)
					VALUES
						('$parameters_Dic[descripcion]',$funca)";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select id from estadomedidor order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

   	function updateMeterState($parameters_Dic){
   	    if ($parameters_Dic[funciona]!="1"){
           $funca = 0;
        } else{
           $funca = 1;
        }
		$sql_Str = "Update estadomedidor
                    Set
                    descripcion = '$parameters_Dic[descripcion]',
                    funciona = $funca
					WHERE ID = $parameters_Dic[ID]";
					
        $this->_executeQuery($sql_Str);

		return true;
    }

	function deleteMeterState($parameters_Dic){
		$sql_Str = "DELETE FROM estadomedidor
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function getMeterState($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM estadomedidor
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

    function listMeterStates($where){

		$sql_Str = "SELECT * FROM estadomedidor";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY descripcion";

		$data = $this->_readAll($sql_Str);
		return $data;
	}
/***********************************************************/
/****************            Ruta          *****************/
/***********************************************************/

	function addRoad($parameters_Dic){

		$sql_Str = "INSERT INTO ruta
						(descripcion)
					VALUES
						('$parameters_Dic[descripcion]')";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

        $sql_Str = "Select id from ruta order by id desc LIMIT 1";
        $result = $this->_readOne($sql_Str);
        if (is_array($result)){
           return $result[id];
        }

		return $result;
	}

   	function updateRoad($parameters_Dic){
		$sql_Str = "Update ruta
                    Set
                    descripcion = '$parameters_Dic[descripcion]'
					WHERE ID = $parameters_Dic[ID]";
        //echo $sql_Str;
        $this->_executeQuery($sql_Str);

		return true;
	}


	function deleteRoad($parameters_Dic){
		$sql_Str = "DELETE FROM ruta
					WHERE ID = $parameters_Dic[ID]";
		return $this->_executeQuery($sql_Str);
	}

    function getRoad($id){
        if ($id!=""){
    		$sql_Str = "SELECT * FROM ruta
						WHERE ID = $id";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

    function getRoadByDesc($desc){
        if ($desc!=""){
    		$sql_Str = "SELECT * FROM ruta
						WHERE descripcion = '$desc'";

	     	$result = $this->_readOne($sql_Str);
   			return ($result);
        }else{
            return array();
        }
	}

    function addClientToRoad($roadId, $clientId){
        $sql_Str = "Select ordenDeseadoEnZona from cliente
                         WHERE ID = $clientId";

        $result = $this->_readOne($sql_Str);
        $order = $result[0];

		$sql_Str = "Select count(*)as q from rutaclientes
                         WHERE rutaId = $roadId and clienteId = $clientId";

        $result = $this->_readOne($sql_Str);
        if ($result[q] == 0){
      		$sql_Str = "INSERT INTO rutaclientes
						(rutaId, clienteId, orden)
					    VALUES
						($roadId, $clientId, $order)";

            return $this->_executeQuery($sql_Str);
        }else{
      		$sql_Str = "Update rutaclientes
                           Set orden = $orden
                               WHERE rutaId=$roadId and clienteId=$clientId ";
            return $this->_executeQuery($sql_Str);
        }
	}

    function listRoad($where){

		$sql_Str = "SELECT * FROM ruta";

		if (!empty($where)) {
			$sql_Str .=" WHERE $where";
		}
		$sql_Str .=" ORDER BY descripcion";

		$data = $this->_readAll($sql_Str);
		return $data;
	}

    function changePosition($roadId, $clientId, $from, $to){
        $sql="Select clienteId from rutaclientes where orden = $to and rutaId = $roadId";
        $aux = $this->_readOne($sql);
        $idTo=$aux[clienteId];
        $sql="Update rutaclientes set orden = $to where orden = $from and rutaId = $roadId and clienteId = $clientId ";
        $this->_executeQuery($sql);

        if ($idTo!=""){
           $sql="Update rutaclientes set orden = $from where clienteId = $idTo and rutaId = $roadId";
           $this->_executeQuery($sql);
        }
        return;
    }
    
/***********************************************************/
/****************        Importacion       *****************/
/***********************************************************/

    function import($roadName, $orderInRoad, $meterNr, $clientCode, $clientName, $street, $num, $floor, $dept, $zoneName){
        $paramsZone[descripcion] = $zoneName;
        $zone=$this->getZoneByDesc($zoneName);
        if ($zone[ID] == ""){
           $zoneId = $this->addZone($paramsZone);
        }else{
           $zoneId = $zone[ID];
        }

        $paramsClient[nroMedidor] = mysql_real_escape_string($meterNr);
        $paramsClient[calle] = mysql_real_escape_string($street);
        $paramsClient[altura] = mysql_real_escape_string($num);
        $paramsClient[piso] = mysql_real_escape_string($floor);
        $paramsClient[departamento] = mysql_real_escape_string($dept);
        $paramsClient[nombre] = mysql_real_escape_string($clientName);
        $paramsClient[codigo] = mysql_real_escape_string($clientCode);
        $paramsClient[zonaId] = mysql_real_escape_string($zoneId);
        $paramsClient[orden] = mysql_real_escape_string($orderInRoad);
        $clientId = $this->addClient($paramsClient, false);

        $paramsRoad[descripcion] = mysql_real_escape_string($roadName);
        $road=$this->getRoadByDesc($roadName);
        if ($road == null){
           $roadId = $this->addRoad($paramsRoad);
        }else{
           $roadId = $road[ID];
        }

        $this->addClientToRoad($roadId, $clientId, $orderInRoad);
        //echo("Agregar a ruta: $roadId $clientId $orderInRoad");
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
