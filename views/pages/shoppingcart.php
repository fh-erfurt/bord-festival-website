<?php 
foreach($shoppingcart as $item) {
    echo $item[1].': '.$item[3];
    echo '<br>'.$item[2];
    echo '<br>Menge: '.$item[4].' Preis: '.$item[4] * $item[3].' €';
?>  <br>
    <form action="index.php?a=shoppingcart" method="post">
        <input type="hidden" name="cartitemid" value="<?php echo $item[0]; ?>" />
        <button type="submit" class="btn" name="deleteitemfromcart">löschen</button>
    </form>
    <br><br>
<?php
}
?>