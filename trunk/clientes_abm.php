<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("db/DBManager.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>Sistema para mediciones de Gas - Provincia de San Luis </title>
  <link href="est.css" rel="stylesheet" type="text/css" />
  <style type="text/css"></style>
  <script type="text/javascript">
<!--
function changeMeter(){
      if (document.form.newMeter.checked==1){
          document.form.nroMedidor.style.display= 'block';
          document.form.medidorId.style.display='none';
      }else{
          document.form.medidorId.style.display='block';
          document.form.nroMedidor.style.display='none';
      }

}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
  </script>
</head>

<body onload="MM_preloadImages('images/acptar_1.jpg')">

<table width="937" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="37" colspan="3"><img src="images/fondo_interna.jpg"
        width="938" height="37" /></td>
    </tr>
    <tr>
      <td align="right" background="images/hom_08.png"><img src="images/home_08.jpg" width="6" height="284" /></td>
      <td>
        <table width="937" border="0" align="center" cellpadding="8" cellspacing="1" bgcolor="#EEEEEE">
          <tbody>
            <tr>
              <td width="939" height="285" valign="middle" bgcolor="#FFFFFF">
                  <?
                  $db = new DBManager();
                  $client = $db->getClient($_REQUEST[id]);

                  if ($client[ID]!=""){
                     $title="Edición de cliente";
                  }else{
                     $title="Creación de cliente";
                  }
                  include("header.php");
                  ?>
                <form id="form" name="form" Method="POST" action="clientes_action.php?action=alta">
					<table width="920" border="0" cellspacing="0" cellpadding="1">
					  <tbody>
                          <?
                          if ($client[ID]!=""){ ?>
                             <input name="ID" type="hidden" class="campo" id="ID" value="<?=$client[ID]?>" /><?
                             $address = $db->getAddress($client[direccionId]);
                          }?>
						<tr>
						  <td width="10%" height="10" valign="middle">&nbsp;</td>
						  <td width="15%" align="right" valign="middle" class="titulos" style="padding-right:15px">Nombre:</td>
						  <td width="15%" valign="middle">
                              <input name="nombre" value="<?=$client[nombre]?>" type="input" class="campo" id="nombre" />
						  </td>
						  <td width="20%" valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
						<tr>
						  <td width="10%" height="10" valign="middle">&nbsp;</td>
						  <td width="15%" align="right" valign="middle" class="titulos" style="padding-right:15px">Codigo:</td>
						  <td width="15%" valign="middle">
                              <input name="codigo" value="<?=$client[codigo]?>" type="input" class="campo" id="codigo" />
						  </td>
						  <td width="20%" valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                        <tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Calle:</td>
						  <td valign="middle">
                              <input name="calle" value="<?=$address[calle]?>" type="input" class="campo" id="calle" />
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                        <tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Altura:</td>
						  <td valign="middle">
                              <input name="altura" value="<?=$address[altura]?>" type="input" class="campo" id="altura" />
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                        <tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Piso:</td>
						  <td valign="middle">
                              <input name="piso" value="<?=$address[piso]?>" type="input" class="campo" id="piso" />
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                        <tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Departamento:</td>
						  <td valign="middle" >
                              <input name="departamento" value="<?=$address[departamento]?>" type="input" class="campo" id="departamento" />
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                       	<tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Zona:</td>
						  <td valign="middle" >
                              <select name="zonaId" class="despl" id="zonaId" >
                                  <?php
                                       $zones = $db->listZone();
                                       foreach ($zones as $zone){
                                            if($zone[ID]==$client[zonaId]){
                                                 $selected = "selected";
                                            }else{
                                                 $selected = "";
                                            }
                                            echo "<option value='$zone[ID]' $selected >$zone[descripcion] ";
                                       }
                                  ?>
                                </select>
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
						<tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Orden en zona(solo para informativo):</td>
						  <td valign="middle" >
                              <input name="ordenDeseadoEnZona" value="<?=$client[ordenDeseadoEnZona]?>" type="input" class="campo" id="ordenDeseadoEnZona" />
						  </td>
						  <td valign="middle" align="left">
                              &nbsp;
						  </td>
						</tr>
                        <tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">Medidor:</td>
						  <td valign="middle" style="padding-right:0px">
                              <input type="text" id="nroMedidor" name="nroMedidor" class="campo" style="display:none" >
                              <select name="medidorId" class="despl" id="medidorId" >
                                  <?php
                                       $cliMeter = $db->getMeter($client[medidorId]);
                                       echo "<option value='$cliMeter[ID]' selected>$cliMeter[numero] ";
                                       $meters = $db->listMeterNotInUse();
                                       foreach ($meters as $meter){
                                            echo "<option value='$meter[ID]' >$meter[numero] ";
                                       }
                                  ?>
                                </select>
						  </td>
						  <td>
						      <input type="checkbox" id="newMeter" value="1" onclick="javascript:changeMeter()"> Crear Medidor
                          </td>
						</tr>
						<tr>
						  <td height="10" valign="middle">&nbsp;</td>
						  <td align="right" valign="middle" class="titulos" style="padding-right:15px">&nbsp;</td>
						  <td valign="middle" style="padding-right:0px">&nbsp;</td>
						  <td valign="middle" align="left">&nbsp;</td>
						</tr>
					  </tbody>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="1">
					  <tbody>
						<tr>
						  <td colspan="2"><img src="images/b-separador.gif"	width="76" height="8" /></td>
						</tr>
						<tr>
						  <td colspan="2">
                              <div align="center">
                                   <img src="images/home1_08.jpg" width="749" height="1"/>
                              </div>
                          </td>
						</tr>
						<tr>
                            <td height="45" width="718" align="right">
                                <a href="javascript:form.submit()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen19','','images/acptar_1.jpg',1)">
                                   <img src="images/acptar.jpg" name="Imagen19" width="81" height="24" border="0" id="Imagen19" />
                                </a>&nbsp;&nbsp;
                                <a href="clientes_admin.php">
                                   <img src="images/cancelar.jpg" width="81" height="24" border="0" />
                                 </a>
                            </td>
                            <td width="198" align="center">&nbsp;</td>
						</tr>
						<tr>
						  <td height="35" align="right">&nbsp;</td>
						  <td align="center">&nbsp;</td>
						</tr>
					  </tbody>
				  </table>
				</form>
			</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td align="left" background="images/hom_10.png"><img
        src="images/home_10.jpg" width="9" height="284" /></td>
    </tr>
    <?include("footer.php");?>
  </tbody>
</table>
</body>
</html>
