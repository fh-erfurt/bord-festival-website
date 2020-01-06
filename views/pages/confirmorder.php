<h1>Bitte bestätigen Sie Ihre Bestellung</h1><br>

<table>
    <tr>
        <th class="float-left">Lieferadresse: </th>
        <td><?= $this->_params['STREET'] . '<br>' . $this->_params['ZIP'] .
        '<br>' . $this->_params['CITY'] . '<br>' . $this->_params['COUNTRY']?></td>
    </tr>
    <tr>
        <th class="float-left">Preis: </th>
        <td><?= $this->_params['PRICE']?></td>
    </tr>
</table>
<div class="ticket border-top">
    <form method="post">
        <button type="submit" class="btn btn-primary" name="deletewholecart">Bestätigen</button>
    </form>
</div>