<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device, initial-scale=1.0">

    <title>Profil</title>
</head>
<body>
    <table>
        <tr>
            <th>Vorname:</th>
            <td><?=$this->_params['FIRSTNAME']?></td>
        </tr>
        <tr>
            <th>Nachname:</th>
            <td><?=$this->_params['LASTNAME']?></td>
        </tr>
        <tr>
            <th>Geburtstag:</th>
            <td><?=$this->_params['DATEOFBIRTH']?></td>
        </tr>
        <tr>
            <th>E-Mail:</th>
            <td><?=$this->_params['MAIL']?></td>
        </tr>
        <tr>
            <th>Straße:</th>
            <td><?=$this->_params['STREET']?></td>
        </tr>
        <tr>
            <th>ZIP:</th>
            <td><?=$this->_params['ZIP']?></td>
        </tr>
        <tr>
            <th>Stadt:</th>
            <td><?=$this->_params['CITY']?></td>
        </tr>
        <tr>
            <th>Land:</th>
            <td><?=$this->_params['COUNTRY']?></td>
        </tr>
    </table>
</body>
</html>