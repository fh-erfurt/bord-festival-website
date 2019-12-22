<h1>Ticketshop</h1>
<?php 
foreach($tickets as $ticket) {
    foreach($ticket as $value)
    {
         echo $value . '<br>';
    }
    echo '<br><br>';

}
?>