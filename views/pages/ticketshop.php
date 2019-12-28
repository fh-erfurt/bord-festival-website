<script type="text/javascript" src="assets/js/changeTicketcount.js"></script>
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
    else
    {
        ?>        
        <div class="alert alert-danger">
            Es gab einen Fehler beim Hinzufügen zum Warenkorb. Bitte kontaktiere uns!
        </div>
        <?php
    }
}
?>
<br/>
<?php
$i = 0;
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
    <h4 class="ticket-name"><?php echo $ticket['NAME']; ?></h4>
    <p class="ticket-description">
        <?php echo $ticket['DESCRIPTION']; ?>
    </p>

    <?php 
    if(isset($_SESSION['client_id']))
    {
        $ticketid = $ticket["TICKETID"];
    ?>
    <form action="index.php?a=ticketshop" method="post">
        <input type="hidden" name="ticketid" value="<?php echo $ticketid; ?>" />    
        <p>Preis: <?php echo $ticket['PRICE']; ?> €</p>
        <p>Anzahl: 
        <button type="button" class="btn btn-primary" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '-')">-</button><input type="text" id="ticketcount<?php echo $ticketid; ?>" class="form-control input-ticketcount" name="ticketcount" value="1"><button type="button" class="btn btn-primary" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '+')">+</button>
        </p><br>
        <button type="submit" class="btn btn-primary" name="addtickettocart">in den Warenkorb</button>
    </form>
    <?php
    }
    else
    {
    ?>
    <button class="btn" disabled>in den Warenkorb</button> Bitte einloggen!
</div>
    <?php
    }

    $i++;
    ?>
<?php 
}