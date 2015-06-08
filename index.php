<?php
if (($casas = fopen("Alto_Selva_Alegre_290911.csv", "r")) !== FALSE ) {
    while (($casa = fgetcsv($casas, ",")) !== FALSE) {
    	$pointcsv[]=array($casa[0],$casa[5],$casa[6]);
    }
    

}
if (($manzanas = fopen("manzanas3.csv", "r")) !== FALSE ) {
	$cont=0;
    while (($mnz = fgetcsv($manzanas, ",")) !== FALSE && $cont<=9) {
    	$polygoncsv[]=array($mnz[1],$mnz[2],$mnz[3]);
    	$cont++;
    }
    /*var_dump($polygoncsv);
    echo "<br>";*/
    
}



?>