<script type="text/javascript" src="assets/js/countdown.js"></script>
<script type="text/javascript" src="assets/js/validate.js"></script>

<?php
    if(!isset($valid))
        $valid = true;
?>
<div class="row">
    <div class="bord-banner"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 center">
        <p class="countdown-noch">noch</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-10 col-sm-12 center clear-fix">
        <section>
            <div class="center">
                <div class="countdown" id="countdown-days"><?php echo $days; ?> Tage</div>
                <div class="countdown" id="countdown-time">
                    <div class="no-script">
                        <div class="spinner center">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                            </div>
                        </div>
                    </div>
                    <noscript><?php echo $hourstext; ?></noscript>
                </div>
        </section>
    </div> 
</div> 
<div class="background-start">
    <div class="row">
        <div class="newsletter-form">
            <section>
                <form method="post" onsubmit="return validateNewsletter();">
                    <div class="col-lg-4 col-md-4 col-sm-12 float-left">
                        <label for="InputEmail" class="newsletter-label">In den Newsletter eintragen:</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 float-left">
                        <input id="InputEmail" class="form-control <?php echo ($valid === true) ? '' : 'text-validate-red' ?>"
                            type="email" name="email" placeholder="E-Mail" onfocusout="validateInput(this.id)">
                        <div id="InputEmail-error" class="validation-helptext <?php echo(($valid === false) ? 'display-show' : 'display-none'); ?>">Bitte geben sie eine valide E-Mail an.</div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 float-left">
                        <button id="buttonSubmit" type="submit" class="btn btn-primary sm-margin-top float-left" name="reg_newsletter">Newsletter abonnieren</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <section>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1 class="page-heading center">LINE-UP 2020</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/dth.jpg" alt="Die Toten Hosen"/>
                <div class="band-title-red">
                    Die Toten Hosen
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/eminem.jpg" alt="Eminem"/>
                <div class="band-title-black">
                    Eminem
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/metallica.jpg" alt="Metallica"/>
                <div class="band-title-red">
                    Metallica
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/noisia.jpg" alt="Noisia"/>
                <div class="band-title-black">
                    Noisia
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/rammstein.jpg" alt="Rammstein"/>
                <div class="band-title-red">
                    Rammstein
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/knifeparty.jpg" alt="Knife Party"/>
                <div class="band-title-black">
                    Knife Party
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/system_of_a_down.jpg" alt="System of a down"/>
                <div class="band-title-red">
                    System of a down
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/pendulum.jpg" alt="Pendulum"/>
                <div class="band-title-black">
                    Pendulum
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/slipknot.jpg" alt="Slipknot"/>
                <div class="band-title-red">
                    Slipknot
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/steve_aoki.jpg" alt="Steve Aoki"/>
                <div class="band-title-black">
                    Steve Aoki
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/disturbed.jpg" alt="Disturbed"/>
                <div class="band-title-red">
                    Disturbed
                </div>
            </div> 
            <div class="col-lg-4 col-md-6 col-sm-12 lineup-col clear-fix">
                <img class="lineup-image" src="assets/img/band/vini_vici.jpg" alt="Vini Vici"/>
                <div class="band-title-black">
                    Vini Vici
                </div>
            </div>
        </div>
    </section>
</div>
