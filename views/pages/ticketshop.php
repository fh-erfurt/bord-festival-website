<script type="text/javascript" src="assets/js/changeTicketcount.js"></script>
<h1>Ticketshop</h1>
<?php
if(isset($_GET['success']))
{
    if($_GET['success'] === "1")
    {
        echo 'added to cart';
    }
    else
    {
        echo 'problem adding to cart';
    }
}
?>
<br/>
<?php 
foreach($tickets as $ticket) {
    foreach($ticket as $value)
    {
         echo $value . '<br>';
    }
?>
<?php 
if(isset($_SESSION['client_id']))
{
    $ticketid = $ticket["TICKETID"];
?>
<form action="index.php?a=ticketshop" method="post">
    <input type="hidden" name="ticketid" value="<?php echo $ticketid; ?>" />
    Anzahl: <button type="button" class="btn" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '-')">-</button><input type="text" id="ticketcount<?php echo $ticketid; ?>" name="ticketcount" value="1"><button type="button" class="btn" onclick="changeTicketcount('ticketcount<?php echo $ticketid; ?>', '+')">+</button>
    <br>
    <button type="submit" class="btn" name="addtickettocart">in den Warenkorb</button>
</form>
<?php
}
else
{
?>
    <button class="btn" disabled>in den Warenkorb</button> Bitte einloggen!
<?php
}
?>
<br/><br/>
<?php } ?>
