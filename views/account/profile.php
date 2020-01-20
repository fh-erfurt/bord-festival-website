<div class="background-black">
    <div class="row">
        <section>
            <div class="accountdata">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 float-left">
                            <h1 class="page-heading">Mein Account<h1>
                        </div>
                    </div>
                    <div class="row">
                        <form method="post">
                            <?php
                            foreach($accdata as $key => $value) :
                            ?> 
                                <div class="accountdata-content clear-left">
                                    <div class="col-lg-6 col-md-6 col-sm-12 float-left account-label">
                                        <b><?php echo $key . ' '; ?></b><br><?php echo $value; ?>
                                    </div>  
                                    <div class="col-lg-4 col-md-6 col-sm-12 float-left">
                                        <label class="account-label" for="<?php echo $key; ?>"><?php echo $key . ' ändern'; ?></label>
                                        <input id="<?php echo $key; ?>" name="<?php echo $key; ?>"class="form-control" placeholder="<?php echo $key; ?>">
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                                <div class="accountdata-content clear-left">
                                    <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                        <b>Meine Accountdaten sind falsch?</b>
                                        <p>Accountdaten jetzt ändern:</p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                        <input class="btn btn-primary" type="submit" name="updateaccount" value="Accountdaten ändern">
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <br>
    
    <div class="row">
        <section>
            <div class="order-history">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 float-left">
                            <h1 class="page-heading">Meine Bestellhistorie</h1> 
                        </div>
                    </div>
                    <?php 
                    if(!empty($purchasehistory))
                    {
                        foreach($purchasehistory as $purchase)
                        {
                            $i = 0;
                            $purchasedat = $purchase['PURCHASEDAT'];
                            $totalprice = $purchase['TOTALPRICE'];
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
                            foreach($purchase['ITEMINFO'] as $purchaseitem)
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
                                    <img class="" src="<?php echo $purchaseitem['IMAGEURL']; ?>" />
                                </div>
                                <div class="float-left item-details-mini">
                                    <h4 class="item-name"><?php echo $purchaseitem['NAME']; ?></h4>
                                    <p class="item-description">
                                        <?php echo $purchaseitem['DESCRIPTION']; ?>
                                    </p>
                                    <?php echo $purchaseitem['ITEMPRICE'] ?> € pro Artikel<br/>
                                    Menge: <?php echo $purchaseitem['QUANTITY']; ?><br/>
                                    Gesamtpreis: <?php echo $purchaseitem['QUANTITY'] * $purchaseitem['ITEMPRICE']; ?> €
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
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>    
