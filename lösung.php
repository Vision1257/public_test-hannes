<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    //$zahlen_Feld= array(55,95,20,100,38,48,28,35,70,50);

    $zahlen_Feld = array();

 for ($i = 0; $i < 10; $i++) {
     $zahlen_Feld[] = rand(1, 100);
 }

    echo "<h1>Arbeiten mit numerisch indizierten Arrays</h1>";

    echo "--------------Aufgabe a---------------";
 echo "<br>";
 

     foreach($zahlen_Feld as $wert){
        echo $wert. " ";
    };

    echo "<br>";


echo "--------------Aufgabe b---------------";

 $summe=0;
foreach($zahlen_Feld as $wert){
   $summe+=$wert;
}
echo "<br>";
echo "Summe der Arrayelemente: ".$summe. " ";


 echo "<br>";

 echo "--------------Aufgabe c---------------";
$anzahl=0;
 foreach($zahlen_Feld as $wert){
    $anzahl++;
    $mittelwert=$summe/$anzahl;
 }
  echo "<br>";
 echo "Durchschnittswert der Arrayelemente: ".$mittelwert;

  echo "<br>";

echo "--------------Aufgabe d---------------";

echo "<br>";

 echo "Größterwert im Array: ".max($zahlen_Feld);

 echo "<br>";


 

  








    ?>




    
</body>
</html>
