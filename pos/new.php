<?php	
$data = 'sidikganteng;sekali;wakwau';
$cnt = 3;
$explode=explode(";",$data);
		for ($j=0;$j<=$cnt-1;$j++){
	$message = $explode[$j];
	echo "<script type='text/javascript'>alert('$message');</script>";
		}

/*

$categories = '';
$name = 'melata,betina,jantan';
$cats = explode(",", $name);
foreach($cats as $cat) {
    $cat = trim($cat);
    $categories .= "<category>" . $cat . "</category>\n";
		echo "<script type='text/javascript'>alert('$cat');</script>";

}*/		
		?>