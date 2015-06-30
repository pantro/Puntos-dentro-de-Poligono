<?php
$pointLocation = new pointLocation();
//$file = fopen("point_to_poly_3.csv","w");
$points = array("-16.4473342485 -71.6006570114","-16.4467816665 -71.6003432158","-16.4467816665 -71.6003432158","-16.4467816665 -71.6003432158","-16.4473342485 -71.6006570114","-16.4468311026 -71.600155403","-16.4473342485 -71.6006570114");

$polygon = array("-16.4471422371 -71.6002541331","-16.4473680247 -71.6004860836","-16.447430992 -71.6003848616","-16.4477569568 -71.6004616804","-16.4479140114 -71.5999824726","-16.4472679841 -71.5995238824","-16.4474025132 -71.5991730999","-16.4476499934 -71.5984386626","-16.447717819 -71.5982182909","-16.447738513 -71.598079054","-16.4476198691 -71.5980650219","-16.4475309575 -71.5983895264","-16.4474922781 -71.5985706676","-16.4473272159 -71.5991001918","-16.4471888748 -71.5994934978","-16.447017015 -71.5997542228","-16.4468772268 -71.5999819351","-16.4466620733 -71.6002624433","-16.4466581021 -71.6004118288","-16.4467282644 -71.6006406084","-16.4471422371 -71.6002541331");
// Las últimas coordenadas tienen que ser las mismas que las primeras, para "cerrar el círculo"

foreach($points as $key => $point) {
    //var_dump($point);
    //echo "<br>";
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
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