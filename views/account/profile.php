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
$i = 0;
if(!empty($purchasehistory))
{
    foreach($purchasehistory as $item) {
        if($i > 0)
        {
            ?>
    <div class="border-bottom">
            <?php
        }
        else
        {
            ?>
    <div class="border-top border-bottom">
            <?php
        }
        ?>
        <h4 class="item-name"><?php echo $item[0]; ?>: <?php echo $item[2] ?> € pro Gegenstand</h4>
        <p class="item-description">
            <?php echo $item[1]; ?>
        </p>
            Menge: <?php echo $item[3]; ?> Gesamtpreis: <?php echo $item[3] * $item[2]; ?> €
    </div>
    <?php
        $i++;
    }
}