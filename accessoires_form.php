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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mauri-Drones — Gestion des Accessoires</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #0d1117;
            color: #e6edf3;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #161b22;
            border-bottom: 1px solid #21262d;
            padding: 0 40px;
            height: 56px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #e6edf3;
            text-decoration: none;
        }
        .navbar-logo span { color: #1f6feb; }
        .logo-box {
            width: 36px;
            height: 36px;
            background: #0d1117;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ── PAGE LAYOUT ── */
        .page-wrapper {
            max-width: 860px;
            margin: 0 auto;
            padding: 48px 24px 80px;
        }

        /* ── PAGE HEADER ── */
        .page-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #1f6feb;
            margin-bottom: 10px;
        }
        .page-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #e6edf3;
            margin-bottom: 32px;
            line-height: 1.1;
        }
        .page-title span { color: #1f6feb; }

        /* ── TAB SWITCHER ── */
        .tab-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
        }
        .tab-btn {
            padding: 9px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #30363d;
            background: transparent;
            color: #8b949e;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tab-btn:hover {
            background: #21262d;
            color: #e6edf3;
            border-color: #444c56;
        }
        .tab-btn.active-add {
            background: #1f6feb;
            border-color: #1f6feb;
            color: #fff;
        }
        .tab-btn.active-update {
            background: #9e6a03;
            border-color: #9e6a03;
            color: #fff;
        }
        .tab-btn.active-delete {
            background: #b91c1c;
            border-color: #b91c1c;
            color: #fff;
        }
        .tab-btn.active-list {
            background: #21262d;
            border-color: #444c56;
            color: #e6edf3;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: #161b22;
            border: 1px solid #21262d;
            border-radius: 12px;
            padding: 28px 32px 32px;
            display: none;
        }
        .form-card.active { display: block; }

        /* Card header row */
        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .icon-add    { background: rgba(31,111,235,0.2); }
        .icon-update { background: rgba(158,106,3,0.2); }
        .icon-delete { background: rgba(185,28,28,0.2); }
        .icon-list   { background: rgba(139,148,158,0.15); }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            color: #e6edf3;
        }
        .card-subtitle {
            font-size: 13px;
            color: #8b949e;
            margin-top: 3px;
        }

        .badge-id {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            padding: 4px 10px;
            border-radius: 4px;
            background: #21262d;
            color: #8b949e;
            border: 1px solid #30363d;
            text-transform: uppercase;
        }

        /* ── FORM FIELDS ── */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #8b949e;
            margin-bottom: 8px;
        }
        .form-group label .required {
            color: #f85149;
            margin-left: 2px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 6px;
            color: #e6edf3;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none;
        }
        .form-control::placeholder { color: #484f58; }
        .form-control:focus {
            outline: none;
            border-color: #1f6feb;
            box-shadow: 0 0 0 3px rgba(31,111,235,0.15);
        }
        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238b949e' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        /* 2-column grid for wider fields */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }

        /* ── FORM FOOTER / ACTION BUTTON ── */
        .form-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #21262d;
            gap: 12px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary-add {
            background: #1f6feb;
            border-color: #1f6feb;
            color: #fff;
        }
        .btn-primary-add:hover { background: #388bfd; border-color: #388bfd; }

        .btn-primary-update {
            background: #9e6a03;
            border-color: #9e6a03;
            color: #fff;
        }
        .btn-primary-update:hover { background: #bb8009; border-color: #bb8009; }

        .btn-primary-delete {
            background: #b91c1c;
            border-color: #b91c1c;
            color: #fff;
        }
        .btn-primary-delete:hover { background: #dc2626; border-color: #dc2626; }

        .btn-ghost {
            background: transparent;
            border-color: #30363d;
            color: #8b949e;
        }
        .btn-ghost:hover { background: #21262d; color: #e6edf3; border-color: #444c56; }

        /* ── TABLE ── */
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            border-bottom: 1px solid #21262d;
        }
        th {
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #8b949e;
            text-align: left;
        }
        td {
            padding: 13px 14px;
            font-size: 14px;
            color: #c9d1d9;
            border-bottom: 1px solid #161b22;
        }
        tbody tr:hover td { background: rgba(255,255,255,0.02); }

        .td-id {
            color: #484f58;
            font-size: 12px;
            font-family: monospace;
        }
        .td-name { font-weight: 500; color: #e6edf3; }

        .btn-select {
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 500;
            background: transparent;
            border: 1px solid #30363d;
            color: #8b949e;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-select:hover {
            border-color: #1f6feb;
            color: #1f6feb;
            background: rgba(31,111,235,0.08);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="#" class="navbar-logo">
        <div class="logo-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Centre bleu -->
                <rect x="8" y="8" width="8" height="8" rx="2" fill="#1f6feb"/>
                <circle cx="12" cy="12" r="1.5" fill="white"/>
                <!-- Bras -->
                <line x1="8" y1="8" x2="4.5" y2="4.5" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="16" y1="8" x2="19.5" y2="4.5" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="8" y1="16" x2="4.5" y2="19.5" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
                <line x1="16" y1="16" x2="19.5" y2="19.5" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
                <!-- Rotors -->
                <circle cx="4" cy="4" r="2" stroke="#1f6feb" stroke-width="1.2" fill="none"/>
                <circle cx="20" cy="4" r="2" stroke="#1f6feb" stroke-width="1.2" fill="none"/>
                <circle cx="4" cy="20" r="2" stroke="#1f6feb" stroke-width="1.2" fill="none"/>
                <circle cx="20" cy="20" r="2" stroke="#1f6feb" stroke-width="1.2" fill="none"/>
            </svg>
        </div>
        Mauri-<span>Drones</span>
    </a>
</nav>

<div class="page-wrapper">

    <!-- PAGE HEADER -->
    <p class="page-eyebrow">Panneau d'administration</p>
    <h1 class="page-title">Gestion des <span>accessoires</span></h1>

    <!-- TAB BAR -->
    <div class="tab-bar">
        <button class="tab-btn active-add" onclick="switchTab('add', this)">+ Ajouter</button>
        <button class="tab-btn" onclick="switchTab('update', this)">✎ Modifier</button>
        <button class="tab-btn" onclick="switchTab('delete', this)">✕ Supprimer</button>
        <button class="tab-btn" onclick="switchTab('list', this)">☰ Liste</button>
    </div>

    <!-- ── FORMULAIRE AJOUTER ── -->
    <div class="form-card active" id="panel-add">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon icon-add">➕</div>
                <div>
                    <div class="card-title">Nouvel accessoire</div>
                    <div class="card-subtitle">Ajouter un accessoire au catalogue</div>
                </div>
            </div>
            <span class="badge-id">ID Auto</span>
        </div>

        <form action="" method="POST">
            <div class="form-grid-2">
                <div class="form-group">
                    <label for="add_marque">Marque <span class="required">*</span></label>
                    <input type="text" name="marque" id="add_marque" class="form-control" placeholder="Ex : DJI, Sony, PolarPro..." required>
                </div>
                <div class="form-group">
                    <label for="add_nom">Nom de l'accessoire <span class="required">*</span></label>
                    <input type="text" name="nom_accessoire" id="add_nom" class="form-control" placeholder="Ex : Batterie Intelligente TB60" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="add_categorie">Catégorie <span class="required">*</span></label>
                    <select name="categorie" id="add_categorie" class="form-control" required>
                        <option value="">— Sélectionner —</option>
                        <?php for($i = 1; $i <= 13; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add_prix">Prix (MRU)</label>
                    <input type="number" step="0.01" name="prix" id="add_prix" class="form-control" placeholder="Ex : 45 000">
                </div>
            </div>

            <div class="form-group">
                <label for="add_compatibilite">Compatibilité drone</label>
                <input type="text" name="compatibilite_drone" id="add_compatibilite" class="form-control" placeholder="Ex : Matrice 300 RTK / M350">
            </div>

            <div class="form-group">
                <label for="add_caracteristiques">Caractéristiques</label>
                <textarea name="caracteristiques" id="add_caracteristiques" class="form-control" placeholder="Spécifications techniques, poids, dimensions..."></textarea>
            </div>

            <div class="form-group">
                <label for="add_statut">Statut stock <span class="required">*</span></label>
                <select name="statut_stock" id="add_statut" class="form-control" required>
                    <option value="En stock">En stock</option>
                    <option value="Sur commande">Sur commande</option>
                </select>
            </div>

            <div class="form-footer">
                <button type="reset" class="btn btn-ghost">Annuler</button>
                <button type="submit" name="action" value="create" class="btn btn-primary-add">+ Ajouter l'accessoire</button>
            </div>
        </form>
    </div>

    <!-- ── FORMULAIRE MODIFIER ── -->
    <div class="form-card" id="panel-update">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon icon-update">✎</div>
                <div>
                    <div class="card-title">Modifier un accessoire</div>
                    <div class="card-subtitle">Mettre à jour les informations d'un article existant</div>
                </div>
            </div>
        </div>

        <form action="" method="POST">
            <div class="form-group">
                <label for="edit_id">ID de l'article <span class="required">*</span></label>
                <input type="number" name="drone_id" id="edit_id" class="form-control" placeholder="Entrez l'ID exact de l'article à modifier" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="edit_marque">Marque</label>
                    <input type="text" name="marque" id="edit_marque" class="form-control" placeholder="Nouvelle ou même marque">
                </div>
                <div class="form-group">
                    <label for="edit_nom">Nom de l'accessoire</label>
                    <input type="text" name="nom_accessoire" id="edit_nom" class="form-control" placeholder="Nouveau ou même nom">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="edit_categorie">Catégorie</label>
                    <select name="categorie" id="edit_categorie" class="form-control">
                        <option value="">— Sélectionner —</option>
                        <?php for($i = 1; $i <= 13; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_prix">Prix (MRU)</label>
                    <input type="number" step="0.01" name="prix" id="edit_prix" class="form-control" placeholder="Nouveau prix">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_compatibilite">Compatibilité drone</label>
                <input type="text" name="compatibilite_drone" id="edit_compatibilite" class="form-control" placeholder="Nouvelle compatibilité">
            </div>

            <div class="form-group">
                <label for="edit_caracteristiques">Caractéristiques</label>
                <textarea name="caracteristiques" id="edit_caracteristiques" class="form-control" placeholder="Nouvelles caractéristiques"></textarea>
            </div>

            <div class="form-group">
                <label for="edit_statut">Statut stock</label>
                <select name="statut_stock" id="edit_statut" class="form-control">
                    <option value="">— Modifier le statut —</option>
                    <option value="En stock">En stock</option>
                    <option value="Sur commande">Sur commande</option>
                </select>
            </div>

            <div class="form-footer">
                <button type="reset" class="btn btn-ghost">Annuler</button>
                <button type="submit" name="action" value="update" class="btn btn-primary-update">✎ Enregistrer les modifications</button>
            </div>
        </form>
    </div>

    <!-- ── FORMULAIRE SUPPRIMER ── -->
    <div class="form-card" id="panel-delete">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon icon-delete">🗑</div>
                <div>
                    <div class="card-title">Supprimer un accessoire</div>
                    <div class="card-subtitle">Cette action est irréversible</div>
                </div>
            </div>
        </div>

        <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet article ?');">
            <div class="form-group">
                <label for="delete_id">ID de l'article à supprimer <span class="required">*</span></label>
                <input type="number" name="drone_id" id="delete_id" class="form-control" placeholder="Entrez l'ID de l'article à supprimer" required>
            </div>

            <div class="form-footer">
                <button type="reset" class="btn btn-ghost">Annuler</button>
                <button type="submit" name="action" value="delete" class="btn btn-primary-delete">✕ Supprimer l'accessoire</button>
            </div>
        </form>
    </div>

    <!-- ── LISTE / TABLEAU ── -->
    <div class="form-card" id="panel-list">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon icon-list">☰</div>
                <div>
                    <div class="card-title">Catalogue des accessoires</div>
                    <div class="card-subtitle">Cliquez sur « Sélectionner » pour pré-remplir un formulaire</div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom / Modèle</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td-id">#1</td>
                        <td class="td-name">Drone Inspecteur X-12</td>
                        <td>1</td>
                        <td>145 000 MRU</td>
                        <td><button class="btn-select" onclick="chargerIdFormulaire(1)">Sélectionner</button></td>
                    </tr>
                    <tr>
                        <td class="td-id">#2</td>
                        <td class="td-name">Caméra Thermique Zenmuse</td>
                        <td>5</td>
                        <td>85 000 MRU</td>
                        <td><button class="btn-select" onclick="chargerIdFormulaire(2)">Sélectionner</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    const panels = ['add', 'update', 'delete', 'list'];
    const tabActiveClasses = {
        add:    'active-add',
        update: 'active-update',
        delete: 'active-delete',
        list:   'active-list'
    };

    function switchTab(tab, btn) {
        // Hide all panels
        panels.forEach(p => {
            document.getElementById('panel-' + p).classList.remove('active');
        });
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.className = 'tab-btn';
        });
        // Show selected panel and mark button active
        document.getElementById('panel-' + tab).classList.add('active');
        btn.classList.add(tabActiveClasses[tab]);
    }

    function chargerIdFormulaire(id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('delete_id').value = id;
        // Switch to update tab
        const updateBtn = document.querySelectorAll('.tab-btn')[1];
        switchTab('update', updateBtn);
    }
</script>

</body>
</html>
