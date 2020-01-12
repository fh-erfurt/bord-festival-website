<script type="text/javascript" src="assets/js/changeTicketcount.js"></script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section>
            <h1>Ticketshop</h1>
            <?php
            if(isset($_GET['success']))
            {
                if($_GET['success'] === "1")
                {
                    ?>        
                    <div class="alert alert-success">
                        Das Ticket wurde erfolgreich dem Warenkorb hinzugefügt
                    </div>
                    <?php
                }
                else if($_GET['success'] === "0")
                {
                    ?>        
                    <div class="alert alert-danger">
                        Es gab einen Fehler beim Hinzufügen zum Warenkorb. Bitte kontaktiere uns!
                    </div>
                    <?php
                }
                else if($_GET['success'] === "2")
                {
                    ?>        
                    <div class="alert alert-danger">
                        Bitte ein oder mehr Tickets angeben!
                    </div>
                    <?php
                }
            }
            ?>
            <br/>
            <?php
            $i = 0;
            if(empty($tickets))
            {
                ?>        
                <div class="alert alert-warning">
                    Es sind keine Tickets verfügbar! Bitte kontaktiere uns oder trag dich in den Newsletter ein, um zu erfahren, wenn Tickets verfügbar sind.
                </div>
                <?php
            }
            else
            {
                foreach($tickets as $ticket) {
                    if($i > 0)
                    {
                        ?>
                <div class="ticket border-top">
                        <?php
                    }
                    else
                    {
                        ?>
                <div class="ticket">
                        <?php
                    }
                    ?>
                    <div class="float-left item-image">
                        <img class="" src="<?php echo $ticket['IMAGEURL']; ?>" />
                    </div>
                    <div class="float-left item-details">                    
                    <h4 class="ticket-name"><?php echo $ticket['NAME']; ?></h4>
                    <p class="ticket-description">
                        <?php echo $ticket['DESCRIPTION']; ?>
                    </p>
                
                    <?php 
                    if(isset($_SESSION['client_id']))
                    {
                        $ticketid = $ticket["TICKETID"];
                    ?>
                    <form method="post">
                        <input type="hidden" name="ticketid" value="<?php echo $ticketid; ?>" />    
                        <p>Preis: <?php echo $ticket['PRICE']; ?> €</p>
                        <p>Anzahl: 
                        <button type="button" class="btn-fixed btn-primary no-script" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '-')">-</button>
                        <input type="text" id="ticketcount<?php echo $ticketid; ?>" class="input-inline input-ticketcount" name="ticketcount" value="1">
                        <button type="button" class="btn-fixed btn-primary no-script" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '+')">+</button>
                        </p><br>
                        <button type="submit" class="btn btn-primary" name="addtickettocart">In den Warenkorb</button>
                    </form>
                    <?php
                    }
                    else
                    {
                    ?>
                    <p>Preis: <?php echo $ticket['PRICE']; ?> €</p>
                    <button class="btn btn-disabled" disabled>in den Warenkorb</button> Bitte einloggen!
                    <?php
                    }
                
                    $i++;
                    ?>
                    </div>
                    </div>
                <?php 
                }
            }
            ?>
        </section>
    </div>
</div>