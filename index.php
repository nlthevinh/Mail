<!DOCTYPE php>
<?php
function base(){
	$dbhost='localhost';
	$dbuser='user';
	$dbpass='passwd';
	$db='test';
	try{
		$bdd=new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8',$dbuser,$dbpass);
	}
	catch(Exception $e){
		die('Erreur : '.$e->getMessage());
	}
	if(isset($_POST['top'])&&isset($_POST['bottom'])&&isset($_POST['message'])){
        $insert=$bdd->prepare('INSERT INTO messages (top,bottom,message,date) VALUES (?,?,?,NOW())');
        $insert->bindParam(1,$_POST['top']);
		$insert->bindParam(2,$_POST['bottom']);
		$insert->bindParam(3,$_POST['message']);
        $insert->execute();
	}
	if(isset($_POST['username'])){
		$username=$_POST['username'];
		$selectinbox="SELECT top,message,date FROM messages WHERE bottom = '$username'";
		$reponse=$bdd->query($selectinbox);
		while($message=$reponse->fetch()){
			$de=$message['top'];
			$texte=$message['message'];
			$date=$message['date'];
			echo "<li>De : $de $date > $texte</li>";
		}
	}
	/*if(isset($_POST['supprimer']) AND $_POST['supprimer']=='Supprimer'){
		$dropinbox=$bdd->prepare("DELETE FROM messages WHERE bottom = '?'");
		$dropinbox->bindParam(1,$username);
		$pdropinbox->execute();
	}*/
}
?>
<html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width,initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <link rel='stylesheet' href='style.css'/>
        <title>Supermail</title>
    </head>
    <body>
		<h1>Mon Premier Mail</h1>
		<br/>
		<h2>Username</h2>
		<form method='post' action='index.php'>
            <input type='text' name='username'/>
			<input type='submit' value='Connecter'/>
        </form>
		<br/>
		<h2>Envoyer un message</h2>
		<form method='post' action='index.php'>
			De :
			<input type='text' name='top'/>
			A : 
			<input type='text' name='bottom'/>
			Message : 
			<input type='text' name='message'/>
			<input type='submit' value='Envoyer'/>
        </form>
		<br/>
		<h2>Messages reçus</h2>
		<?php
		base()
		?>
		<form method='post' action='index.php'>
		<input type='submit' value='Supprimer' name='supprimer'/>
        </form>
	</body>
</html>
