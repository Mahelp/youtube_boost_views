<?php
 session_start();
include  'includes/cnx.php';


$email_bdd='0';
$pass_bdd='0';
try{
  
    // vérification de l'accés a la bd
    
      $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
      $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // récupération des paramétres 
      $email=strip_tags($_POST['email']);
      $pass=strip_tags($_POST['pass']);


    // récupération de l'email(idf) et du mot de passe en bdd en fonction des deux param
    $sth = $dbco->prepare("SELECT id,login_name,email,pass,id_chaine,coins_value FROM  youtube_user 
                          WHERE email=:email AND  pass=:pass
                        ");
    
    $sth->execute(array(
                ':email' => $email,
                ':pass' => $pass
              ));
    
    echo "récupération de l'émail et mot de passe soit ok soit ko ";
    
    
    if($sth->execute(array(':email' => $email,':pass' => $pass)) && $row = $sth->fetch())
    {
      $email_bdd = $row['email'];    // Récupération de la clé
      $pass_bdd = $row['pass']; // $actif contiendra alors 0 ou 1
    
    }
    
    // on rentre dans le if si c'est bon pour le login et pass

    if (($pass_bdd !='0') AND ($email_bdd !='0'))
                {
          
                   
                    
                  // initialisé les variables d'identifiants...
                    $_SESSION['id']=$row["id"];
                    $_SESSION['login_name']=$row["login_name"];
                    $_SESSION['id_chaine']=$row["id_chaine"];
                    $_SESSION['coins_value']=$row["coins_value"];
                    
                    

                    header("location: profile_todo.php");
                }//fin if 
                   
                else{
                    echo "Invalid User ID or Password";
                }
            
    } // fin try


    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
  
}// fin catch

$dbco=null;


?>