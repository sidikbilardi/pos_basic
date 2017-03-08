<?php
//upload.php
include"../database.php";
$output_dir = "../img/menu/";
 
if(isset($_FILES["myfile"]))
{
    //Filter the file types , if you want.
    if ($_FILES["myfile"]["error"] > 0)
    {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        //move the uploaded file to uploads folder;
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
 
     echo "Uploaded File :".$_FILES["myfile"]["name"];
        //mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('12345','Input Product','".$_FILES["myfile"]["name"]."',now())");

    }
 
}
?>