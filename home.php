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
                <form id="form" name="form">
					<table width="920" border="0" cellspacing="0" cellpadding="1">
					  <tbody>
						<tr>
						  <td colspan="3" align="center" valign="middle" style="color:red;font-weight:bold">
							  <?=$_REQUEST[mess]?>
						  </td>
						</tr>
						<tr>
						  <td height="10" colspan="3" align="center">&nbsp;</td>
						</tr>
					  </tbody>
					</table>
	                <table width="100%" border=0>
                    	<tr>
                        	<td width="80%" >
                        		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="list" >
                        			<tr>
                        				<td width="70%">
											<table width="100%" style="border-top:double;border-bottom:double;" cellspacing="0" cellpadding="0" id="list">
												<tr height="30">
													<td width="2%">&nbsp;</td>
													<td width="38%" align="left" valign="middle" class="titulos" style="padding-right:15px">
													Mercado
													</td>
													<td width="2%" rowspan="80" align="center"><img src="images/barra_v.jpg" width="2" height="100%" /></td>
													<td width="8%" align="center" valign="middle" class="titulos" style="padding-right:15px">
													Cantidad
													</td>
													<td width="2%" rowspan="80" align="center"><img src="images/barra_v.jpg" width="2" height="100%" /></td>
													<td width="8%" align="center" valign="middle" class="titulos" style="padding-right:15px">
													Precio
													</td>
													<td width="2%" rowspan="80" align="center"><img src="images/barra_v.jpg" width="2" height="100%" /></td>
													<td width="8%" align="center" valign="middle" class="titulos" style="padding-right:15px">
													Comm.
													</td>
													<td width="2%" rowspan="80" align="center" id="tdUpdateLine"><img src="images/barra_v.jpg" width="2" height="100%" /></td>
													<td width="8%" align="center" valign="middle" class="titulos" style="padding-right:15px" id="tdUpdate">
													Max.
													</td>
													<td width="2%" rowspan="80" align="center" id="tdUpdateLine"><img src="images/barra_v.jpg" width="2" height="100%" /></td>
													<td width="8%" align="center" valign="middle" class="titulos" style="padding-right:15px" id="tdUpdate">
													Min.
													</td>
												</tr>
												<?php
												$mercados = $db->listMercados();
												foreach ($mercados as $mercado){
												?>
												<tr>
													<td height="20">&nbsp;</td>
													<td align="left" class="tabla"><b><a href="javascript:changeImage();"><?=$mercado[Nombre]?></a></b></td>
													<td align="right" class="tabla"><?=$mercado[Cantidad]?></td>
													<td align="right" class="tabla"><?=$mercado[Precio]?></td>
													<td align="right" class="tabla"><?=$mercado[Comm]?></td>
													<td align="right" class="tabla"><?=$mercado[Max]?></td>
													<td align="right" class="tabla"><?=$mercado[Min]?></td>
												</tr>
												<?
												}
												?>
											</table><!-- Tabla mercados -->
							            </td>
										<td width="30%" align="center" >
											 <input type="image" id="imgMercado" src="images/mercado1.jpg">
										</td>
									</tr>
								</table><!-- Tabla 2 columnas-->
							</td>
                            <td valign="top">
                                <span style="font-weight:bold;color:green">Bonos de Carbono: La mejor inversión del futuro</span><br>
                                <span style="font-weight:normal;color:gray">Según el Protocolo de Kyoto, firmado en 1997 en esa ciudad japonesa, una de las alternativas que tienen los países industrializados y en transición para mermar el daño que provocan al ambiente es financiar proyectos de reducción de emisiones o de baja de carbono en países en desarrollo. Este tipo de iniciativas está inscrito en lo que se llama Mecanismo de Desarrollo Limpio (MDL) y comprende...<a style="font-weight:normal;color:black;font-size:11px" href="http://diariohyips.blogspot.com/2010/05/bonos-de-carbono-la-mejor-inversion-del.html">(mas)</a></span>
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
                            <td colspan="2">
                                <span style="font-weight:bold;color:green">SEIS PASOS</span><br>
                                <span style="font-weight:normal;color:gray">Para obtener los llamados bonos de carbono, conocido por sus siglas en inglés como CER, el proyecto MDL debe seguir un ciclo que consta de seis etapas: diseño, validación-registro, monitoreo, verificación-certificación y finalmente el otorgamiento del certificado con la cantidad de CER</span>
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
                            <td colspan="2">
                                <span style="font-weight:bold;color:green">TU EMPRESA PUEDE</span><br>
                                <span style="font-weight:normal;color:gray">Si consideras que tu empresa puede emitir bonos, te damos las herramientas para que puedas estimar el beneficio y las ganancias por cuidar el planeta. <a href="" style="color:#000000;font-weight:normal;font-size:11px">(ir a calculadora)</a></span>
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
                            <td colspan="2">
                                <span style="font-weight:bold;color:green">INVERTI EN VERDE</span><br>
                                <span style="font-weight:normal;color:gray">Te mostramos los negocios del futuro, sus planes de negocio. Te contamos como invertir bien y mejorar el planeta. Bajo riesgo, alta rentabilidad y tranqulidad sabiendo que estas haciendo algo por las siguientes generaciones.<a href="" style="color:#000000;font-weight:normal;font-size:11px">(ver oportunidades)</a></span>
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

