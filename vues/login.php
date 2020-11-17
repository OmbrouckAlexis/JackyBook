<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Alexis Ombrouck</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
    
<body>
    <header>
    <h1>JackyBook</h1>
    </header>

    <div id='formulaire'>
        <div id='connexion'>
            <form action="actions.php?action=connexion" method="post">
            <input type="text" placeholder="login" name="login"><br/>
            <input type="password" placeholder="Mot de passe" name="mdp"><br/>
            <input type="submit" name="se connecter"><br/>
            </form>
        </div>

        <div id='login'>
            <form action="actions.php?action=login" method="post">
            <input type="text" placeholder="login" name="login"><br/>
            <input type="mail" placeholder="" name="mail"><br/>
            <input type="password" placeholder="Mot de passe" name="mdp"><br/>
            <input type="submit" name="s'inscrire"><br/>
            </form>
        </div>
    </div>

    <?php

if(isset($_POST['login'])  && isset($_POST['mdp']))  {
$sql = "SELECT * FROM user WHERE login=? AND mdp=PASSWORD(?)";

// Etape 1  : preparation
$q = $pdo->prepare($sql);

// Etape 2 : execution : 2 paramètres dans la requêtes !!
$q->execute(array($_POST['login'],$_POST['mdp']));
// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.

// un seul fetch
$line = $q->fetch();
    if($line==false){
        message("Erreur de connexion");
        header("Location:index.php?action=login");
    } else{
        $_SESSION['id']=$line['id'];
        $_SESSION['login']=$line['login'];
        
        
        if(isset($_POST['remember'])){
            $key=uniqid("",true);
            setcookie("remember",$key,time()+3600*24*31);
            $sql ="UPDATE user set remember=? WHERE id=?";
            $q=$pdo->prepare($sql);
            $q->execute(array($key, $line['id']));
        }
        header("Location:index.php");
    } 

} else {
        header("Location:index.php?action=login");
    
}

?>

</body>
</html>
