<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mauri-Drones — Gestion du Catalogue</title>
    <style>
        /* Respect de la charte graphique Mauri-Drones */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        body { 
            background: #14171c; /* Fond sombre signature */
            color: #ffffff;
            font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, Arial, sans-serif; 
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px; /* Centré et compact pour la succession de formulaires */
        }

        /* En-tête */
        header {
            text-align: center;
            margin-bottom: 40px;
        }
        header h1 {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -1px;
        }
        header h1 span {
            color: #4d8ecb; /* Bleu Mauri-Drones */
        }
        header p {
            color: #c8cdd6;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Style commun pour chaque bloc (Formulaires et Tableau) */
        .form-section, .table-section {
            background: #1e222b;
            border: 1px solid #3e4450;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        /* Titres colorés pour bien différencier les sections */
        h2 {
            font-size: 20px;
            margin-bottom: 25px;
            border-bottom: 1px solid #3e4450;
            padding-bottom: 12px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .title-add { color: #4d8ecb; }       /* Bleu pour l'ajout */
        .title-update { color: #f39c12; }    /* Orange pour la modification */
        .title-delete { color: #e74c3c; }    /* Rouge pour la suppression */
        .title-list { color: #ffffff; }      /* Blanc pour la liste */

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #c8cdd6;
            font-size: 14px;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            background: #14171c;
            border: 2px solid #3e4450;
            border-radius: 6px;
            color: #fff;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #4d8ecb;
            outline: none;
        }
        
        /* Textarea spécifique pour les caractéristiques */
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* Disposition des boutons côte à côte */
        .btn-row {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }
        
        /* Couleurs des boutons d'action principale */
        .btn-add { background-color: #4d8ecb; color: white; }
        .btn-add:hover { background-color: #3573b1; }

        .btn-update { background-color: #f39c12; color: white; }
        .btn-update:hover { background-color: #d68910; }

        .btn-delete { background-color: #e74c3c; color: white; }
        .btn-delete:hover { background-color: #c0392b; }

        /* Bouton Annuler identique pour tous */
        .btn-cancel {
            background-color: #3e4450;
            color: #c8cdd6;
        }
        .btn-cancel:hover {
            background-color: #2c3039;
            color: #fff;
        }

        /* Affichage de la table (Données existantes) */
        .table-section {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #3e4450;
            font-size: 14px;
        }
        th {
            color: #4d8ecb;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        tr:hover td {
            background: rgba(77, 142, 203, 0.05);
        }
        .actions-cell button {
            background: transparent;
            border: 1px solid #3e4450;
            color: #c8cdd6;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }
        .actions-cell button:hover {
            border-color: #4d8ecb;
            color: #4d8ecb;
            background: rgba(77, 142, 203, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Mauri-<span>Drones</span></h1>
        <p>Interface d'administration — Formulaires CRUD &amp; Catalogue</p>
    </header>

    <div class="form-section">
        <h2 class="title-add">1. Ajouter un accessoire</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="add_marque">Marque</label>
                <input type="text" name="marque" id="add_marque" class="form-control" placeholder="Ex: DJI, Chasing, Sony..." required>
            </div>

            <div class="form-group">
                <label for="add_nom">Nom de l'accessoire</label>
                <input type="text" name="nom_accessoire" id="add_nom" class="form-control" placeholder="Ex: Batterie Intelligente TB60" required>
            </div>

            <div class="form-group">
                <label for="add_categorie">Catégorie</label>
                <select name="categorie" id="add_categorie" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    <?php for($i = 1; $i <= 13; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="add_compatibilite">Compatibilité drone</label>
                <input type="text" name="compatibilite_drone" id="add_compatibilite" class="form-control" placeholder="Ex: Matrice 300 RTK / M350">
            </div>

            <div class="form-group">
                <label for="add_caracteristiques">Caractéristiques</label>
                <textarea name="caracteristiques" id="add_caracteristiques" class="form-control" placeholder="Spécifications techniques, poids, dimensions..."></textarea>
            </div>

            <div class="form-group">
                <label for="add_prix">Prix (MRU)</label>
                <input type="number" step="0.01" name="prix" id="add_prix" class="form-control" placeholder="Ex: 45000">
            </div>

            <div class="form-group">
                <label for="add_statut">Statut Stock</label>
                <select name="statut_stock" id="add_statut" class="form-control" required>
                    <option value="Sur commande">Sur commande</option>
                    <option value="En stock">En stock</option>
                </select>
            </div>

            <div class="btn-row">
                <button type="submit" name="action" value="create" class="btn btn-add">Ajouter</button>
                <button type="reset" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>


    <div class="form-section">
        <h2 class="title-update">2. Modifier un accessoire</h2>
        <form action="" method="POST">
            
            <div class="form-group">
                <label for="edit_id">ID de l'article à modifier</label>
                <input type="number" name="drone_id" id="edit_id" class="form-control" placeholder="Entrez l'ID exact de l'article à modifier" required>
            </div>

            <div class="form-group">
                <label for="edit_marque">Marque</label>
                <input type="text" name="marque" id="edit_marque" class="form-control" placeholder="Nouvelle ou même marque">
            </div>

            <div class="form-group">
                <label for="edit_nom">Nom de l'accessoire</label>
                <input type="text" name="nom_accessoire" id="edit_nom" class="form-control" placeholder="Nouveau ou même nom">
            </div>

            <div class="form-group">
                <label for="edit_categorie">Catégorie</label>
                <select name="categorie" id="edit_categorie" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <?php for($i = 1; $i <= 13; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
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
                <label for="edit_prix">Prix (MRU)</label>
                <input type="number" step="0.01" name="prix" id="edit_prix" class="form-control" placeholder="Nouveau prix">
            </div>

            <div class="form-group">
                <label for="edit_statut">Statut Stock</label>
                <select name="statut_stock" id="edit_statut" class="form-control">
                    <option value="">-- Modifier le statut --</option>
                    <option value="Sur commande">Sur commande</option>
                    <option value="En stock">En stock</option>
                </select>
            </div>

            <div class="btn-row">
                <button type="submit" name="action" value="update" class="btn btn-update">Modifier</button>
                <button type="reset" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>


    <div class="form-section">
        <h2 class="title-delete">3. Supprimer un accessoire</h2>
        <form action="" method="POST" onsubmit="return confirm('Attention ! Êtes-vous sûr de vouloir supprimer définitivement cet article ?');">
            
            <div class="form-group">
                <label for="delete_id">ID de l'article à supprimer</label>
                <input type="number" name="drone_id" id="delete_id" class="form-control" placeholder="Entrez l'ID de l'article à supprimer" required>
            </div>

            <div class="btn-row">
                <button type="submit" name="action" value="delete" class="btn btn-delete">Supprimer</button>
                <button type="reset" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>


    <div class="table-section">
        <h2 class="title-list">Données en base (Aperçu)</h2>
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
                    <td>1</td>
                    <td>Drone Inspecteur X-12</td>
                    <td>1</td>
                    <td>145 000 MRU</td>
                    <td class="actions-cell">
                        <button onclick="chargerIdFormulaire(1)">Sélectionner</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Caméra Thermique Zenmuse</td>
                    <td>5</td>
                    <td>85 000 MRU</td>
                    <td class="actions-cell">
                        <button onclick="chargerIdFormulaire(2)">Sélectionner</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
    /**
     * Envoie automatiquement l'ID cliqué du tableau
     * dans les champs ID de Modification et de Suppression.
     */
    function chargerIdFormulaire(id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('delete_id').value = id;
    }
</script>

</body>
</html>