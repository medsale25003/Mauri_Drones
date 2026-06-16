<?php
$con = mysqli_connect("localhost", "root", "", "mauri_drones");
function securiser($data)
{
    $data = trim($data);
    $data = stripslashes($data);                
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); 

    return $data;
}
$marque = securiser($_POST['marque']);
  $modele = securiser($_POST['modele']) ;
  $categorie = (int)(securiser($_POST[]));
  $autonomie = (int)(securiser($_POST[]));
  $capteur = securiser($_POST[]);
  $portee = (int)(securiser($_POST[]));
  $prix = (int)(securiser($_POST[]));
  $statut_stock =securiser($_POST[]);
if (isset($_POST['ajouter'])){
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion Drones — Mauri-Drones</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
 
  body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: #0f1117;
    color: #e2e8f0;
    min-height: 100vh;
  }
 
  /* ── NAV ── */
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

  /* ── TABS ── */
  .tab-bar { display: flex; gap: 0.5rem; margin-bottom: 2rem; }
  .tab-btn {
    padding: 0.55rem 1.2rem; border-radius: 8px; border: 1px solid #2a2f45;
    background: #1a1f2e; color: #94a3b8; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.18s;
  }
  .tab-btn:hover { border-color: #3b82f6; color: #e2e8f0; }
  .tab-btn.active      { background: #3b82f6; border-color: #3b82f6; color: #fff; }
  .tab-btn.danger      { }
  .tab-btn.danger.active  { background: #dc2626; border-color: #dc2626; color: #fff; }
  .tab-btn.warning.active { background: #374151; border-color: #4b5563; color: #e2e8f0; }
 
  /* ── CARD ── */
  .card { background: #13151e; border: 1px solid #1e2333; border-radius: 16px; padding: 2rem; }
  .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; }
  .card-title-group { display: flex; align-items: center; gap: 12px; }
  .card-icon {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
  }
  .card-icon.add    { background: #1e3a5f; }
  .card-icon.edit   { background: #1e2d1e; }
  .card-icon.delete { background: #3b1616; }
  .card-title { font-size: 1rem; font-weight: 700; color: #e2e8f0; }
  .card-sub   { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
  .badge {
    font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em;
    padding: 3px 10px; border-radius: 20px;
    background: #1e2333; color: #64748b; border: 1px solid #2a2f45;
  }
 
  /* ── FIELDS ── */
  .field-row        { display: grid; grid-template-columns: 1fr 1fr;     gap: 1rem; margin-bottom: 1rem; }
  .field-row.triple { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
  .field-row.single { grid-template-columns: 1fr; }
  .field-group { display: flex; flex-direction: column; gap: 6px; }
 
  label {
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: #94a3b8;
    display: flex; align-items: center; gap: 4px;
  }
  label .req { color: #3b82f6; font-size: 0.85rem; }
 
  input[type="text"], input[type="number"], input[type="url"], select {
    width: 100%; background: #0f1117; border: 1px solid #2a2f45;
    border-radius: 8px; padding: 0.65rem 0.9rem; color: #e2e8f0;
    font-size: 0.9rem; outline: none; transition: border-color 0.18s; appearance: none;
  }
  input::placeholder { color: #334155; }
  input:focus, select:focus { border-color: #3b82f6; }
  select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center; padding-right: 2rem;
  }
 
  /* ── SUBMIT ── */
  .form-footer { margin-top: 1.5rem; display: flex; justify-content: flex-end; }
  .btn-submit {
    padding: 0.65rem 1.8rem; border-radius: 9px; border: none;
    font-size: 0.9rem; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; gap: 8px;
    transition: opacity 0.18s, transform 0.1s;
  }
  .btn-submit:hover  { opacity: 0.88; transform: translateY(-1px); }
  .btn-submit:active { transform: translateY(0); }
  .btn-submit.add    { background: #3b82f6; color: #fff; }
  .btn-submit.edit   { background: #22c55e; color: #fff; }
  .btn-submit.delete { background: #dc2626; color: #fff; }
 
  /* ── TABLEAU ── */
  .table-section { margin-top: 3rem; }
  .table-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
  .table-section-title {
    font-size: 1rem; font-weight: 700; color: #e2e8f0;
    display: flex; align-items: center; gap: 8px;
  }
  .table-section-title::before {
    content: ''; display: inline-block; width: 3px; height: 1.1rem;
    background: #3b82f6; border-radius: 2px;
  }
  .table-count {
    font-size: 0.72rem; font-weight: 700;
    background: #1e2333; border: 1px solid #2a2f45;
    color: #64748b; padding: 3px 10px; border-radius: 20px;
  }
  .table-wrap { background: #13151e; border: 1px solid #1e2333; border-radius: 16px; overflow: hidden; }
  table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
  thead tr { background: #0f1117; border-bottom: 1px solid #1e2333; }
  thead th {
    padding: 0.85rem 1.25rem; text-align: left;
    font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: #475569;
  }
  tbody tr { border-bottom: 1px solid #1a1f2e; transition: background 0.15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #1a1f2e; }
  tbody td { padding: 0.9rem 1.25rem; color: #cbd5e1; vertical-align: middle; }
  .td-id {
    font-family: 'Courier New', monospace; font-size: 0.8rem;
    color: #3b82f6; font-weight: 700; background: #1e2333;
    border: 1px solid #2a2f45; border-radius: 6px; padding: 3px 8px; display: inline-block;
  }
  .td-nom { font-weight: 600; color: #e2e8f0; }
  .statut-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.72rem; font-weight: 600;
    padding: 4px 10px; border-radius: 20px; border: 1px solid;
  }
  .s-actif { background: rgba(34,197,94,.12);  border-color: rgba(34,197,94,.3);  color: #4ade80; }
  .s-maint { background: rgba(249,115,22,.12); border-color: rgba(249,115,22,.3); color: #fb923c; }
  .s-hors  { background: rgba(239,68,68,.12);  border-color: rgba(239,68,68,.3);  color: #f87171; }
 
  .panel { display: none; }
  .panel.active { display: block; }
 
  /* ── TOAST ── */
  #toast {
    position: fixed; bottom: 1.5rem; right: 1.5rem;
    background: #1e2333; border: 1px solid #2a2f45;
    border-radius: 10px; padding: 0.75rem 1.25rem;
    font-size: 0.85rem; color: #e2e8f0;
    opacity: 0; transform: translateY(8px);
    transition: opacity 0.25s, transform 0.25s;
    pointer-events: none; z-index: 100;
  }
  #toast.show { opacity: 1; transform: translateY(0); }
 
  @media(max-width: 640px) {
    .field-row, .field-row.triple { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>
 
<!-- NAV -->
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

 
<!-- MAIN -->
<main>
  <p class="page-label">Panneau d'administration</p>
  <h1>Gestion des <span>drones</span></h1>
 
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
          <div class="card-icon add">🚁</div>
          <div>
            <div class="card-title">Nouveau drone</div>
            <div class="card-sub">Ajouter un drone à la flotte</div>
          </div>
        </div>
        <span class="badge">ID AUTO</span>
      </div>
 
      <div class="field-row">
        <div class="field-group">
          <label>Marque <span class="req">*</span></label>
          <input type="text" name="marque" placeholder="Ex : DJI" required>
        </div>
        <div class="field-group">
          <label>Modèle <span class="req">*</span></label>
          <input type="text" name="modele" placeholder="Ex : Mavic 3" required>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>Catégorie <span class="req">*</span></label>
          <select name="id_categorie" required>
            <option value="">— Sélectionner —</option>
            
          </select>
        </div>
      </div>
 
      <div class="field-row triple">
        <div class="field-group">
          <label>Autonomie (min)</label>
          <input type="number" name="autonomie_m" min="0" placeholder="46">
        </div>
        <div class="field-group">
          <label>Capteur</label>
          <input type="text" name="capteur" placeholder="Ex : 4K">
        </div>
        <div class="field-group">
          <label>Portée (m)</label>
          <input type="number" name="portee_m" min="0" placeholder="12000">
        </div>
      </div>
 
      <div class="field-row">
        <div class="field-group">
          <label>Prix (MRU)</label>
          <input type="number" name="prix_final_MRU" step="0.01" min="0" placeholder="38000">
        </div>
        <div class="field-group">
          <label>Statut stock <span class="req">*</span></label>
          <select name="statut_stock" required>
            <option value="">— Sélectionner —</option>
            <option value="En stock">En stock</option>
            <option value="Sur commande">Sur commande</option>
            <option value="Rupture">Rupture</option>
          </select>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>Lien image (URL)</label>
          <input type="text" name="lien_image" placeholder="https://...">
        </div>
      </div>
 
      <div class="form-footer">
        <button class="btn-submit add" type="submit" name="ajouter">
          ＋ Ajouter le drone
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
            <div class="card-title">Modifier un drone</div>
            <div class="card-sub">Mettre à jour les informations d'un drone</div>
          </div>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>ID Drone <span class="req">*</span></label>
          <input type="number" name="id" placeholder="Ex : 5" min="1" required>
        </div>
      </div>
 
      <div class="field-row">
        <div class="field-group">
          <label>Marque <span class="req">*</span></label>
          <input type="text" name="marque" placeholder="Ex : DJI" required>
        </div>
        <div class="field-group">
          <label>Modèle <span class="req">*</span></label>
          <input type="text" name="modele" placeholder="Ex : Mavic 3" required>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>Catégorie <span class="req">*</span></label>
          <select name="id_categorie" required>
            <option value="">— Sélectionner —</option>
            
          </select>
        </div>
      </div>
 
      <div class="field-row triple">
        <div class="field-group">
          <label>Autonomie (min)</label>
          <input type="number" name="autonomie_m" min="0" placeholder="46">
        </div>
        <div class="field-group">
          <label>Capteur</label>
          <input type="text" name="capteur" placeholder="Ex : 4K">
        </div>
        <div class="field-group">
          <label>Portée (m)</label>
          <input type="number" name="portee_m" min="0" placeholder="12000">
        </div>
      </div>
 
      <div class="field-row">
        <div class="field-group">
          <label>Prix (MRU)</label>
          <input type="number" name="prix_final_MRU" step="0.01" min="0" placeholder="38000">
        </div>
        <div class="field-group">
          <label>Statut stock <span class="req">*</span></label>
          <select name="statut_stock" required>
            <option value="">— Sélectionner —</option>
            <option value="En stock">En stock</option>
            <option value="Sur commande">Sur commande</option>
            <option value="Rupture">Rupture</option>
          </select>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>Lien image (URL)</label>
          <input type="text" name="lien_image" placeholder="https://...">
        </div>
      </div>
 
      <div class="form-footer">
        <button class="btn-submit edit" type="submit" name="modifier">
          ✔ Enregistrer les modifications
        </button>
      </div>
    </div>
  </div>
  </form>
 
 
  <!-- ══ SUPPRIMER ══ -->
  <form action="" method="post" name="f3">
  <div class="panel" id="panel-delete">
    <div class="card">
      <div class="card-header">
        <div class="card-title-group">
          <div class="card-icon delete">✕</div>
          <div>
            <div class="card-title">Supprimer un drone</div>
            <div class="card-sub">Cette action est irréversible</div>
          </div>
        </div>
      </div>
 
      <div class="field-row single">
        <div class="field-group">
          <label>ID Drone <span class="req">*</span></label>
          <input type="number" name="id" placeholder="Ex : 5" min="1" required>
        </div>
      </div>
 
      <div class="form-footer">
        <button class="btn-submit delete" type="submit" name="supprimer"
                onclick="return confirm('Supprimer ce drone définitivement ?')">
          ✕ Supprimer le drone
        </button>
      </div>
    </div>
  </div>
  </form>
 
 
  <!-- ══ TABLEAU DRONES ══ -->
  <div class="table-section">
    <div class="table-section-header">
      <div class="table-section-title">Drones enregistrés</div>
      <span class="table-count" id="drone-count">0 entrée(s)</span>
    </div>
 
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Marque / Modèle</th>
            <th>Catégorie</th>
            <th>Autonomie</th>
            <th>Prix (MRU)</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody id="drones-tbody">
          
        </tbody>
      </table>
    </div>
  </div>
 
</main>
 
<!-- TOAST -->
<div id="toast"></div>
 
<script>
  // Compteur tableau
  const rows = document.querySelectorAll('#drones-tbody tr');
  document.getElementById('drone-count').textContent = rows.length + ' entrée(s)';
 
  function switchTab(tab) {
    ['add', 'edit', 'delete'].forEach(t => {
      document.getElementById('panel-' + t).classList.remove('active');
      document.getElementById('tab-' + t).classList.remove('active');
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
</script>
 
<?php if (isset($_GET['succes']) && $_GET['succes'] == 1): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      showToast('✓ Drone ajouté avec succès !', '#22c55e');
      window.history.replaceState({}, document.title, 'gestion_drones.php');
    }, 150);
  });
</script>
<?php endif; ?>
 
<?php if (isset($_GET['succes']) && $_GET['succes'] == 2): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      showToast('✎ Drone modifié avec succès !', '#3b82f6');
      window.history.replaceState({}, document.title, 'gestion_drones.php');
    }, 150);
  });
</script>
<?php endif; ?>
 
<?php if (isset($_GET['succes']) && $_GET['succes'] == 3): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      showToast('✕ Drone supprimé.', '#dc2626');
      window.history.replaceState({}, document.title, 'gestion_drones.php');
    }, 150);
  });
</script>
<?php endif; ?>
 
</body>
</html>
 