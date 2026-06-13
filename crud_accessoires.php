<?php
// -- connexion à la base de donnes "mauridrone" --
$conn = new mysqli("localhost", "root", "", "mauri_drones");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement des actions
$message = "";
$message_type = "success";

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $action = $_POST["action"] ?? '';
    $id = isset($_POST['drone_id']) ? htmlspecialchars($_POST['drone_id']) : " ";
    $marque = isset($_POST['marque']) ? htmlspecialchars($_POST['marque']) : " ";
    $access = isset($_POST['nom_accessoire']) ? htmlspecialchars($_POST['nom_accessoire']) : " ";
    $cat = isset($_POST['categorie']) ? htmlspecialchars($_POST['categorie']) : " ";
    $comp = isset($_POST['compatibilite_drone']) ? htmlspecialchars($_POST['compatibilite_drone']) : " ";
    $car = isset($_POST['caracteristiques']) ? htmlspecialchars($_POST['caracteristiques']) : " ";
    $prix = isset($_POST['prix']) ? (float)$_POST['prix'] : 0.0;

    // -- Create : ajouter une accessoires --
    if($action == "create") {
        if (!empty($marque) && !empty($access) && !empty($cat) && !empty($comp) && !empty($car) && !empty($prix)){
        $stm = $conn -> prepare("INSERT INTO accessoires 
                (marque, nom, id_categorie, compatibilite_drone, caracteristiques, prix_mru)
            VALUES 
                (?,?,?,?,?,?)
        ");
        $stm -> bind_param("ssissd", $marque, $access, $cat, $comp, $car, $prix);
         if($stm -> execute()) {
        $message = "✅ Accessoire ajoute avec succès.";
        header("location:accessoires_form.php?succes=1");
        exit();
        }
    }
    else {
        $message = "Erreur lors de l'ajout : " . $stm->error;
        $message_type = "error";
    }
}
// -- Update : modifier une accessoire --
    elseif($action == "update") {
        if(!empty($id)) {
        $stm = $conn->prepare("SELECT * FROM accessoires WHERE id_accessoire = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $actuel = $stm->get_result()->fetch_assoc();

        $marque = !empty($marque) ? $marque : $actuel['marque'];
        $access = !empty($access) ? $access : $actuel['nom'];
        $cat    = !empty($cat)    ? (int)$cat : (int)$actuel['id_categorie'];
        $comp   = !empty($comp)   ? $comp   : $actuel['compatibilite_drone'];
        $car    = !empty($car)    ? $car    : $actuel['caracteristiques'];
        $prix   = !empty($prix)   ? (float)$prix : (float)$actuel['prix_mru']; 

        $stm2 = $conn -> prepare("
            UPDATE accessoires SET
                marque            = ?,
                nom               = ?,
                id_categorie      = ?,
                compatibilite_drone = ?,
                caracteristiques  = ?,
                prix_mru          = ?
            WHERE id_accessoire = ?
        ");
        $stm2 -> bind_param("ssissdi",$marque, $access, $cat, $comp, $car, $prix, $id);
        if($stm2 -> execute()) {
        $message = "✅ Accessoire modifié avec succès.";
        header("location:accessoires_form.php?succes=1");
        exit();
        }

        else {
        $message = "Erreur lors de modification : " . $stm->error;
        $message_type = "error";
        } }
        else {
            $message      = "Veuillez entrer un ID valide.";
            $message_type = "error";
        }
}
// -- Delete : supprimer une accessoires --
    elseif ($action == 'delete') {
        if(!empty($id)) {
        $stm3 = $conn->prepare("
            DELETE FROM accessoires WHERE id_accessoire = ?
        ");
        $stm3 -> bind_param("i", $id);
        if($stm3->execute()) {
        $message = "🗑️ Accessoire supprimé.";
        header("location:accessoires_form.php?succes=1");
        exit();
    }
    else {
                $message      = "Erreur lors de la suppression : " . $stm->error;
                $message_type = "error";
            }
    }
    else {
        $message      = "Veuillez entrer un ID valide.";
        $message_type = "error";
    }
}
}
if (isset($_GET['succes'])) {
    $message      = "✅ Opération effectuée avec succès.";
    $message_type = "success";
}

// -- recuperer toutes les accessoires --
$result= $conn->query("
    SELECT a.id_accessoire, a.marque, a.nom, c.nom AS categorie, a.prix_mru
    FROM accessoires a
    JOIN categorie c ON a.id_categorie = c.id_categorie
    ORDER BY a.id_accessoire DESC
    ");
$accessoires = $result -> fetch_all(MYSQLI_ASSOC);
?>
