<div class="background-black">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <section>
                <h1 class="page-heading">Warenkorb</h1>
                <?php
                $cartDeleted = false;
                if(isset($_GET['success']))
                {
                    if($_GET['success'] === "1")
                    {
                        $cartDeleted = true;
                        ?>        
                        <div class="alert alert-success">
                            Das Item/die Items wurde(n) erfolgreich aus dem Warenkorb gelöscht
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>        
                        <div class="alert alert-danger">
                            Es gab einen Fehler beim Entfernen aus dem Warenkorb. Bitte kontaktiere uns!
                        </div>
                        <?php
                    }
                }
                ?>
                <?php 
                $i = 0;
                if(!empty($shoppingcart))
                {
                    ?>
                    <div class="hide-mobile">
                        <div class="row">
                            <div class="order-header">
                                <div class="col-lg-5 float-left">
                                    Artikel
                                </div>
                                <div class="col-lg-2 float-left">
                                    Preis
                                </div>
                                <div class="col-lg-1 float-left">
                                    Menge
                                </div>
                                <div class="col-lg-2 float-left">
                                    Gesamtsumme
                                </div>
                                <div class="col-lg-2 float-left">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach($shoppingcart as $item) {
                        if($i > 0)
                        {
                            ?>
                    <div class="border-bottom">
                            <?php
                        }
                        else
                        {
                            ?>
                    <div class="border-bottom">
                            <?php
                        }
                        ?>
                        <div class="hide-mobile">
                            <div class="row clear-left">
                                <div class="order-content">
                                    <div class="col-lg-5 float-left">
                                        <div class="float-left item-image-mini">
                                            <img class="" src="<?php echo $item['imageurl']; ?>" />
                                        </div>
                                        <div class="float-left item-details-mini">
                                            <h4 class="item-name"><?php echo $item['itemname']; ?></h4>
                                            <p class="item-description">
                                                <?php echo $item['itemdescription']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 float-left">
                                        <?php echo $item['itemprice']; ?> €
                                    </div>
                                    <div class="col-lg-1 float-left">
                                        <?php echo $item['quantity']; ?>
                                    </div>
                                    <div class="col-lg-2 float-left">
                                        <?php echo $item['quantity'] * $item['itemprice']; ?> €
                                    </div>
                                    <div class="col-lg-2 float-left text-right">
                                        <form action="index.php?c=order&a=shoppingcart" method="post">
                                            <input type="hidden" name="cartitemid" value="<?php echo $item['cartitemid']; ?>" />
                                            <button type="submit" class="btn no-margin btn-danger" name="deleteitemfromcart">Löschen</button>
                                        </form>                            
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="show-mobile">
                            <div class="float-left item-image-mini">
                                <img class="" src="<?php echo $item['imageurl']; ?>" />
                            </div>
                            <div class="float-left item-details-mini">
                                <h4 class="item-name"><?php echo $item['itemname']; ?></h4>
                                <p class="item-description">
                                    <?php echo $item['itemdescription']; ?>
                                </p>
                                <?php echo $item['itemprice'] ?> € pro Artikel<br/>
                                Menge: <?php echo $item['quantity']; ?><br/>
                                Gesamtpreis: <?php echo $item['quantity'] * $item['itemprice']; ?> €
                                <form action="index.php?c=order&a=shoppingcart" method="post">
                                    <input type="hidden" name="cartitemid" value="<?php echo $item['cartitemid']; ?>" />
                                    <button type="submit" class="btn btn-danger" name="deleteitemfromcart">Löschen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        $i++;
                    }
                }
                if($i === 0)
                {
                    if($cartDeleted === false)
                    {
                ?>        
                <div class="alert alert-warning">
                    Der Warenkorb ist leer.
                </div>
                <?php
                    }
                }
                else
                {
                    ?>
                    <div class="bottom-buttons">
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 float-left">
                                    <button type="submit" class="btn no-margin btn-danger" name="deletewholecart">Warenkorb leeren</button>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 float-left">
                                    <div class="float-right sm-width-100">
                                        <div class="padding-top float-left sm-margin-top sm-margin-bottom">Summe(<?php echo $carttotalcount ?> Item(s)): <?php echo $carttotalprice ?> €</div>
                                        <a class="btn no-margin btn-primary float-left" href="#confirmorder">Bestellen</a>
                                    </div>
                                </div>
                            </div>
                            <div id="confirmorder" class="overlay">
                                <div class="row">
                                    <div class="col-lg-5 col-md-8 col-sm-10 center">
                                        <div class="popup">
                                            <h2 class="popup-title">Ihre Bestellung</h2>
                                            <a class="popup-close" href="#">&times;</a>
                                            <div class="popup-content">
                                                <b>Versandadresse</b><br>                                    
                                                <?php echo "$street <br/> $zip <br/> $city <br/> $country"; ?><br><br>
                                                <div class="row no-margin-right">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 float-left clear-left">                                                    
                                                        <b>Preis</b><br>
                                                        <?php echo $carttotalprice; ?>
                                                    </div>
                                                    <div class="col-lg-6 col-lg-6 col-sm-6 float-left">
                                                        <button type="submit" class="btn btn-primary no-margin float-right" name="buycart">Bestätigen</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                               
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
            </section>
        </div>
    </div>
</div>