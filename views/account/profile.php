<table>
    <tr>
        <th class="float-left">Vorname:</th>
        <td><?=$firstname?></td>
    </tr>
    <tr>
        <th class="float-left">Nachname:</th>
        <td><?=$lastname?></td>
    </tr>
    <tr>
        <th class="float-left">Geburtstag:</th>
        <td><?=$dateofbirth?></td>
    </tr>
    <tr>
        <th class="float-left">E-Mail:</th>
        <td><?=$mail?></td>
    </tr>
    <tr>
        <th class="float-left">Straße:</th>
        <td><?=$street?></td>
    </tr>
    <tr>
        <th class="float-left">ZIP:</th>
        <td><?=$zip?></td>
    </tr>
    <tr>
        <th class="float-left">Stadt:</th>
        <td><?=$city?></td>
    </tr>
    <tr>
        <th class="float-left">Land:</th>
        <td><?=$country?></td>
    </tr>
</table>
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
                                Bestellung aufgegeben:<br><?php echo $purchasedat; ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                                Gesamtpreis:<br><?php echo $totalprice; ?> €
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
        <div class="border-top">
                <?php
            }
            else
            {
                ?>
                    <div>
                <?php
            }
            ?>
            <h4 class="item-name"><?php echo $purchaseitem['NAME']; ?>: <?php echo $purchaseitem['ITEMPRICE'] ?> € pro Artikel</h4>
            <p class="item-description">
                <?php echo $purchaseitem['DESCRIPTION']; ?>
            </p>
                Menge: <?php echo $purchaseitem['QUANTITY']; ?> Gesamtpreis: <?php echo $purchaseitem['QUANTITY'] * $purchaseitem['ITEMPRICE']; ?> €
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