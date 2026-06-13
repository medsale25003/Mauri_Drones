<?php 
$con=mysqli_connect("localhost","root","","mauri_drones");
$message='';

if(isset($_POST['ajouter'])){
  $nom= isset($_POST['nom']) ? trim(htmlspecialchars($_POST['nom'])) : '';
  $type=isset($_POST['type']) ? trim(htmlspecialchars($_POST['type'])) : '';
      if(!empty($nom) and !empty($type)){
      $req="insert into categorie (nom,type) values (?,?)";
      $stmt=$con->prepare($req);
      $stmt->bind_param("ss",$nom,$type);
      if($stmt->execute()){
       header("location:categorie_formulaire.php?succes=1");
       exit();
      }
      else "<script>alert('Erreur lors de la sauvagarde dans la base !')</script>";
    }
}

if(isset($_POST['modifier'])){
  $id= isset($_POST['id']) ? trim(htmlspecialchars($_POST['id'])) : '';
  $nom= isset($_POST['nom1']) ? trim(htmlspecialchars($_POST['nom1'])) : '';
  $type=isset($_POST['type1']) ? trim(htmlspecialchars($_POST['type1'])) : '';
  $req="update categorie set nom=?, type=? where id_categorie=?";
  $stmt=$con->prepare($req);
  $stmt->bind_param('ssi',$nom,$type,$id);
  if($stmt->execute()){
    header("location:categorie_formulaire.php?succes=2");
    exit();
  }
  else "<script>alert('Erreur lors de la sauvagarde dans la base !')</script>";
}

if(isset($_POST['supprimer'])){
  $id= isset($_POST['id']) ? trim(htmlspecialchars($_POST['id'])) : '';
  $req="delete from categorie where id_categorie=?";
  $stmt=$con->prepare($req);
  $stmt->bind_param('i',$id);
  if($stmt->execute()){
    header("location:categorie_formulaire.php?succes=3");
    exit();
  }
}
$req="select * from categorie";
$res=mysqli_query($con,$req);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestion Catégories — Mauri-Drones</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background: #0f1117;
      color: #e2e8f0;
      min-height: 100vh;
    }

    /* ── NAV ── */
    nav {
      background: #13151e;
      border-bottom: 1px solid #1e2333;
      padding: 0 2rem;
      height: 56px;
      display: flex;
      align-items: center;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
      font-size: 1.1rem;
      color: #e2e8f0;
      text-decoration: none;
    }
    .logo-icon {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .logo-icon img { width: 40px; height: 40px; object-fit: contain; }

    /* ── MAIN ── */
    main {
      max-width: 900px;
      margin: 0 auto;
      padding: 3rem 2rem;
    }

    .page-label {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      color: #3b82f6;
      text-transform: uppercase;
      margin-bottom: 0.5rem;
    }
    h1 {
      font-size: 2rem;
      font-weight: 800;
      color: #e2e8f0;
      margin-bottom: 2rem;
    }
    h1 span { color: #3b82f6; }

    /* ── ACTION TABS ── */
    .tab-bar {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 2rem;
    }
    .tab-btn {
      padding: 0.55rem 1.2rem;
      border-radius: 8px;
      border: 1px solid #2a2f45;
      background: #1a1f2e;
      color: #94a3b8;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.18s;
    }
    .tab-btn:hover { border-color: #3b82f6; color: #e2e8f0; }
    .tab-btn.active {
      background: #3b82f6;
      border-color: #3b82f6;
      color: #fff;
    }
    .tab-btn.danger.active {
      background: #dc2626;
      border-color: #dc2626;
      color: #fff;
    }
    .tab-btn.warning.active {
      background: #374151;
      border-color: #4b5563;
      color: #e2e8f0;
    }

    /* ── CARD ── */
    .card {
      background: #13151e;
      border: 1px solid #1e2333;
      border-radius: 16px;
      padding: 2rem;
    }
    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.75rem;
    }
    .card-title-group { display: flex; align-items: center; gap: 12px; }
    .card-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }
    .card-icon.add    { background: #1e3a5f; }
    .card-icon.edit   { background: #1e2d1e; }
    .card-icon.delete { background: #3b1616; }

    .card-title { font-size: 1rem; font-weight: 700; color: #e2e8f0; }
    .card-sub   { font-size: 0.78rem; color: #64748b; margin-top: 2px; }

    .badge {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      padding: 3px 10px;
      border-radius: 20px;
      background: #1e2333;
      color: #64748b;
      border: 1px solid #2a2f45;
    }

    /* ── FIELDS ── */
    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .field-row.single { grid-template-columns: 1fr; }
    .field-group { display: flex; flex-direction: column; gap: 6px; }

    label {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #94a3b8;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    label .req { color: #3b82f6; font-size: 0.85rem; }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      background: #0f1117;
      border: 1px solid #2a2f45;
      border-radius: 8px;
      padding: 0.65rem 0.9rem;
      color: #e2e8f0;
      font-size: 0.9rem;
      outline: none;
      transition: border-color 0.18s;
      appearance: none;
    }
    input::placeholder { color: #334155; }
    input:focus, select:focus { border-color: #3b82f6; }
    select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 2rem; }

    /* disabled id field */
    input.auto-id {
      border-style: dashed;
      color: #64748b;
      cursor: not-allowed;
    }

    /* ── SUBMIT ── */
    .form-footer { margin-top: 1.5rem; display: flex; justify-content: flex-end; }
    .btn-submit {
      padding: 0.65rem 1.8rem;
      border-radius: 9px;
      border: none;
      font-size: 0.9rem;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: opacity 0.18s, transform 0.1s;
    }
    .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit.add    { background: #3b82f6; color: #fff; }
    .btn-submit.edit   { background: #22c55e; color: #fff; }
    .btn-submit.delete { background: #dc2626; color: #fff; }

    /* ── TABLE CATÉGORIES ── */
    .table-section {
      margin-top: 3rem;
    }
    .table-section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }
    .table-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: #e2e8f0;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .table-section-title::before {
      content: '';
      display: inline-block;
      width: 3px;
      height: 1.1rem;
      background: #3b82f6;
      border-radius: 2px;
    }
    .table-count {
      font-size: 0.72rem;
      font-weight: 700;
      background: #1e2333;
      border: 1px solid #2a2f45;
      color: #64748b;
      padding: 3px 10px;
      border-radius: 20px;
    }
    .table-wrap {
      background: #13151e;
      border: 1px solid #1e2333;
      border-radius: 16px;
      overflow: hidden;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.875rem;
    }
    thead tr {
      background: #0f1117;
      border-bottom: 1px solid #1e2333;
    }
    thead th {
      padding: 0.85rem 1.25rem;
      text-align: left;
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #475569;
    }
    thead th:first-child { width: 80px; }
    tbody tr {
      border-bottom: 1px solid #1a1f2e;
      transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #1a1f2e; }
    tbody td {
      padding: 0.9rem 1.25rem;
      color: #cbd5e1;
      vertical-align: middle;
    }
    .td-id {
      font-family: 'Courier New', monospace;
      font-size: 0.8rem;
      color: #3b82f6;
      font-weight: 700;
      background: #1e2333;
      border: 1px solid #2a2f45;
      border-radius: 6px;
      padding: 3px 8px;
      display: inline-block;
    }
    .td-nom { font-weight: 600; color: #e2e8f0; }
    .type-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.72rem;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
      border: 1px solid;
    }
    .type-badge.loisir       { background: #1e3a5f22; border-color: #3b82f644; color: #60a5fa; }
    .type-badge.pro          { background: #16302022; border-color: #22c55e44; color: #4ade80; }
    .type-badge.camera       { background: #2d1b4e22; border-color: #a855f744; color: #c084fc; }
    .type-badge.accessoire   { background: #2d1f0022; border-color: #f59e0b44; color: #fbbf24; }
    .type-badge.piece        { background: #2d100022; border-color: #f97316; color: #fb923c; }
    .type-badge.default      { background: #1e233322; border-color: #2a2f45; color: #94a3b8; }
    .table-empty {
      text-align: center;
      padding: 3rem 1rem;
      color: #334155;
      font-size: 0.9rem;
    }
    .table-empty span { display: block; font-size: 2rem; margin-bottom: 0.5rem; }

    .panel { display: none; }
    .panel.active { display: block; }

    /* ── TOAST ── */
    #toast {
      position: fixed;
      bottom: 1.5rem;
      right: 1.5rem;
      background: #1e2333;
      border: 1px solid #2a2f45;
      border-radius: 10px;
      padding: 0.75rem 1.25rem;
      font-size: 0.85rem;
      color: #e2e8f0;
      opacity: 0;
      transform: translateY(8px);
      transition: opacity 0.25s, transform 0.25s;
      pointer-events: none;
      z-index: 100;
    }
    #toast.show { opacity: 1; transform: translateY(0); }

    @media(max-width: 600px) {
      .field-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <a class="logo" href="#">
    <div class="logo-icon">
      <img src="logoPI.png" alt="Mauri-Drones logo" />
    </div>
    Mauri-Drones
  </a>
</nav>

<!-- MAIN -->
<main>
  <p class="page-label">Panneau d'administration</p>
  <h1>Gestion des <span>catégories</span></h1>

  <!-- TABS -->
  <div class="tab-bar">
    <button class="tab-btn active" id="tab-add"    onclick="switchTab('add')">
      <span>＋</span> Ajouter
    </button>
    <button class="tab-btn warning" id="tab-edit"  onclick="switchTab('edit')">
      <span>✎</span> Modifier
    </button>
    <button class="tab-btn danger"  id="tab-delete" onclick="switchTab('delete')">
      <span>✕</span> Supprimer
    </button>
  </div>

  <!-- ══ AJOUTER ══ -->
 <form action="" method="post" name="f1">
  <div class="panel active" id="panel-add">
    <div class="card">
      <div class="card-header">
        <div class="card-title-group">
          <div class="card-icon add">➕</div>
          <div>
            <div class="card-title">Nouvelle catégorie</div>
            <div class="card-sub">Ajouter une catégorie au catalogue</div>
          </div>
        </div>
        <span class="badge">ID AUTO</span>
      </div>

      <div class="field-row single">
        <div class="field-group">
          <label>Nom <span class="req">*</span></label>
          <input type="text" id="add-nom" placeholder="Ex : Caméras thermiques" value="<?php echo @$nom ?>" name="nom">
        </div>
      </div>
      <div class="field-row single">
        <div class="field-group">
          <label>Type<span class="req">*</span></label>
          <select id="add-type" name="type" required>
            <option value="" disabled selected>— Sélectionner —</option>
            <option value="Drone" <?php echo (isset($type) && $type=='Drone') ? 'selected' : ''?>>Drone</option>
            <option value="Accessoire" <?php echo (isset($type) && $type=='Accessoire') ? 'selected' : ''?>>Accessoire</option>
            <option value="Camera" <?php echo (isset($type) && $type=='Camera') ? 'selected' : ''?>>Caméra</option>
          </select>
        </div>
      </div>

      <div class="form-footer">
        <button class="btn-submit add" type="submit" name="ajouter">
          ＋ Ajouter la catégorie
        </button>
      </div>
    </div>
  </div>
  </form>

  <!-- ══ MODIFIER ══ -->
  <form action="" method="post" name="f2">
  <div class="panel" id="panel-edit">
    <div class="card">
      <div class="card-header">
        <div class="card-title-group">
          <div class="card-icon edit">✎</div>
          <div>
            <div class="card-title">Modifier une catégorie</div>
            <div class="card-sub">Mettre à jour les informations d'une catégorie</div>
          </div>
        </div>
      </div>

      <div class="field-row single">
        <div class="field-group">
          <label>ID Catégorie <span class="req">*</span></label>
          <input type="number" id="edit-id" placeholder="Ex : 3" name="id">
        </div>
      </div>
      <div class="field-row single">
        <div class="field-group">
          <label>Nouveau nom <span class="req">*</span></label>
          <input type="text" id="edit-nom" placeholder="Ex : Drones agricoles" name="nom1">
        </div>
      </div>
      <div class="field-row single">
        <div class="field-group">
          <label>Nouveau type <span class="req">*</span></label>
          <select id="edit-type" name="type1">
            <option value="" disabled selected>— Sélectionner —</option>
            <option value="Drone">Drone</option>
            <option value="Camera">Camera</option>
            <option value="Accessoire">Accessoire</option>
          </select>
        </div>
      </div>

      <div class="form-footer">
        <button class="btn-submit edit" name="modifier" type="submit">
          ✔ Enregistrer les modifications
        </button>
      </div>
    </div>
  </div>
  </form>

  <!-- ══ SUPPRIMER ══ -->
   <form action="" name="f3" method="post">
  <div class="panel" id="panel-delete">
    <div class="card">
      <div class="card-header">
        <div class="card-title-group">
          <div class="card-icon delete">✕</div>
          <div>
            <div class="card-title">Supprimer une catégorie</div>
            <div class="card-sub">Cette action est irréversible</div>
          </div>
        </div>
      </div>

      <div class="field-row single">
        <div class="field-group">
          <label>ID Catégorie <span class="req">*</span></label>
          <input type="number" id="del-id" placeholder="Ex : 5" min="1" name="id">
        </div>
      </div>

      <div class="form-footer">
        <button class="btn-submit delete" name="supprimer" type="submit">
          ✕ Supprimer la catégorie
        </button>
      </div>
    </div>
  </div>
   </form>
  <!-- ══ TABLEAU CATÉGORIES ══ -->
  <div class="table-section">
    <div class="table-section-header">
      <div class="table-section-title">Catégories disponibles</div>
      <!-- Tu peux remplacer le chiffre ici dynamiquement avec PHP :  -->
      <span class="table-count" id="cat-count">0 entrée(s)</span>
    </div>

    <div class="table-wrap">
      <table id="categories-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody id="categories-tbody">
          <?php   
          while($tab=mysqli_fetch_assoc($res)){
          echo "<tr>";
          echo "<td><span class='td-id'>".$tab['id_categorie']."</span></td>";
          echo "<td class='td-nom'>".$tab['nom'],"</td>";
          echo "<td><span class='type-badge loisir'>".$tab['type']."</span></td>";
          echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</main>

<!-- TOAST -->
<div id="toast"></div>

<script>
  // Met à jour le compteur du tableau
  const rows = document.querySelectorAll('#categories-tbody tr');
  document.getElementById('cat-count').textContent = rows.length + ' entrée(s)';

  function switchTab(tab) {
    ['add','edit','delete'].forEach(t => {
      document.getElementById('panel-' + t).classList.remove('active');
      const btn = document.getElementById('tab-' + t);
      btn.classList.remove('active');
    });
    document.getElementById('panel-' + tab).classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
  }

  function showToast(msg, color = '#3b82f6') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.borderColor = color;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  function handleDelete() {
    const id = document.getElementById('del-id').value.trim();
    if (!id) return showToast('⚠ Veuillez entrer un ID.', '#f59e0b');
    showToast('✕ Catégorie #' + id + ' supprimée.', '#dc2626');
    document.getElementById('del-id').value = '';
  }
</script>
<?php if(isset($_GET['succes']) && $_GET['succes']==1): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne Ajoutée dans la base !");
      window.history.replaceState({},document.title,"categorie_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>
<?php if(isset($_GET['succes']) && $_GET['succes']==2): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne modifiée avec succés !");
      window.history.replaceState({},document.title,"categorie_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>
<?php if(isset($_GET['succes']) && $_GET['succes']==3): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne supprimée avec succés !");
      window.history.replaceState({},document.title,"categorie_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>
</body>
</html>