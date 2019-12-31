<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section>
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
                        Das Ticket/die Tickets wurde(n) erfolgreich aus dem Warenkorb gelöscht
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
                foreach($shoppingcart as $item) {
                    if($i > 0)
                    {
                        ?>
                <div class="ticket border-bottom">
                        <?php
                    }
                    else
                    {
                        ?>
                <div class="ticket border-top border-bottom">
                        <?php
                    }
                    ?>
                    <h4 class="ticket-name"><?php echo $item[1]; ?>: <?php echo $item[3] ?> € pro Ticket</h4>
                    <p class="ticket-description">
                        <?php echo $item[2]; ?>
                    </p>
                        Menge: <?php echo $item[4]; ?> Gesamtpreis: <?php echo $item[4] * $item[3]; ?> €
                    <p>
                    <form action="index.php?a=shoppingcart" method="post">
                        <input type="hidden" name="cartitemid" value="<?php echo $item[0]; ?>" />
                        <button type="submit" class="btn btn-danger" name="deleteitemfromcart">löschen</button>
                    </form>
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
                    <form action="index.php?a=shoppingcart" method="post">
                        <button type="submit" class="btn btn-danger float-left" name="deletewholecart">Warenkorb leeren</button>
                        <div class="float-right">
                            Warenkorb(<?php echo $carttotalcount ?>): <?php echo $carttotalprice ?> € 
                            <button type="submit" class="btn btn-primary" name="buycart">bestellen</button>
                        </div>
                    </form>
                </div>
                <?php
            }
            ?>
        </section>
    </div>
</div>