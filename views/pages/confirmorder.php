<h1>Bitte bestätigen Sie Ihre Bestellung</h1><br>

<table>
    <tr>
        <th>Lieferadresse: </th>
        <td><?= $this->_params['STREET'] . '<br>' . $this->_params['ZIP'] .
        '<br>' . $this->_params['CITY'] . '<br>' . $this->_params['COUNTRY']?></td>
    </tr>
    <tr>
        <th>Preis: </th>
        <td><?= $this->_params['PRICE']?></td>
    </tr>
</table>
<div class="ticket border-bottom">
    <form method="post">
        <button type="submit" class="btn btn-primary" name="deletewholecart">Besätigen</button>
    </form>
</div>