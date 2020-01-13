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
                                        <img class="" src="<?php echo $item['IMAGEURL']; ?>" />
                                    </div>
                                    <div class="float-left item-details-mini">
                                        <h4 class="item-name"><?php echo $item['ITEMNAME']; ?></h4>
                                        <p class="item-description">
                                            <?php echo $item['ITEMDESCRIPTION']; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 float-left">
                                    <?php echo $item['ITEMPRICE']; ?> €
                                </div>
                                <div class="col-lg-1 float-left">
                                    <?php echo $item['QUANTITY']; ?>
                                </div>
                                <div class="col-lg-2 float-left">
                                    <?php echo $item['QUANTITY'] * $item['ITEMPRICE']; ?> €
                                </div>
                                <div class="col-lg-2 float-left text-right">
                                    <form action="index.php?c=order&a=shoppingcart" method="post">
                                        <input type="hidden" name="cartitemid" value="<?php echo $item['CARTITEMID']; ?>" />
                                        <button type="submit" class="btn no-margin btn-danger" name="deleteitemfromcart">Löschen</button>
                                    </form>                            
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="show-mobile">
                        <div class="float-left item-image-mini">
                            <img class="" src="<?php echo $item['IMAGEURL']; ?>" />
                        </div>
                        <div class="float-left item-details-mini">
                            <h4 class="item-name"><?php echo $item['ITEMNAME']; ?></h4>
                            <p class="item-description">
                                <?php echo $item['ITEMDESCRIPTION']; ?>
                            </p>
                            <?php echo $item['ITEMPRICE'] ?> € pro Artikel<br/>
                            Menge: <?php echo $item['QUANTITY']; ?><br/>
                            Gesamtpreis: <?php echo $item['QUANTITY'] * $item['ITEMPRICE']; ?> €
                            <form action="index.php?c=order&a=shoppingcart" method="post">
                                <input type="hidden" name="cartitemid" value="<?php echo $item['CARTITEMID']; ?>" />
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
<<<<<<< HEAD
                                <div class="padding-top float-left sm-margin-top sm-margin-bottom">Summe(<?php echo $carttotalcount ?> Artikel): <?php echo $carttotalprice ?> €</div>
                                <button type="submit" class="btn no-margin btn-primary float-left" name="buycart">bestellen</button>
=======
                                <div class="padding-top float-left sm-margin-top sm-margin-bottom">Summe(<?php echo $carttotalcount ?> Item(s)): <?php echo $carttotalprice ?> €</div>
                                <button type="submit" class="btn no-margin btn-primary float-left" name="buycart">Bestellen</button>
>>>>>>> a17de791a6df9332637d078ce64c2e3a238bdbe9
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