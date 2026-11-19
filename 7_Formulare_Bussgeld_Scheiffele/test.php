<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>einfaches Formular</title>
</head>

<body>
    <h1>Anmeldung</h1>
    <p>Bitte füllen Sie die nachfolgenden Eingabefelder aus:</p>
    <form action="formular_auswertung.php" method="POST">
        <p>Vorname: <input type="text" name="vorname"></p>
        <p>Nachname: <input type="text" name="nachname"></p>
        <p>Wohnort: <input type="text" name="ort"></p>
        <p>Geburtstag:

            <input type="text" name="tag" size="2" maxlength="2">
            .
            <input type="text" name="monat" size="2" maxlength="2">
            .
            <input type="text" name="jahr" size="4" maxlength="4">




        </p>
        <p><input type="submit" value="Abschicken">
            <input type="reset" value="Zurücksetzen">
        </p>
    </form>

    <?php







    ?>
</body>

</html>