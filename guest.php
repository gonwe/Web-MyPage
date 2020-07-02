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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_geustbooks = 5;
$pageNum_geustbooks = 0;
if (isset($_GET['pageNum_geustbooks'])) {
  $pageNum_geustbooks = $_GET['pageNum_geustbooks'];
}
$startRow_geustbooks = $pageNum_geustbooks * $maxRows_geustbooks;

mysql_select_db($database_conn, $conn);
$query_geustbooks = "SELECT * FROM guest ORDER BY id DESC";
$query_limit_geustbooks = sprintf("%s LIMIT %d, %d", $query_geustbooks, $startRow_geustbooks, $maxRows_geustbooks);
$geustbooks = mysql_query($query_limit_geustbooks, $conn) or die(mysql_error());
$row_geustbooks = mysql_fetch_assoc($geustbooks);

if (isset($_GET['totalRows_geustbooks'])) {
  $totalRows_geustbooks = $_GET['totalRows_geustbooks'];
} else {
  $all_geustbooks = mysql_query($query_geustbooks);
  $totalRows_geustbooks = mysql_num_rows($all_geustbooks);
}
$totalPages_geustbooks = ceil($totalRows_geustbooks/$maxRows_geustbooks)-1;

$queryString_geustbooks = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_geustbooks") == false && 
        stristr($param, "totalRows_geustbooks") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_geustbooks = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_geustbooks = sprintf("&totalRows_geustbooks=%d%s", $totalRows_geustbooks, $queryString_geustbooks);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>清风自鸣-留言板</title>
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
		height: 30px;
  		line-height:30px;
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
	height: 100px;
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
		
#guest {
	margin: 0 auto;
	width: 800px;
	height: 160px;
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
	float: left;
	font-size: 17px;
	margin-left: 90px;
	line-height: 32px;
	color: #666666;
	left: 20px;
}
#guest .title2{
	width: 150px;
	height: 35px;
	float: right;
	font-size: 18px;
	line-height: 32px;
	color: #666666;
	padding-bottom: 0px;
	padding-right: 90px;
}
#guest .text{
	margin-top: 5px;
	height: 70px;
	font-size: 17px;
	margin-left: 10px;
	padding-left: 20px;
	line-height: 40px;
	margin-bottom: 2px;
}
#guest .form{
	color: #999999;
	width: 220px;
	height: 25px;
	float: left;
	font-size: 14px;
	margin-left: 10px;
	padding-left: 20px;
	font-style: italic;
}
#guest .time{
	color: #999999;
	width: 190px;
	height: 25px;
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
#apDiv3 {
	position: absolute;
	left: 526px;
	top: 600px;
	width: 267px;
	height: 35px;
	z-index: 1;
	font-size: 16px;
}
#apDiv4 {
	margin: 0 auto;
	width: 337px;
	height: 34px;
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
		<a href="./post.php"><li>发表留言</li></a>
		<a href="./login.php"><p>留言管理</p></a>
		<a href="./index.php"><p style="margin-left: 0px;background:#339999;">网站首页</p></a>
		</div>
		
		
		
		<div class="clear"></div>
        <?php do { ?>
        <div id="guest">
          <div class="title"><?php echo $row_geustbooks['name']; ?></div>
          <div class="title2">#<?php echo $row_geustbooks['id']; ?> </div>
          <div class="clear"></div>
          <div class="text"><?php echo $row_geustbooks['message']; ?></div>
          <div class="form"> 来自：<?php echo $row_geustbooks['email']; ?></div>
          <div class="time"><?php echo $row_geustbooks['time']; ?></div>
          <br />
        </div>
          <?php } while ($row_geustbooks = mysql_fetch_assoc($geustbooks)); ?>
        <div id="apDiv4">
        <table border="0">
          <tr>
            <td><?php if ($pageNum_geustbooks > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_geustbooks=%d%s", $currentPage, 0, $queryString_geustbooks); ?>">第一页</a>
            <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_geustbooks > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_geustbooks=%d%s", $currentPage, max(0, $pageNum_geustbooks - 1), $queryString_geustbooks); ?>">前一页</a>
            <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_geustbooks < $totalPages_geustbooks) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_geustbooks=%d%s", $currentPage, min($totalPages_geustbooks, $pageNum_geustbooks + 1), $queryString_geustbooks); ?>">下一个</a>
            <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_geustbooks < $totalPages_geustbooks) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_geustbooks=%d%s", $currentPage, $totalPages_geustbooks, $queryString_geustbooks); ?>">最后一页</a>
            <?php } // Show if not last page ?></td>
          </tr>
        </table>
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
mysql_free_result($geustbooks);
?>
