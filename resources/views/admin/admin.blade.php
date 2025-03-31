<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
</head>

<body>
    @extends('master')

    @section('content')
    <h1>Admin</h1>
    <h2><u>Options de sécurité</u></h2>

    <form method="post" action="">
        <h4>Changement de mot de passe</h4>
        <div>
            <input type="radio" id="periodique" name="password-change" value="periodique" checked>
            <label for="periodique">Périodiquement</label>
        </div>
        <div>
            <input type="radio" id="evenement" name="password-change" value="evenement">
            <label for="evenement">Suite à un évènement</label>
        </div>

        <br />
        <h4>Complexité du mot de passe</h4>
        <div>
            <input type="checkbox" id="old-password" name="old-password"
                <?php echo isset($old_password) && $old_password ? 'checked' : ''; ?>
                onchange="document.getElementById('old-password-count').style.display = this.checked ? 'inline-block' : 'none';">
            <label for="old-password">Ne peut pas utiliser un certain nombre d'anciens mots de passe</label>
            <input type="text" id="old-password-count" name="old-password-count" value="5" size="2" label="anciens mots de passe"
                style="display: <?php echo isset($old_password) && $old_password ? 'block' : 'none'; ?>;">
        </div>
        <div>
            <input type="checkbox" id="lowercase-uppercase" name="lowercase-uppercase">
            <label for="lowercase-uppercase">Doit contenir au moins une minuscule et une majuscule</label>
        </div>
        <div>
            <input type="checkbox" id="special-character" name="special-character">
            <label for="special-character">Doit contenir un caractère spécial</label>
        </div>
        <div>
            <input type="checkbox" id="number" name="number">
            <label for="number">Doit contenir un nombre</label>
        </div>
        <div>
            <label for="minLength">Longueur minimale:</label>
            <input type="number" id="minLength" name="minLength" min="0" value="4">
        </div>
        <div>
            <button type="submit">Valider</button>
        </div>
    </form>
    @endsection