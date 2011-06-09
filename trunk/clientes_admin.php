<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
require_once("db/DBManager.php");
$db = new DBManager();
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

function borrar(id){
    if (confirm('Seguro desea eliminar el registro?')){
         window.location = "clientes_action.php?action=baja&ID=" + id;
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
      <td height="37" colspan="3">
          <img src="images/fondo_interna.jpg" width="938" height="37" />
      </td>
    </tr>
    <tr>
      <td align="right" background="images/hom_08.png">
          <img src="images/home_08.jpg" width="6" height="284" />
      </td>
      <td>
        <table width="937" border="0" align="center" cellpadding="8" cellspacing="1" bgcolor="#EEEEEE">
          <tbody>
            <tr>
              <td width="939" height="285" valign="top" bgcolor="#FFFFFF">
                <?php
                $title = "Administración de clientes";
                include("header.php");
                include("menu_gestion.php");
                $clientNameFilter=$_REQUEST[clientNameFilter];
                $zoneNameFilter=$_REQUEST[zoneNameFilter];
                $meterFrom=$_REQUEST[meterFrom];
                $meterTo=$_REQUEST[meterTo];
                $queryStringFilter = "&zoneNameFilter=$zoneNameFilter&clientNameFilter=$clientNameFilter&meterFrom=$meterFrom&meterTo=$meterTo";

                //Filtros
                $filter = "";
                if ($clientNameFilter != ""){
                  $filter .= " c.nombre like '$clientNameFilter' and ";
                }
                if ($zoneNameFilter != ""){
                  $filter .= " z.descripcion like '$zoneNameFilter' and ";
                }
                if ($meterFrom != ""){
                  $filter .= " m.numero >= '$meterFrom' and ";
                }
                if ($meterTo != ""){
                  $filter .= " m.numero <= '$meterTo' and ";
                }
                $filter = $filter . " 1=1";

                //Paginado
                $qClients = $db->countAllClients($filter);
                $qRecords = 10;
                $last=intval($qClients/$qRecords);
                $from = $_REQUEST[from];
                if ($from == 0){
                     $prev = 0;
                }else{
                   $prev = $from - 1;
                }
                if ($from < $last){
                   $next = $from + 1;
                }else{
                   $next = $last;
                }
                
                $lastStr = ($from*$qRecords)+$qRecords;
                if ($lastStr > $qClients){
                   $lastStr = $qClients;
                }
                $qRecordsInPage = $lastStr - ($from*$qRecords);
                $pixeles = 60 * $qRecordsInPage;
                $pixeles = $pixeles."px"
                
                ?>
                <script>
                        document.getElementById('clientes').style.fontWeight='Bold';
                </script>

                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td colspan="2" height="10" align="left" valign="middle" style="font-weight:bold;color:gray;padding-left:40px">
                          Filtros
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" width="100%" height="10" align="center" valign="middle">
                          <form method="POST" action="clientes_admin.php" id="formFiltro">
                                <table>
                                       <tr>
                                           <td style="font-weight:bold">
                                               Nombre Cliente
                                           </td>
                                           <td colspan="4">
                                              <input id="clientNameFilter" name="clientNameFilter" type="text" size="42" value="<?=$clientNameFilter?>">&nbsp;(wildcard %)
                                           </td>
                                       </tr>
                                       <tr>
                                           <td style="font-weight:bold">
                                               Zona
                                           </td>
                                           <td colspan="4">
                                              <input id="zoneNameFilter" name="zoneNameFilter" type="text" size="42" value="<?=$zoneNameFilter?>">&nbsp;(wildcard %)
                                           </td>
                                       </tr>
                                       <tr>
                                           <td style="font-weight:bold">
                                               Medidor desde
                                           </td>
                                           <td>
                                              <input id="meterFrom" name="meterFrom"  type="text" size="13" value="<?=$meterFrom?>">
                                           </td>
                                           <td width="40" style="font-weight:bold">
                                               &nbsp;
                                           </td>
                                           <td style="font-weight:bold">
                                               Medidor hasta
                                           </td>
                                           <td>
                                              <input id="meterTo" name="meterTo" type="text" size="13" value="<?=$meterTo?>" >
                                           </td>
                                       </tr>
                                       <tr>
                                           <td colspan="5" align="right">
                                               <input type="submit" value="filtrar">
                                           </td>
                                       </tr>
                                </table>
                          </form>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10" align="center" valign="middle">
                          <img src="images/home1_08.jpg" width="749" height="1" />
                      </td>
                    </tr>
                    <tr>
                      <td height="10" colspan="3" align="center">
                           <table width="95%">
                                   <tr>
                                      <td width="80%" align="right" valign="middle">
                                          &nbsp;
                                      </td>
									  <td width="10%" align="right" valign="middle">
										  <img src="images/Excel.png" height="30" width="30" title="Exportar clientes a CSV para utilizar con Excel." onClick="javascript:window.open('clientes_exportar_csv.php?a=1<?=$queryStringFilter?>','mywindow','width=800,height=500,toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');" style="font-size:10px;font-weight:bold;color:darkblue;background:transparent;border-style:solid;border-width:0px;cursor:hand;" />
									  </td>
									  <td width="10%" align="right" valign="middle">
										  <img src="images/print.png" height="30" width="30" title="Imprimir clientes filtrados." onClick="javascript:window.open('clientes_imprimir.php?a=1<?=$queryStringFilter?>','mywindow','width=900,height=500,toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');" style="font-size:10px;font-weight:bold;color:darkblue;background:transparent;border-style:solid;border-width:0px;cursor:hand;" />
									  </td>
                                   </tr>
                            </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10" align="center" valign="middle">
                          <img src="images/home1_08.jpg" width="749" height="1" />
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td width="80%" height="10" align="left" valign="middle">
                          <img src="images/b-separador.gif" width="76" height="8" />
                          <span style="color:red;font-weight:bold;">
                                <?=$_REQUEST[mess]?>
                          </span>
                      </td>
                      <td width="20%" align="left" valign="middle">
                          <a href="clientes_abm.php" id="newAction" name="ok">
                             <img src="images/nuevo.jpg" width="81" height="24" border="0" />
                          </a>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" colspan="3" align="center">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <table width="95%" border="0" cellspacing="0" cellpadding="0" id="list">
                  <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="12%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Código&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="14%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Nombre&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="14%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Dirección&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="12%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Zona&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="5%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Orden deseado&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="9%" align="left" valign="top" class="titulos" style="padding-right:15px">
                        Medidor&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="12%" align="center" valign="top" class="titulos" style="padding-right:0px">
                        Estado Medidor
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" /></td>
                    <td width="11%" align="center" valign="top" class="titulos" style="padding-right:0px" id="tdUpdate">
                        Editar&nbsp;
                    </td>
                    <td width="1%" rowspan="22" align="center"><img src="images/barra_v.jpg" width="2" height="<?=$pixeles?>" id="tdline" /></td>
                    <td width="8%" align="center" valign="top" class="titulos" style="padding-right:0px" id="tdDelete">
                        Eliminar&nbsp;
                    </td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                    <td align="left" valign="top" class="titulos" style="padding-right:15px">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <?php

                  //datos
                  $clients = $db->listClient($from, $qRecords, $filter,"");
                  foreach ($clients as $client){
                    $meter=$db->getMeter($client[medidorId]);
                    $state=$db->getMeterState($meter[estadoMedidorId]);
                    if ($state[funciona]==0){
                          $image = "images/red.png";
                    }else{
                          $image = "images/green.png";
                    }
                    ?>
                    <tr>
                        <td height="30">&nbsp;</td>
                        <td align="left" valign="top" class="tabla"><?=$client[codigo] ?></td>
                        <td align="left" valign="top" class="tabla"><?=$client[nombre] ?></td>
                        <td align="left" valign="top" class="tabla"><?=$client[direccionStr] ?></td>
                        <td align="left" valign="top" class="tabla"><?=$client[nombreZona] ?></td>
                        <td align="left" valign="top" class="tabla"><?=$client[ordenDeseadoEnZona] ?></td>
                        <td align="left" valign="top" class="tabla"><a href="medidor_abm.php?nroMedidor=<?=$client[nroMedidor]?>"><?=$client[nroMedidor] ?></a></td>
                        <td align="center" valign="top" class="tabla"><img src="<?=$image?>" title="<?=$state[descripcion]?>" width="20px" height="20px"></td>
                        <td height="30" align="center" valign="top" class="tabla">
                            <a href="clientes_abm.php?id=<?=$client[ID]?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen29','','images/editar_1.jpg',1)" id="updateAction">
                               <img src="images/editar.jpg" alt="" name="Imagen29" width="65" height="21" border="0" id="Imagen29" />
                            </a>
                        </td>
                        <td height="30" align="center" valign="top" class="tabla">
                            <a href="javascript:borrar(<?=$client[ID]?>)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen24','','images/eliminar_1.jpg',1)" id="deleteAction">
                               <img src="images/eliminar.jpg" alt="" name="Imagen24" width="26" height="21" border="0" id="Imagen24" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="16">
                         &nbsp;
                        </td>
                    </tr>
                  <?
                  }
                  ?>
                  <tr>
                    <td height="30">&nbsp;</td>
                    <td align="left" valign="top" class="tabla">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="left" valign="top" class="tabla">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td height="30" align="left" class="tabla">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td height="30" align="left" class="tabla">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" colspan="16" align="center" >
                        <table width="100%" border="0">
                               <tr>
                                   <td align="right" width="40%">
                                       <a href="clientes_admin.php?from=0<?=$queryStringFilter?>">primero</a>
                                   </td>
                                   <td align="right" width="5%">
                                       <a href="clientes_admin.php?from=<?=($prev.$queryStringFilter)?>"><<</a>
                                   </td>
                                   <td width="10%">
                                       &nbsp;...&nbsp;
                                   </td>
                                   <td align="left" width="5%">
                                       <a href="clientes_admin.php?from=<?=($next.$queryStringFilter)?>">>></a>
                                   </td>
                                   <td align="left" width="40%">
                                       <a href="clientes_admin.php?from=<?=$last.$queryStringFilter?>">último</a>
                                   </td>
                               </tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="30" colspan="16" align="center" >
                        <span style="color:#999999;">
                        [ registros <?=$from*$qRecords?> al <?=$lastStr?>  de un total de <?= $qClients ?> ]
                        </span>
                    </td>
                  </tr>
                </table>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td colspan="2"><img src="images/b-separador.gif"
                        width="76" height="8" /></td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="center"> <img src="images/home1_08.jpg" width="749" height="1"/></div></td>
                    </tr>
                    <tr>
                      <td height="55" align="right">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td align="left" background="images/hom_10.png">
          <img src="images/home_10.jpg" width="9" height="284" />
      </td>
    </tr>
    <?include("footer.php");?>
  </tbody>
</table>
</body>
</html>

<? if (!$db->havePermissionByWinName("alta",$_SESSION[user][ID],"Clientes")){ ?>
      <script language="javascript">
              document.getElementById('newAction').style.visibility = "hidden";
      </script>
<? } ?>
<? if (!$db->havePermissionByWinName("baja",$_SESSION[user][ID],"Clientes")){ ?>
      <script language="javascript">
          document.getElementById('tdDelete').style.display = "none";
          var collection = document.getElementsByTagName('A');
          for (var x=0; x< collection.length; x++) {
            if (collection[x].id.indexOf("deleteAction")>=0){
                   collection[x].style.visibility = "hidden";
            }
          }
          document.getElementById('list').style.marginLeft += "50px";
      </script>
<? } ?>
<? if (!$db->havePermissionByWinName("modificacion",$_SESSION[user][ID],"Clientes")){ ?>
      <script language="javascript">
          var collection = document.getElementsByTagName('A');
          for (var x=0; x< collection.length; x++) {
            if (collection[x].id.indexOf("updateAction")>=0){
                   collection[x].style.visibility = "hidden";
            }
          }
          document.getElementById('list').style.marginLeft = "50px";
          document.getElementById('tdUpdate').style.visibility="hidden";
          document.getElementById('tdline').style.visibility="hidden";
      </script>
<? } ?>
