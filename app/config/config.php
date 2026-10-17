<?php 
date_default_timezone_set("Asia/Manila");
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name ="softecoms";

$conn = "";

$conn = mysqli_connect($db_server,
                       $db_user
                      ,$db_pass
                      ,$db_name);



if($conn){


}
else{

    echo"no connect";

}
?>