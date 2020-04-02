<?php
header("Content-Type: text/html;charset=utf-8");
require_once 'dbconfig.php';
include 'Pinyin.php';
//@$kmdm=$_GET['kmdm'];
//凭证明细
$mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or  die(mysqli_error());
$sql="SELECT 摘要,'' as 拼音
FROM cwpzkmx
WHERE RTRIM( 摘要 ) <> ''
GROUP BY 摘要
ORDER BY COUNT( * ) DESC ";//LIMIT 0 , 8000";//2027
//$sql = "select  摘要 ,'' as 拼音 from cwpzkmx  where rtrim(摘要)<>'' LIMIT 0 , 1153";
//$sql = "select DISTINCT 摘要 ,'' as 拼音 from cwpzkmx  where rtrim(摘要)<>'' and 摘要 like '%".$zaiyao."%' LIMIT 0 , 300";
//查询
$result=$mysql->query($sql);
$arr = array(); 
while ($row = mysqli_fetch_array($result))
{

$count=count($row);//不能在循环语句中，由于每次删除 row数组长度都减小 

 $row['拼音']=Pinyin_Pinyin::convertInitalPinyin($row[0]);//pinyin1($row[0]); 
  for($i=0;$i<$count;$i++){ 
    unset($row[$i]);//删除冗余数据 
  } 

 array_push($arr,$row);

}

//echo json_encode($arr,JSON_UNESCAPED_UNICODE);

// 把PHP数组转成JSON字符串 
$json_string = json_encode($arr);
// 写入文件

file_put_contents('user.json', $json_string);
mysqli_close($mysql);
