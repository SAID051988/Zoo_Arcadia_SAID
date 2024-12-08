<?php
//Démarrer la session si elle n'est pas démarrée
if(session_status()===PHP_SESSION_NONE){
    session_start(); 
 }
 require_once '../dbconnect.php';
 require_once '../config.php';
// Initialiser les messages à vide
$success_message = "";
$error_message = "";
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['txtNom']) && !empty($_POST['txtEmail'])  && !empty($_POST['txtPrefession'])  && !empty( $_POST['txtMessage']) && !empty($_POST['note_avis'])){
     // Assurez-vous que le champ 'imageCommentaire' existe dans $_FILES
    if (!empty($_FILES["imageCommentaire"]) && $_FILES["imageCommentaire"]["error"] == UPLOAD_ERR_OK) {
        // Informations sur le fichier téléchargé
        $temp_name = $_FILES["imageCommentaire"]["tmp_name"];
        $original_name = basename($_FILES["imageCommentaire"]["name"]);

        // Vérifier la taille de l'image
        $image_size = getimagesize($temp_name);
        $width = $image_size[0];
        $height = $image_size[1];

        // Définir la taille souhaitée
        $desired_width = 100;
        $desired_height = 100;

        // Vérifier si la taille est correcte
        if ($width == $desired_width && $height == $desired_height) {
            // Définir le chemin du dossier de destination
            $upload_directory = "../img/";

            // Utiliser le nom du service (en supprimant les espaces) comme nom de fichier
            $service_name_without_spaces = str_replace(' ', '_', $_POST['txtNom']);

            // Extraire l'extension du nom de fichier d'origine
            $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);

            // Construire le nouveau nom en concaténant le nom du service et l'extension du fichier
            $new_name = $service_name_without_spaces . "." . $file_extension;

            // Déplacer le fichier téléchargé vers le dossier de destination
            $destination = $upload_directory . $new_name;
            move_uploaded_file($temp_name, $destination);

            // Préparation et exécution de la requête SQL pour mettre à jour le profil
            // require_once '../connexion/connexion.php';
            $reqInsertService = "INSERT INTO avis (nom_avis, email_avis, profession_avis,message_avis,note_avis, image_avis,date_avis,valider_avis) ";
            $reqInsertService .= "VALUES (:nom_avis, :email_avis,:profession_avis,:message_avis,:note_avis, :image_avis,:date_avis,:valider_avis)";

            $statement = $pdo->prepare($reqInsertService);
            $statement->execute(array(
                ':nom_avis' => $_POST['txtNom'],
                ':email_avis' => $_POST['txtEmail'],
                ':profession_avis' => $_POST['txtPrefession'],
                ':message_avis' => $_POST['txtMessage'],
                ':note_avis' =>$_POST['note_avis'],
                ':image_avis' => $new_name,
                ':date_avis' =>date('Y-m-d H:i:s'),
                ':valider_avis' => 0
            ));
            // Définir le message de succès
            $success_message = "Commentaire ajouté avec succès.";
        } else {
            // Définir le message d'erreur
            $error_message = "La taille de l'image doit être de 100x100 pixels.";
        }
    } else {
        // Définir le message d'erreur
        $error_message = "Erreur lors du téléchargement de l'image.";
    }
    // Stocker les messages dans des variables de session

}else {
    // Définir le message d'erreur
    $error_message = "Requête HTTP n'est pas reçue";
}
}else {
    // Définir le message d'erreur
    $error_message = "RVous devez remplir tous les champs";
}
//session_start();
    $_SESSION['success_message_avis'] = $success_message;
    $_SESSION['error_message_avis'] = $error_message;

    // Rediriger après le traitement
    header("Location:avis.php");
    exit();