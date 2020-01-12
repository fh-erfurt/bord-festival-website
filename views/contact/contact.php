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

    if(isset($contacterror))
    {    
        ?>
        <div class="alert alert-danger">
            <?php echo $contacterror; ?>
        </div><br>
        <?php   
    }
   
?>
<form method="post">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-12 float-left">
            <label for="firstname" class="form-for">Vorname</label>
            <input id="firstname" class="form-control <?php echo ($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                    type="text" name="firstname" placeholder="Vorname">
            <?php if($missing['firstname'] === true) : ?>
                <div class="validation-helptext">Bitte geben Sie Ihren Vornamen an.</div>
            <?php endif; ?>
            
            <label for="lastname" class="form-for">Nachname</label>
            <input id="lastname" class="form-control <?php echo ($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
                    type="text" name="lastname" placeholder="Nachname">
            <?php if($missing['lastname'] === true) : ?>
                <div class="validation-helptext">Bitte geben Sie Ihren Nachnamen an.</div>
            <?php endif; ?>
                
            <label for="mail" class="form-for">E-Mail</label>
            <input id="mail" class="form-control <?php echo ($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
                    type="text" name="mail" placeholder="E-Mail">
            <?php if($missing['mail'] === true) : ?>
                <div class="validation-helptext">Bitte geben Sie Ihre E-Mail an.</div>
            <?php endif; ?>
        </div>

        <div class="col-lg-1 col-md-1 float-left hide-mobile"><br></div>

        <div class="col-lg-4 col-md-6 col-sm-12 float-left">
            <label class="form-for" for="information">Was ist das Problem?</label>
            <textarea id="information" class="form-control <?php echo ($missing['information'] === false) ? '' : 'text-validate-red' ?>"
                name="information" cols="45" rows="8" values="">
            </textarea>
            <?php if($missing['information'] === true) : ?>
                <div class="validation-helptext">Bitte ausfüllen.</div>
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4 col-md-5 col-sm-12 clear-left">
            <br><br>
            <label for="problem" class="form-for">Bitte auswählen:</label>
            <select class="form-control" id="problem" name="problem">
                <option value="ticketshop">Fehler beim Ticketkauf</option>
                <option value="missingticket">Ticket erscheint nicht in meiner Inbox</option>
                <option value="password">Passwort vergessen</option>
                <option value="otherquestions">Sonstige technische Fragen</option>
                <option value="general">Allgemeine Fragen über das Festival</option>
            </select>
            <br>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <input type="submit" name="inputContact" class="btn btn-primary" value="Bestätigen">
        </div>
        </div>
    </div>

</form>
