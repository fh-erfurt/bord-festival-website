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
                    <div class="col-lg-7 col-md-10 col-sm-12 center contact">
                    <?php
                        if(isset($contacterror))
                        {    
                        ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">                                
                                    <div class="alert alert-danger">
                                        <?php echo $contacterror; ?>
                                    </div><br>
                                </div>
                            </div>
                        <?php   
                        }
                        ?>
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
                                    <label for="firstname" class="form-for-contact">Vorname</label>
                                    <input id="firstname" class="form-control <?php echo ($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="firstname" placeholder="Vorname">
                                    <?php if($missing['firstname'] === true) : ?>
                                        <div class="validation-helptext">Bitte geben Sie Ihren Vornamen an.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                    <label for="lastname" class="form-for-contact">Nachname</label>
                                    <input id="lastname" class="form-control <?php echo ($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="lastname" placeholder="Nachname">
                                    <?php if($missing['lastname'] === true) : ?>
                                        <div class="validation-helptext">Bitte geben Sie Ihren Nachnamen an.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">        
                                    <label for="mail" class="form-for-contact">E-Mail</label>
                                    <input id="mail" class="form-control <?php echo ($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="mail" placeholder="E-Mail">
                                    <?php if($missing['mail'] === true) : ?>
                                        <div class="validation-helptext">Bitte geben Sie Ihre E-Mail an.</div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 float-left">
                                    <label class="form-for-contact" for="information">Nachricht</label>
                                    <textarea id="information" class="form-control <?php echo ($missing['information'] === false) ? '' : 'text-validate-red' ?>"
                                        name="information" cols="45" rows="9" values="">
                                    </textarea>
                                    <?php if($missing['information'] === true) : ?>
                                        <div class="validation-helptext">Bitte ausfüllen.</div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12">        
                                    <label for="problem" class="form-for-contact">Thema</label>
                                    <input id="problem" class="form-control <?php echo ($missing['problem'] === false) ? '' : 'text-validate-red' ?>"
                                            type="text" name="problem" placeholder="Thema">
                                    <?php if($missing['problem'] === true) : ?>
                                        <div class="validation-helptext">Bitte ausfüllen.</div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-lg-12 col-md-8 col-sm-12 center">
                                    <input type="submit" name="inputContact" class="btn btn-primary" value="Bestätigen">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>    
