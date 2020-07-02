<?php require_once('Connections/conn.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO guest (name, phone, email, message) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['message'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "guest.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_postGuest = "SELECT * FROM guest";
$postGuest = mysql_query($query_postGuest, $conn) or die(mysql_error());
$row_postGuest = mysql_fetch_assoc($postGuest);
$totalRows_postGuest = mysql_num_rows($postGuest);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>清风自鸣-填写留言</title>
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
		
/*--留言信息--*/				
#apDiv2 .post {
	margin: 0 auto;
	height: 500px;
    margin-left:auto;
	margin-right:auto;
	margin-top: 30px;
	max-width: 800px;
	background: url(images/postbg.png);
	background-size:100% auto;
	background-repeat:no-repeat;
	font: 12px Arial, Helvetica, sans-serif;
	color: #666;
	//border: 3px solid #000099;
}

#apDiv2 .post p{
	float:left;
	width: 80px;
	height: 30px;
	margin-left: 150px;
	text-align: center;
	margin-bottom: 25px;
	color:#707070;
	line-height: 30px;	
}
#apDiv2 .post p:hover {
		color:#219FF0;
		}
		
#apDiv2 .post label>span {
	float: left;
	margin-top: 10px;
	color: #5E5E5E;
}
#apDiv2 .post label {
	display: block;
	margin: 0px 0px 5px;
}
#apDiv2 .post label>span {
	float: left;
	width: 20%;
	text-align: right;
	padding-right: 15px;
	margin-top: 10px;
	font-weight: bold;
}
#apDiv2 .post input[type="text"], #apDiv2 .post input[type="email"], #apDiv2 .post textarea, #apDiv2 .post select {
	color: #888;
	width: 70%;
	padding: 0px 0px 0px 5px;
	border: 1px solid #C5E2FF;
	background: #FBFBFB;
	outline: 0;
	-webkit-box-shadow:inset 0px 1px 6px #ECF3F5;
	box-shadow: inset 0px 1px 6px #ECF3F5;
	font: 200 12px/25px Arial, Helvetica, sans-serif;
	height: 30px;
	line-height:15px;
	margin: 2px 6px 16px 0px;
}
#apDiv2 .post textarea{
	height:100px;
	padding: 5px 0px 0px 5px;
	width: 70%;
}
#apDiv2 .post select {
	background: #fbfbfb url('down-arrow.png') no-repeat right;
	background: #fbfbfb url('down-arrow.png') no-repeat right;
	appearance:none;
	-webkit-appearance:none;
	-moz-appearance: none;
	text-indent: 0.01px;
	text-overflow: '';
	width: 70%;
}
#apDiv2 .post .submit{
	padding: 10px 30px 10px 30px;
	background: #66C1E4;
	border: none;
	color: #FFF;
	box-shadow: 1px 1px 1px #4C6E91;
	-webkit-box-shadow: 1px 1px 1px #4C6E91;
	-moz-box-shadow: 1px 1px 1px #4C6E91;
	text-shadow: 1px 1px 1px #5079A3;

}
#apDiv2 .post .submit:hover{
	background: #3EB1DD;
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
		
		<form name="form" action="<?php echo $editFormAction; ?>" method="POST" class="post">
				
				<a href="./login.php">
				
				<p>留言管理</p></a>
				<a href="./guest.php"><p style="margin-left: 0px;float: right;margin-right: 130px;">
											查看留言</p></a>
				<div class="clear"></div>  
						
				<label>
					<span>姓名 :</span>
					<input id="name" type="text" name="name" placeholder="填写你的姓名" />
				</label>
				
				
				<label>
					<span>手机号:</span>
					<input id="phone" type="text" name="phone" maxlength="11" placeholder="填写你的手机号" />
				</label>
				
				<label>
					<span>电子邮件 :</span>
					<input id="email" type="email" name="email" placeholder="填写你的电子邮件" />
				</label>
				
		  <label>
					<span>留言内容 :</span>
					<textarea id="message" name="message" placeholder="在这里写下你的留言"></textarea>
				</label>
				
		  <label style="margin-left: 160px;">
		    
					<span>&nbsp;</span>
					<input type="submit" class="submit" value="提交" style="background:#00a3eb;color:#fff;"/>
					<input type="reset" class="submit" value="重填" />
				
					
				</label>
               
				<input type="hidden" name="MM_insert" value="form" />
                
	  </form>	
		  
	
			<div class="clear"></div>    	
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
mysql_free_result($postGuest);

?>
