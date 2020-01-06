<h1>Support kontaktieren</h1>
<br>
<p>Bitte füllen Sie alle Angaben aus und drücken Sie auf absenden, um mit uns in Kontakt zu treten.</p><br><br>

<?php
    if(isset($_GET['success']))
    { 
        if($_GET['success'] === '0')
        {
            $formAction = "";
            ?>
            <div class="alert alert-danger">
                Bitte alle fehlenden Felder ausfüllen!
            </div><br>
            <?php
        }
        else if($_GET['success'] === '1')
        {
            $formAction = "index.php?a=confirmcontact";
        }
    }
?>

<form action=<?php echo($formAction)?> method="post">
    <fieldset>
        <legend>Persönliche Angaben</legend>
        <table>
            <tr>
                <th class="float-left">Vorname:</th>
                <td><input type="text" name="firstname" value="" required></td>
            </tr>
            <tr>
                <th class="float-left">Nachname:</th>
                <td><input type="text" name="lastname" value=""></td>
            </tr>
            <tr>
                <th class="float-left">E-Mail:</th>
                <td><input type="text" name="mail" value=""></td>
            </tr>
        </table>
    </fieldset><br>

    <fieldset>
    <legend>Problematik</legend>
        <table>
            <tr>
                <th class="float-left">Bitte auswählen:</th>
                <td>
                    <select name="problem">
                        <option value="ticketshop">Fehler beim Ticketkauf</option>
                        <option value="missingticket">Ticket erscheint nicht in meiner Inbox</option>
                        <option value="password">Passwort vergessen</option>
                        <option value="otherquestions">Sonstige technische Fragen</option>
                        <option value="general">Allgemeine Fragen über das Festival</option>
                    </select>
                 </td>
            </tr>
            <tr>
                <th class="float-left"><br><br>Probleme/Fragen:</th>
                <td><br><br><textarea name="information" cols="30" rows="10"></textarea></td><br><br>
            </tr>
        </table>
    </fieldset>
    <input type="submit" name="inputContact" class="btn btn-primary" value="Bestätigen">
</form>
