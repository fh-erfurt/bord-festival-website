<h1>Bitte bestätigen Sie Ihre Bestellung</h1><br>

<table>
    <tr>
        <th class="float-left">Lieferadresse: </th>
        <td><?= $street . '<br>' .  $zip .
        '<br>' . $city . '<br>' . $country?></td>
    </tr>
    <tr>
        <th class="float-left">Preis: </th>
        <td><?= $price?></td>
    </tr>
</table>
<div class="item border-top">
    <form method="post">
        <button type="submit" class="btn btn-primary" name="buycart">Bestätigen</button>
    </form>
</div>