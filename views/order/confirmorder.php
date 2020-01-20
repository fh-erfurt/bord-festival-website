<div class="background-black">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <section>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 clear-left">
                        <h1 class="page-heading">Ihre Bestellung</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-sm-12 clear-left">
                        <div class="confirmorder-content">
                            <b>Versandadresse:</b><br><br>
                            <p><?php echo "$street <br/> $zip <br/> $city <br/> $country"?></p>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-sm-12 clear-left">
                        <div class="confirmorder-price-content">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 lineup-col">
                                    <b>Preis: </b><?php echo $price . '€'; ?>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 lineup-col">
                                    <form method="post">
                                        <input class="btn btn-primary" type="submit" name="buycart" value="Bestätigen">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>