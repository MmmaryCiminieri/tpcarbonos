<?Php
ob_start();
session_start();
ini_set("display_errors", 0);
if ($_REQUEST[action]=="logout"){
   $_SESSION[user]=null;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>Sistema para mediciones de Gas - Provincia de San Luis </title>
  <style type="text/css"></style>
  <script type="text/javascript">
<!--
function submitForm(){
     document.forms[0].submit();
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
<link href="est.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('images/acptar_1.jpg')">

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
              <td width="939" height="285" valign="middle" bgcolor="#FFFFFF">
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td align="center">
                        <div align="center">
                             <img src="images/carbonos.jpg"  width="184" height="64" border="0"/>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td><img src="images/b-separador.gif" width="76" height="8" /></td>
                    </tr>
                  </tbody>
                </table>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td>
                        <div align="center">
                        <img src="images/home1_08.jpg" width="749" height="1" /></div>
                      </td>
                    </tr>
                    <tr>
                      <td height="40" width="738" align="center">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <form method="POST" action="login_action.php" name="form" id="form">
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tr>
                    <td width="251" height="30" valign="middle">&nbsp;</td>
                    <td width="165" align="right" valign="middle" class="titulos" style="padding-right:15px">Usuario:</td>
                    <td width="498" valign="middle" style="padding-right:30px">
                        <input name="nick" type="text" class="campo" id="nick" />
                    </td>
                  </tr>
                  <tbody>
                    <tr>
                      <td height="30" valign="middle">&nbsp;</td>
                      <td align="right" valign="middle" class="titulos" style="padding-right:15px">Contrase&ntilde;a:</td>
                      <td valign="middle" style="padding-right:30px">
                          <input name="password" type="password" class="campo" id="password" />
                      </td>
                    </tr>
                  </tbody>
                  <tbody>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="titulos" style="padding-right:15px;color:red;font-weight:bold;">
                      <?=$_REQUEST[error]?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p>&nbsp;</p>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td colspan="2"><img src="images/b-separador.gif" width="76" height="8" /></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div align="center">
                           <img src="images/home1_08.jpg" width="749" height="1" />
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td height="55" width="595" align="right">
                          <a href="javascript:submitForm()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen19','','images/acptar_1.jpg',1)">
                             <img src="images/acptar.jpg" alt="" name="Imagen19" width="81" height="24" border="0" id="Imagen19" />
                          </a>&nbsp;&nbsp;
                          <a href="login.php">
                             <img src="images/cancelar.jpg" border="0" />
                          </a>
                      </td>
                      <td width="321" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="55" align="right">&nbsp;</td>
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
    <tr>
      <td> </td>
      <td valign="middle" style="background-image:url(images/home_17.jpg); background-repeat:no-repeat">
        <div align="center">
        <p></p>
        <p class="footer">&nbsp;</p>
        <p class="footer">&copy; CARBONOS S.A. 2011-2012 - BonoVentas v1.0</p>
        <p class="footer">&nbsp;</p>
        </div>
      </td>
      <td> </td>
    </tr>
  </tbody>
</table>
</body>
</html>
