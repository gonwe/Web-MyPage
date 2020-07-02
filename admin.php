<?php require_once('Connections/conn.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "guest.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_POST['delsure']))) {
  $deleteSQL = sprintf("DELETE FROM guest WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());

  $deleteGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE guest SET name=%s, message=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['message'], "text"),
                       GetSQLValueString($_POST['submit'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_guestAdmin = 5;
$pageNum_guestAdmin = 0;
if (isset($_GET['pageNum_guestAdmin'])) {
  $pageNum_guestAdmin = $_GET['pageNum_guestAdmin'];
}
$startRow_guestAdmin = $pageNum_guestAdmin * $maxRows_guestAdmin;

mysql_select_db($database_conn, $conn);
$query_guestAdmin = "SELECT * FROM guest";
$query_limit_guestAdmin = sprintf("%s LIMIT %d, %d", $query_guestAdmin, $startRow_guestAdmin, $maxRows_guestAdmin);
$guestAdmin = mysql_query($query_limit_guestAdmin, $conn) or die(mysql_error());
$row_guestAdmin = mysql_fetch_assoc($guestAdmin);

if (isset($_GET['totalRows_guestAdmin'])) {
  $totalRows_guestAdmin = $_GET['totalRows_guestAdmin'];
} else {
  $all_guestAdmin = mysql_query($query_guestAdmin);
  $totalRows_guestAdmin = mysql_num_rows($all_guestAdmin);
}
$totalPages_guestAdmin = ceil($totalRows_guestAdmin/$maxRows_guestAdmin)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>清风自鸣-管理页面</title>
<style type="text/css">
	
	*{margin: 0px;padding: 0px;font-family: "微软雅黑";}
body{
	background:#F5F5F5;
}
a{
	text-decoration: none;
	color:#000;
	}
.clear{ 
		clear:both
		} 		
a:hover{ 
		color: #FFCC99;
		}
		

			
#apDiv1 {
	background: #313A44;
	background-size:100% auto;
	width: 1600px;
	height: 260px;
	margin: 0 auto;
	
}

#navbar {
		width: 1200px;
		height: 64px;
		background: #313A44;
		margin: 0 auto;
		/*position:fixed;*/
		
}		

#navbar .logo{
		width:220px; 
		height:40px; 
		float:left ;
		padding-top: 20px;
		padding-left: 20px;
		}
#navbar .menu{
		width: 600px;
		height: 64px;
		margin: 0 auto;
		float: right;
		padding-top: 1px;
		
		}
		
#navbar .menu  ul a {
 	 	text-align: center;
  		text-decoration: none;
		letter-spacing:2px;
		text-decoration: none;
		}	
				
#navbar .menu ul{
		list-style-type: none;/*去掉圆点*/
		float: right;
	
		}
#navbar .menu li{
		float: left;
		width: 60px;
		height: 40px;
  		line-height:34px;
		text-align:center;
		font-size: 16px;
		font-family: "微软雅黑";
		position: relative;
		color: #FFFFFF;
		margin-top: 20px;
		margin-right: 30px;
		}		
#navbar .menu li:hover {
		color:#219FF0;
		border-bottom: 1px solid #219FF0;
		
		}	

#navbar .menu .jihuo {
		color:#219FF0;
		border-bottom: 1.5px solid #219FF0;
		}
#apDiv1 .slogan{
		width: 1200px;	
		height: 200px;
		
		color: #FFFFFF;
		text-align: center;
		letter-spacing: 3px;
		line-height:50px;
		margin: 0 auto;
		margin-top:40px;
		}
#apDiv1 .slogan h1{
	font-size: 30px;
	}
	
#apDiv1 .slogan span{
	color:#219FF0;
	font-size: 30px;
		
		}
#apDiv1 .slogan p{
		font-size:16px;
		}	
					
#Content {
	margin: 0 auto;
	width: 1600px;
	height: 100%;
	background:#FAFCF5;
	}
	
#apDiv2 {
	width: 1200px;
	height: 100%;
	margin: 0 auto;
	padding-top: 1px;
	padding-bottom: 50px;
	}
		


#apDiv2 .menu{
	
	width: 300px;
	height: 40px;
	margin: 0 auto;
	padding-bottom: 20px;
}
#apDiv2 .menu li{
	list-style-type: none;/*去掉圆点*/
	margin: 0 auto;
	width: 150px;
	height: 60px;
	text-align: center;
	margin-top: 20px;
	color:#F7F7F7;
	font-size:22px;
	line-height: 60px;	
	background-color: #219FF0;
	border-radius:100px;  
}
#apDiv2 .menu li:hover {
		color:#F7F7F7;
		background-color: #99CC99;
		}
#apDiv2 .menu p{
	float:left;
	width: 80px;
	height: 30px;
	margin-left: 70px;
	text-align: center;
	margin-top: 10px;
	color:#F7F7F7;
	font-size:16px;
	line-height: 30px;
	background-color:#66CCCC;
}
#apDiv2 .menu p:hover {
		color:#F7F7F7;
		background-color: #99CC99;
		}

input[type="text"], #apDiv2 .post input[type="email"], textarea, #apDiv2 .post select {
	color: #888;
	width: 70%;
	border: 1px solid #C5E2FF;
	background: #FBFBFB;
	outline: 0;
	-webkit-box-shadow:inset 0px 1px 6px #ECF3F5;
	box-shadow: inset 0px 1px 6px #ECF3F5;
	font: 200 12px/25px Arial, Helvetica, sans-serif;
	height: 25px;
	line-height:15px;
	margin: 2px 2px 6px 0px;
	margin-left: 20px;
}
textarea{
	height:60px;
	width: 90%;
}

#guest .submit{
	float:left;
	width:48px;
	height:30px;
	margin-left:8px;
	background: #66C1E4;
	border: none;
	color: #FFF;
	box-shadow: 1px 1px 1px #4C6E91;

}
#guest .submit:hover{
	background: #3EB1DD;
}		
#guest {
	margin: 0 auto;
	width: 800px;
	height: 180px;
	border-radius: 10px;
	background-image: url(images/guestbg.png);
	background-size:100% auto;
	background-repeat:no-repeat;
	padding-top: 5px;
	margin-bottom: 40px;
	
}
#guest .title{
	width: 180px;
	height: 35px;
	float:left;
	font-size: 18px;
	margin-left: 10px;
	padding-left: 80px;
	line-height: 35px;
	color: #666666;

}
#guest .title2{
	width: 180px;
	height: 35px;
	float:right;
	font-size: 18px;
	padding-right:88px;
	line-height: 35px;
	color: #666666;
	
}

#guest .form{
	color: #999999;
	width: 220px;
	height: 50px;
	float: left;
	font-size: 14px;
	margin-left: 10px;
	padding-left: 20px;
	font-style:italic;

}
#guest .time{
	color: #999999;
	width: 190px;
	height: 50px;
	float: right;
	font-size: 14px;
	margin-left: 10px;
	padding-left: 20px;

}
#apDiv5 {
	width: 1600px;
	height: 220px;
	background:#282C35;
	margin: 0 auto;
	color: #9E9E9E;
	text-align: center;
	font-size: 12px;
	
}
#apDiv5 .bottom{
		width: 1000px;
		height: 130px;
		margin: 0 auto;
		margin-bottom:20px;
		line-height: 50px;
		text-align: center;
		border-bottom: 0.0625rem solid #4C4C4C;
}
#apDiv5 .bottom li{
		list-style-type: none;/*去掉圆点*/
		width: 250px;
		height: 90px;
		font-size: 14px;
		margin-top: 15px;
		float: left;
		position: relative;
		color: #FFFFFF;
		border-right: 1px solid #4C4C4C;

		}
#apDiv5 .bottom img{
		margin: 0 auto;
		width:90px;
		height:90px; 
		padding-left: 80px;
		}		
#apDiv5 .bottom .liother{	
		width: 450px;
		border:none;
		}	
#apDiv5 .bottom p{
		margin-left: 20px;
		line-height: 20px;
		font-size: 13px;
		letter-spacing: 1.5px;
		color: #9E9E9E;
}					
</style>
</head>

<body>

<div id="apDiv1">

	<div id="navbar">
	<img src="images/logo.png" class="logo" />
		
	 
	  <div class="menu">
	  	<ul>
	  	<a href="./index.php"><li>首页</li></a>
	    <a href="./coding.php"><li>编程</li></a>
	    <a href="./tour.php"><li>旅行</li></a>
		<a href="./about.php"><li>关于</li></a>
	    <a href="./guest.php"><li class="jihuo">寄语</li></a>
	  		</ul>	
	
		</div>
	</div>
	<div class="clear"></div>   
	<div class="slogan">
		<h1>GUESTB<span>O</span>OK</h1>
		<p style="letter-spacing: 6px;">这世间所有美好都值得最真挚的祝福</p>
	</div>
</div>
<div class="clear"></div>   



<div id="Content">
		<div id="apDiv2">
		<div class="menu">
		<a href="./guest.php"><p>留言预览</p></a>
		<a href="<?php echo $logoutAction ?>"><p style="margin-left: 0px;background:#339999;">注销管理</p></a>
		</div>
		
		
		
		<div class="clear"></div>  
		<?php do { ?>
	    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="guest">
		    <div class="title">
		      <input name="name" type="text" id="name" value="<?php echo $row_guestAdmin['name']; ?>"/>
		  
	        </div>
		    <div class="title2">
            
            <input class="submit" name="submit" value=" <?php echo $row_guestAdmin['id']; ?>"/>
            
		      <input type="submit" class="submit" name="submit" value="更新" style="background:#00a3eb;"/>
              
		 
              <a href="delete.php?id=<?php echo $row_guestAdmin['id']; ?>" /><input type="button" class="submit" name="delsure" value="删除" style="background:red;" /> </a>
		   </div>
            <div class="clear"></div>  
		    
		    <textarea id="message" name="message" ><?php echo $row_guestAdmin['message']; ?></textarea>
		    
		    
		    <div class="form">
	        来自：<?php echo $row_guestAdmin['email']; ?></div>
		    <div class="time"><?php echo $row_guestAdmin['time']; ?></div>
		    <input type="hidden" name="MM_update" value="form1" />
	    </form>
		  <?php } while ($row_guestAdmin = mysql_fetch_assoc($guestAdmin)); ?>
		</div>
  </div>	
</div>



<div class="clear"></div>   
<div id="apDiv5">
	<div class="bottom">
		<ul>
			<li><img src="images/wx.png" /></li>
			<li>联系我
				<p>Email:malman@foxmail.com </p>
				<p>QQ:1358254691</p>
			</li>
					
			<li class="liother">感谢光临
				<p>这是我的个人网站、会分享自己的有些日常，关于编程、计算机相关的任何内容，希望可以给来到这儿的人有所帮助.…</p>
			</li>
			
		</ul>
	</div>
	<p>Copyright ©0204龚卫.All Rights Reserved. 冀ICP备123456789号</p>
</div>

</body>
</html>
<?php
mysql_free_result($guestAdmin);
?>
