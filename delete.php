<?php
if (isset($_GET['id']))
{
include_once('Connections/conn.php');
mysql_query('DELETE FROM `guest` WHERE `id` = \'' . $_GET['id'] . '\'');
}
?>
<?php 

//页面跳转，实现方式为javascript 

$url = "admin.php"; 

echo "<script language='javascript' type='text/javascript'>"; 

echo "window.location.href='$url'"; 

echo "</script>"; 

?> 