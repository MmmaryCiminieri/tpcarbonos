<?
ob_start();
session_start();
ini_set("display_errors", 0);
if ($_SESSION[user][ID]==""){

}
?>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                        <td align="left" colspan=3>
                            <div align="left">
                                 <a href="home.php" border="0" alt="Español"><img src="images/espanol.jpg" border="0" width="25" height="18" /></a>
                                 <a href="javascript:alert('funcion no implementada aun');" alt="Ingles"><img src="images/ingles.jpg" border="0" width="25" height="18" /></a>
                                 <a href="javascript:alert('funcion no implementada aun');"  alt="Aleman"><img src="images/aleman.jpg" border="0" width="25" height="18" /></a>
                                 <a href="javascript:alert('funcion no implementada aun');" alt="Portugues"><img src="images/portugues.jpg" border="0" width="25" height="18" /></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">
                            &nbsp;
                        </td>
                        <td width="60%" align="center">
                            <div align="center">
                                 <a href="home.php"><img src="images/carbonos.jpg" width="184" height="64" border="0" /></a>
                            </div>
                        </td>
                        <td width="20%">
                            &nbsp;
                        </td>
                    </tr>
                  </tbody>
                </table>
                <table width="920" border="0" cellspacing="0" cellpadding="1">
                  <tbody>
                    <tr>
                      <td colspan="2" align="left">
                          &nbsp;
                      </td>
                    </tr>
                    <tr>
                        <? if ($_SESSION[user][ID]!=""){ ?>
                      <td align="right" width="890">
                          <span style="font-weight:bold;color:#909090;" >
                          <?=$_SESSION[user][nombre]." ".$_SESSION[user][apellido]?></span>&nbsp;&nbsp;
                      </td>
                      <td align="left" width="30px">
                          <a href="login.php?action=logout" title="Cerrar sesión" ><img src="images/house_go.png" border="0" style="padding-right:15px"></a>
                      </td>
                      <?}else{?>
                      <td align="right" width="870">
                          <a href="login.php" title="Ingresar al Sistema" ><span style="color:green;font-weight:normal;font-size:10px">Ingresar</span</a>&nbsp;&nbsp;&nbsp;
                      </td>
                      <td align="right" width="50px">
                          <a href="register.php" title="Ingresar al Sistema" ><span style="color:green;font-weight:normal;font-size:10px">Registrarse</span></a>
                      </td>
                      <?}?>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <img src="images/b-separador.gif" width="76" height="8" />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div align="center">
                             <img src="images/home1_08.jpg" width="749" height="1" />
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="5" width="738" align="center">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>

