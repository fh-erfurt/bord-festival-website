<script type="text/javascript" src="assets/js/validate.js"></script>
<?php
if(!isset($missing))
{
    $missing['mail'] = false;
    $missing['firstname'] = false;
    $missing['lastname'] = false;
    $missing['dateofbirth'] = false;
    $missing['street'] = false;
    $missing['zip'] = false;
    $missing['city'] = false;
    $missing['country'] = false;
}
?>

<div class="background-black">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-10 clear-fix center">
            <h1 class="page-heading">Mein Account</h1>
            <section>
                <?php
                if(!empty($updateerror))
                {
                ?>
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12 center">
                        <div class="alert alert-danger">
                            <?php echo $updateerror; ?>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="accountdata">
                    <form action="index.php?c=account&a=profile" method="post" onsubmit="return validateProfile();">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
                                <div class="accountdata-content">
                                    <label class="form-for" for="InputMail">E-Mail</label>
                                    <input class="form-control <?php echo($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputMail" name="mail" placeholder="E-Mail"
                                            value="<?php echo $mail; ?>" onfocusout="validateInput(this.id, 'mail')">
                                    <div id="InputMail-error" class="validation-helptext <?php echo(($missing['mail'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre E-Mail an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputFirstname">Vorname</label>
                                    <input class="form-control <?php echo($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputFirstname" name="firstname" placeholder="Vorname"
                                            value="<?php echo $firstname; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputFirstname-error" class="validation-helptext <?php echo(($missing['firstname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Vornamen an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputLastname">Nachname</label>
                                    <input class="form-control <?php echo($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputLastname" name="lastname" placeholder="Nachname"
                                            value="<?php echo $lastname; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputLastname-error" class="validation-helptext <?php echo(($missing['lastname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Nachnamen an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputBirthday">Geburtsdatum</label>
                                    <input class="form-control <?php echo($missing['dateofbirth'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputBirthday" name="dateofbirth" placeholder="Geburtsdatum"
                                            value="<?php echo $dateofbirth; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputBirthday-error" class="validation-helptext <?php echo(($missing['dateofbirth'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Geburtstag an</div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                <div class="accountdata-content">
                                    <label class="form-for" for="InputStreet">Straße</label>
                                    <input class="form-control <?php echo($missing['street'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputStreet" name="street" placeholder="Straße"
                                            value="<?php echo $street; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputStreet-error" class="validation-helptext <?php echo(($missing['street'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre Straße an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputZip">PLZ</label>
                                    <input class="form-control <?php echo($missing['zip'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputZip" name="zip" placeholder="PLZ"
                                            value="<?php echo $zip; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputZip-error" class="validation-helptext <?php echo(($missing['zip'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre Postleitzahl an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputCity">Stadt</label>
                                    <input class="form-control <?php echo($missing['city'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputCity" name="city" placeholder="Stadt"
                                            value="<?php echo $city; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputCity-error" class="validation-helptext <?php echo(($missing['city'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre Stadt an</div>
                                </div>

                                <div class="accountdata-content">
                                    <label class="form-for" for="InputCountry">Land</label>
                                    <input class="form-control <?php echo($missing['country'] === false) ? '' : 'text-validate-red' ?>"
                                            id="InputCountry" name="country" placeholder="Land"
                                            value="<?php echo $country; ?>" onfocusout="validateInput(this.id)">
                                    <div id="InputCountry-error" class="validation-helptext <?php echo(($missing['country'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihr Land an</div>
                                </div>

                            </div>
                        </div>
                        <div class="row">                        
                            <div class="col-lg-12 col-md-12 col-sm-12 clear-fix clear-left">
                                <a class="btn btn-primary" href="#confirmpassword">Accountdaten ändern</a>
                            </div>
                        </div>
                        <div id="confirmpassword" class="overlay">
                            <div class="row">
                                <div class="col-lg-5 col-md-8 col-sm-10 center">
                                    <div class="popup">
                                        <h2 class="popup-title">Accountdaten ändern</h2>
                                        <a class="popup-close" href="#">&times;</a>
                                        <div class="popup-content">
                                            <label for="password">Passwort</label>
                                            <input class="form-control" id="password" name="password" type="password">
                                        </div>
                                        <div class="row">		
								            <div class="col-lg-12 col-md-12 col-sm-12 clearfix clear-left">
                                                <input id="buttonSubmit" class="btn btn-primary" type="submit" name="updateaccount" value="Bestätigen">
								            </div>
							            </div>
                                    </div>                               
                                </div>
                            </div>
                        </div>                                    
                    </form>
                </div>
            </section>
        </div>
    </div>
    
    <br><br>
    
    <div class="row border-top">
        <section>
            <div class="order-history">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 center">
                            <h1 class="page-heading">Meine Bestellhistorie</h1> 
                        </div>
                    </div>
                    <?php 
                    if(!empty($purchasehistory))
                    {
                        foreach($purchasehistory as $purchase)
                        {
                            $i = 0;
                            $purchasedat = $purchase['purchasedat'];
                            $totalprice = $purchase['totalprice'];
                            ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="order">
                                        <div class="row">
                                            <div class="order-header">
                                                <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                                    <b>Bestellung aufgegeben:</b><br>
                                                    <?php echo $purchasedat; ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                                    <b>Gesamtpreis:</b><br>
                                                    <?php echo $totalprice; ?> €
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row order-content clear-left">
                                            <div class="col-lg-12 col-md-12 col-sm-12 clear-left">
    
                            <?php 
                            foreach($purchase['iteminfo'] as $purchaseitem)
                            {
                                if($i > 0)
                                {
                                    ?>
                            <div class="border-top clear-left">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <div class="overflow">
                                    <?php
                                }
                                ?>
                                <div class="float-left item-image-mini">
                                    <img class="" src="<?php echo $purchaseitem['imageurl']; ?>" />
                                </div>
                                <div class="float-left item-details-mini">
                                    <h4 class="item-name"><?php echo $purchaseitem['name']; ?></h4>
                                    <p class="item-description">
                                        <?php echo $purchaseitem['description']; ?>
                                    </p>
                                    <?php echo $purchaseitem['itemprice'] ?> € pro Artikel<br/>
                                    Menge: <?php echo $purchaseitem['quantity']; ?><br/>
                                    Gesamtpreis: <?php echo $purchaseitem['quantity'] * $purchaseitem['itemprice']; ?> €
                                </div>
                            </div>
                            <?php
                                $i++;
                            }
                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-lg-12 col-lg-12">
                                <div class="alert alert-warning center">
                                    Keine Artikel wurden in der Bestellhistorie gefunden.
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>    
