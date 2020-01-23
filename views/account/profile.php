<?php
	if(!isset($missing))
	{
		$missing['E-Mail'] = false;
		$missing['Vorname'] = false;
		$missing['Nachname'] = false;
		$missing['Geburtsdatum'] = false;
		$missing['Straße'] = false;
		$missing['Postleitzahl'] = false;
		$missing['Stadt'] = false;
		$missing['Land'] = false;
	}
?>

<div class="background-black">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 center">
            <h class="page-heading">Mein Account</h>
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
                    <form action="?c=account&a=profile"method="post">
                        <?php
                        foreach($accdata as $key => $value) :
                        ?>
                            <div class="row">
                                <div class="accountdata-content">
                                    <div class="col-lg-6 col-md-8 col-sm-12 center">
                                        <label class="form-for" for="<?php echo $key; ?>"><?php echo $key; ?></label>
                                        <input class="form-control <?php echo($missing[$key] === false) ? '' : 'text-validate-red' ?>"
                                               id="<?php echo $key; ?>" name="<?php echo $key; ?>" placeholder="<?php echo $key; ?>"
                                               value="<?php echo $value; ?> ">
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 center">
                            <a class="btn btn-primary" href="#confirmpassword">Accountdaten ändern</a>
                        </div>
                        <div id="confirmpassword" class="overlay">
                            <div class="row">
                                <div class="col-lg-5 col-md-8 col-sm-10 center">
                                    <div class="account-popup">
                                        <h2 class="popup-title">Accountdaten ändern</h2>
                                        <a class="account-popup-close" href="#">&times;</a>
                                        <div class="account-popup-content">
                                            <label for="password">Passwort</label>
                                            <input class="form-control" id="password" name="password" type="password">
                                        </div>
                                        <input class="btn btn-primary" type="submit" name="updateaccount" value="Bestätigen">
                                    </div>                               
                                </div>
                            </div>
                        </div>                                    
                    </form>
                </div>
            </section>
        </div>
    </div>
    
    <br>
    
    <div class="row">
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
