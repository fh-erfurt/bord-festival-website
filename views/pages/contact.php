<h1>Support kontaktieren</h1>
<br>
<p>Bitte füllen Sie alle Angaben aus und drücken Sie auf absenden, um mit uns in Kontakt zu treten.</p><br><br>

<?php
    if(!isset($missing))
    {
        $missing['firstname'] = false;
        $missing['lastname'] = false;
        $missing['mail'] = false;
        $missing['information'] = false;
    }

    if(isset($success))
    { 
        if($success === '0')
        {
                ?>
            <div class="alert alert-danger">
                Bitte alle fehlenden Felder ausfüllen!
            </div><br>
            <?php
        }
    }
?>

<form action="index.php?a=confirmcontact" method="post">
    <fieldset>
        <legend>Persönliche Angaben</legend>
        <table>
            <tr>
                <th class="float-left">Vorname:</th>
                <td><input class="form-control <?php echo ($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                     type="text" name="firstname" value=""></td>
            </tr>
            <tr>
                <th class="float-left">Nachname:</th>
                <td><input class="form-control <?php echo ($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
                     type="text" name="lastname" value=""></td>
            </tr>
            <tr>
                <th class="float-left">E-Mail:</th>
                <td><input class="form-control <?php echo ($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
                     type="text" name="mail" value=""></td>
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
                <td><br><br><textarea class="<?php echo ($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                             name="information" cols="30" rows="10"></textarea></td>
            </tr>
        </table>
    </fieldset>
    <input type="submit" name="inputContact" class="btn btn-primary" value="Bestätigen">
</form>
