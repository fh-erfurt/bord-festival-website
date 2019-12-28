<?php 
foreach($shoppingcart as $item) {
    echo $item[1].': '.$item[3];
    echo '<br>'.$item[2];
    echo '<br>Menge: '.$item[4].' Preis: '.$item[4] * $item[3].' €';
?>  <br>
    <form action="index.php?a=shoppingcart" method="post">
        <input type="hidden" name="cartitemid" value="<?php echo $item[0]; ?>" />
        <button type="submit" class="btn btn-danger" name="deleteitemfromcart">löschen</button>
    </form>
    <br><br>
<?php
}
?>
<form action="index.php?a=shoppingcart" method="post">
        <button type="submit" class="btn btn-danger" name="deletewholecart">Warenkorb leeren</button>
        <button type="submit" class="btn btn-primary" name="buycart">bestellen</button>
</form>