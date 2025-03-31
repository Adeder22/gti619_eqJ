@extends('master')

@section('content')
    <h1>Admin</h1>
    <h2>Options de sécurité</h2>
    
    <h3>Changement de mot de passe</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Changement de mot de passe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="#">Ooga1</a></td>
                <td>
                    <input type="input">
                    <button type="submit">Valider</button>
                </td>
            </tr>
            <tr>
                <td><a href="#">Ooga2</a></td>
                <td>
                    <input type="input">
                    <button type="submit">Valider</button>
                </td>
            </tr>
            <tr>
                <td><a href="#">Ooga3</a></td>
                <td>
                    <input type="input">
                    <button type="submit">Valider</button>
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Complexité du mot de passe</h3>
    <form method="post" class="password_complexity" action="">
        <div>
            <input type="checkbox" id="lowercase-uppercase" name="lowercase-uppercase">
            <label for="lowercase-uppercase">Ne peut pas utiliser l'ancien mot de passe</label>
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
            <label for="length">Longueur:</label>
            <input type="number" id="length" name="length" min="0">
        </div>
        <div>
            <button type="submit">Valider</button>
        </div>
    </form>
@endsection