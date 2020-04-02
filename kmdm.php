<?php
/**
 * @name 凭证填制/录入
 * @desc 中国式财务凭证录入
 * @author 吴俊杰(cocashu@gmail.com)
*/
header("Content-Type: text/html;charset=utf-8");
require_once 'dbconfig.php';
@$kmdm=$_GET['kmdm'];
//凭证明细
if ($kmdm){
$mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or  die(mysqli_error());
$sql = "select 科目代码 ,科目名称 from cwkmdmk where 级别<>1 and 科目代码 like '".$kmdm."%'";
//查询
$result=$mysql->query($sql);
$arr = array(); 
while ($row = mysqli_fetch_array($result))
{
$count=count($row);//不能在循环语句中，由于每次删除 row数组长度都减小 
  for($i=0;$i<$count;$i++){ 
    unset($row[$i]);//删除冗余数据 
  } 
  
  array_push($arr,$row);
}
echo json_encode($arr,JSON_UNESCAPED_UNICODE); }
else{
$mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or  die(mysqli_error());
$sql = "select 科目代码 ,科目名称 from cwkmdmk where 级别=1 ";
//查询
$result=$mysql->query($sql);
$arr = array(); 
while ($row = mysqli_fetch_array($result))
{
$count=count($row);//不能在循环语句中，由于每次删除 row数组长度都减小 
  for($i=0;$i<$count;$i++){ 
    unset($row[$i]);//删除冗余数据 
  } 
  
  array_push($arr,$row);
}
echo json_encode($arr,JSON_UNESCAPED_UNICODE); 	
}
mysqli_close($mysql);
  
