<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("DBManager.php");
$db = new DBManager();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>C A R B O N O S</title>
  <link href="est.css" rel="stylesheet" type="text/css" />
  <style type="text/css"></style>
  <script type="text/javascript">
<!--
var selImage=1;
function changeImage(){
     if (selImage==2){
          document.getElementById("imgMercado").src="images/mercado1.jpg";
          selImage=1;
     }else{
          document.getElementById("imgMercado").src="images/mercado2.jpg";
          selImage=2;
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

<body onload="MM_preloadImages('images/eliminar_1.jpg','images/editar_1.jpg','images/acptar_1.jpg')">
<table width="937" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="37" colspan="3"><img src="images/fondo_interna.jpg"
        width="938" height="37" /></td>
    </tr>
    <tr>
      <td align="right" background="images/hom_08.png"><img
        src="images/home_08.jpg" width="6" height="284" /></td>
      <td>
        <table width="937" border="0" align="center" cellpadding="8" cellspacing="1" bgcolor="#EEEEEE">
          <tbody>
            <tr>
              <td width="939" height="285" valign="top" bgcolor="#FFFFFF">
                <?php
                include("header.php");
                include("menu.php");
                ?>
                <form id="form" name="form" action="register_action.php">
					<table width="920" border="0" cellspacing="0" cellpadding="1">
					  <tbody>
						<tr>
						  <td colspan="3" align="center" valign="middle" style="color:red;font-weight:bold">
							  <?=$_REQUEST[mess]?>
						  </td>
						</tr>
					  </tbody>
					</table>
                    <table width="100%" border=0 align="center">
                        <tr>
                            <td colspan="2" height="40">
                                <table width="90%" border=0 align="center">
                        <tr>
                            <td colspan="2" height="40">
                                <span style="font-weight:bold;color:green">DATOS EMPRESA</span><br>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Razón Social</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="razonsocial" name="razonsocial" size="100" maxlength="150" value="<?=$_SESSION[register][razonsocial]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">País</span><br>
                            </td>
                            <td width="80%" align="left">
                                <select id="idpais" name="idpais" style="width:200px;">
                                        <? foreach($db->listPaises() as $pais){ ?>
                                           <? if ($_SESSION[register][idpais] == $pais[id]){?>
                                                 <option selected value="<?=$pais[id]?>"><?=$pais[nombre] ?>
                                           <? }else{?>
                                                 <option value="<?=$pais[id]?>"><?=$pais[nombre] ?>
                                           <? }?>
                                        <?}?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Dirección</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="direccion" name="direccion" size="100" maxlength="150" value="<?=$_SESSION[register][direccion]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Teléfono</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="telefono" name="telefono" size="100" maxlength="100" value="<?=$_SESSION[register][telefono]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Código inscripción tributaria</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="codigovalidacion" name="codigovalidacion" size="50" maxlength="50" value="<?=$_SESSION[register][codigovalidacion]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Sitio web</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="web" name="web" size="100" maxlength="100" value="<?=$_SESSION[register][web]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Descripción</span><br>
                                (Una buena descripción de su empresa atraerá mas inversores para sus bonos)
                            </td>
                            <td width="80%" align="left">
                                <textarea id="descripcion" name="descripcion" cols="75" rows="4" onkeydown="if(this.value.length >= 500){ alert('Has superado el tamaño máximo permitido (500 caracteres)'); return false; }; cant.value = cant.value -1 "><?=$_SESSION[register][descripcion]?></textarea>
                            </td>
                        </tr>
                        <tr>
							<td colspan="2"><img src="images/b-separador.gif" width="76" height="8" /></td>
						</tr>
                        <tr>
							<td colspan="2"><div align="center"> <img src="images/home1_08.jpg" width="749" height="1"/></div></td>
						</tr>
                        <tr>
                            <td colspan="2" height="40">
                                <span style="font-weight:bold;color:green">USUARIO</span><br>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Nombre</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="nombre" name="nombre" size="100" maxlength="100" value="<?=$_SESSION[register][nombre]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Apellido</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="apellido" name="apellido" size="100" maxlength="100" value="<?=$_SESSION[register][apellido]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Contraseña</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="password" id="password" name="password" size="100" maxlength="100"  />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Repetir Contraseña</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="password" id="password2" name="password2" size="100" maxlength="100" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Nick</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="nick" name="nick" size="50" maxlength="50" value="<?=$_SESSION[register][nick]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">E-mail</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="mail" name="mail" size="100" maxlength="100" value="<?=$_SESSION[register][mail]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <span style="font-weight:bold;">Documento Identidad</span><br>
                            </td>
                            <td width="80%" align="left">
                                <input type="text" id="documento" name="documento" size="20" maxlength="20" value="<?=$_SESSION[register][documento]?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <input type="submit" id="btnSubmit" name="btnSubmit"  width="20" value="enviar" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        </table
                        </td>
                        </tr>
                        <tr>
							<td colspan="2"><img src="images/b-separador.gif" width="76" height="8" /></td>
						</tr>
                        <tr>
							<td colspan="2"><div align="center"> <img src="images/home1_08.jpg" width="749" height="1"/></div></td>
						</tr>
                        <tr>
							<td colspan="2"><img src="images/b-separador.gif" width="76" height="8" /></td>
						</tr>
						<tr>
                            <td>
                                <table width="100%">
                                       <tr>
                                           <td height="40" width="5%">
                                               <img src="images/carbonos2.jpg" width="40" height="50" />
                                           </td>
                                           <td valign="bottom" height="40" align="left" width="95%">
                                               <span style="color:gray;font-weight:normal;font-size:18px">Cuida el planeta, Gana dinero.</span>
                                           </td>
                                       </tr>
                                </table
                            </td>
                            <td align="right">
                                <img src="images/iso2.jpg" width="93" height="106" border="0" />
                            </td>
						</tr>
					</table><!-- Tabla 2 columnas-->
				</form>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
      <td align="left" background="images/hom_10.png"><img
        src="images/home_10.jpg" width="9" height="284" /></td>
    </tr>

    <?
    include("footer.php");
    ?>
  </tbody>
</table>
</body>
</html>

