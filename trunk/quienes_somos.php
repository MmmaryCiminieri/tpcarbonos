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
						  <td height="10" colspan="3" align="left"><span style="font-weight:bold;color:green">Quienes somos:</span><br />
                          <span style="font-weight:normal;color:gray">Pablin escribi!!</span></td>
						</tr>
					  </tbody>
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

