<h1>Warenkorb</h1>
<?php
$cartDeleted = false;
if(isset($_GET['success']))
{
    if($_GET['success'] === "1")
    {
        $cartDeleted = true;
        ?>        
        <div class="alert alert-success">
            Das Ticket wurde erfolgreich aus dem Warenkorb gelöscht
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
    $i++;
}
if($cartDeleted === false)
{
    if($i === 0)
    {
    ?>        
    <div class="alert alert-warning">
        Der Warenkorb ist leer.
    </div>
    <?php
    }
    else
    {
        ?>
        <form action="index.php?a=shoppingcart" method="post">
                    <button type="submit" class="btn btn-danger" name="deletewholecart">Warenkorb leeren</button>
                    <button type="submit" class="btn btn-primary" name="buycart">bestellen</button>
        </form>
        <?php
    }
}