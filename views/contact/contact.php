<script type="text/javascript" src="assets/js/validate.js"></script>

<?php
if(!isset($missing))
{
    $missing['firstname'] = false;
    $missing['lastname'] = false;
    $missing['mail'] = false;
    $missing['information'] = false;
    $missing['problem'] = false;
}
?>

<div class="background-black">
    <div class="row">
        <section>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 center">
                        <h1 class="page-heading">Kontakt</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 col-md-10 col-sm-12 center">
                        <?php if(isset($contactError)) : ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">                                
                                <div class="alert alert-danger">
                                    <?php echo $contactError; ?>
                                </div><br>
                            </div>
                        </div>
                        <?php endif; ?>                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 clear-fix">
                                <div class="alert alert-danger hide-js-disabled" id="ajaxerror">
                                    Bitte alle Felder mit gültigen Werten ausfüllen!
                                </div>
                            </div>
                        </div>
                        <form method="post" onsubmit="return validateContact();">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
                                    <label for="InputFirstname" class="form-for">Vorname</label>
                                    <input id="InputFirstname" class="form-control <?php echo ($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="firstname" placeholder="Vorname" onfocusout="validateInput(this.id)">
                                    <div id="InputFirstname-error" class="validation-helptext <?php echo(($missing['firstname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Vornamen an</div>                        
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                    <label for="InputLastname" class="form-for">Nachname</label>
                                    <input id="InputLastname" class="form-control <?php echo ($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="lastname" placeholder="Nachname" onfocusout="validateInput(this.id)">
                                    <div id="InputLastname-error" class="validation-helptext <?php echo(($missing['lastname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Nachnamen an</div>                        
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">        
                                    <label for="InputMail" class="form-for">E-Mail</label>
                                    <input id="InputMail" class="form-control <?php echo ($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="mail" placeholder="E-Mail" onfocusout="validateInput(this.id, 'mail')">
                                    <div id="InputMail-error" class="validation-helptext <?php echo(($missing['mail'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre E-Mail an</div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 float-left">
                                    <label class="form-for" for="InputInformation">Nachricht</label>
                                    <textarea id="InputInformation" class="form-control <?php echo ($missing['information'] === false) ? '' : 'text-validate-red' ?>"
                                        name="information" cols="45" rows="9" values=" " onfocusout="validateInput(this.id)"></textarea>
                                    <div id="InputInformation-error" class="validation-helptext <?php echo(($missing['information'] === true) ? 'display-show' : 'display-none'); ?>">Bitte ausfüllen</div>                        

                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12">        
                                    <label for="InputProblem" class="form-for">Thema</label>
                                    <input id="InputProblem" class="form-control <?php echo ($missing['problem'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="problem" placeholder="Thema" onfocusout="validateInput(this.id)">
                                    <div id="InputProblem-error" class="validation-helptext <?php echo(($missing['problem'] === true) ? 'display-show' : 'display-none'); ?>">Bitte ausfüllen</div>                        
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input id="buttonSubmit" type="submit" name="inputContact" class="btn btn-primary float-left" value="Abschicken">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>    
