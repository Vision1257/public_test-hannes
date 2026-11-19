<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$vorname=$_POST["vorname"];

$gebTag = $_POST["tag"];
$gebMonat = $_POST["monat"];
$gebJahr = $_POST["jahr"];


echo "<p>Folgende Daten wurden übermittelt:</p>";
echo " <p>Vorname: " . $vorname . "</p>" . "<br>";
echo " <p>Vorname: " . $_POST["nachname"] . "</p>" . "<br>";
echo " <p>Vorname: " . $_POST["ort"] . "</p>" . "<br>";
echo " <p>Vorname: " . $gebTag .".".  $gebMonat .".". $gebJahr . "</p>" . "<br>";


$akt_Tag= 19;
$akt_Monat=11;
$akt_Jahr=2026;

$istVollJ=true;

$diff= $akt_Jahr-$gebJahr;

if ($diff>18) {
   $istVollJ=true;
}

else{
    if ($diff==18 && $akt_Monat>$gebMonat) {
       $istVollJ=true;
    }
    else if ($diff==18 && $akt_Monat<$gebMonat) {
        $istVollJ=false;
    }
    else if ($diff==18 && $akt_Monat==$gebMonat) {

        if ($akt_Tag>=$gebTag) {
           $istVollJ=true;
        }
        if ($akt_Tag<$gebTag) {
           $istVollJ=false;
        }

    }
    else if ($diff<18) {
        $istVollJ=false;
    }

}

if ($istVollJ==true) {
    echo "<p>" . $vorname . " ist volljährig";
}
else {
    echo "<p>" . $vorname . " ist nicht volljährig";
}

?>



    
</body>
</html>
