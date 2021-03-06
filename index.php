<?php
$pointLocation = new pointLocation();

$file = fopen("point_to_poly_2.csv","w");

if (($casas = fopen("Tiabaya_211209.csv", "r")) !== FALSE ) {
    $cont=0;
    while (($casa = fgetcsv($casas, ",")) !== FALSE) {
        if ($cont>=1) {
            $pointcsv[]=array($casa[0],$casa[5]." ".$casa[6]);
            //echo $nom_point." esta " . $pointLocation->pointInPolygon($pointcsv, $polygoncsv) ." de ".$nom_poly ."<br>";            
        }
        $cont++;
    }
}
//echo count($pointcsv);
//var_dump($pointcsv);
//echo "<br>";
if (($manzanas = fopen("tiabaya_mz.csv", "r")) !== FALSE ) {
	$cont=0;
    while (($mnz = fgetcsv($manzanas, ",")) !== FALSE ) {
    	if ($cont>=2){
    		if ( $mnz[2]!== " ") {
                $nom_poly=$mnz[1];
                $polygoncsv[]=$mnz[2]." ".$mnz[3];
                
            }
    		else{
                array_push($polygoncsv, $polygoncsv[0]);
                $size=count($pointcsv);
                for ($i=0; $i < $size; $i++) { 
                    if ($pointLocation->pointInPolygon($pointcsv[$i][1], $polygoncsv)==="inside") {
                        //echo $pointcsv[$i][0]." esta dentro de ".$nom_poly;
                        //echo "<br>";
                        fputcsv( $file, array($pointcsv[$i][0],$pointcsv[$i][1],$nom_poly));
                        unset($pointcsv[$i]);
                    }
                }
                echo $i;
                echo "<br>";
                $pointcsv = array_values($pointcsv); 
                unset($polygoncsv);
            }
    	}

    	$cont++;

    }

}

echo "Finalizado ...";
echo count($pointcsv);
$file2 = fopen("point_to_poly_3.csv","w");
for ($i=0; $i < count($pointcsv); $i++) { 
    fputcsv( $file2, array($pointcsv[$i][0],$pointcsv[$i][1]));
}

/*
Descripción: El algoritmo del punto en un polígono permite comprobar mediante
programación si un punto está dentro de un polígono o fuera de ello.
Autor: Michaël Niessen (2009)
Sito web: AssemblySys.com
 
Si este código le es útil, puede mostrar su
agradecimiento a Michaël ofreciéndole un café ;)
PayPal: michael.niessen@assemblysys.com
 
Mientras estos comentarios (incluyendo nombre y detalles del autor) estén
incluidos y SIN ALTERAR, este código está distribuido bajo la GNU Licencia
Pública General versión 3: http://www.gnu.org/licenses/gpl.html
*/
 
class pointLocation {
    var $pointOnVertex = true; // Checar si el punto se encuentra exactamente en uno de los vértices?
 
    function pointLocation() {
    }
 
        function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        // Transformar la cadena de coordenadas en matrices con valores "x" e "y"
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
            
        }
 
        // Checar si el punto se encuentra exactamente en un vértice
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
 
        // Checar si el punto está adentro del poligono o en el borde
        $intersections = 0;
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Checar si el punto está en un segmento horizontal
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Checar si el punto está en un segmento (otro que horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // Si el número de intersecciones es impar, el punto está dentro del poligono.
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
 
}



?>