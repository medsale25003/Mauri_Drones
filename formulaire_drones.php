<?php
// ─── Connexion MySQL PDO ─────────────────────────────────────
$host   = 'localhost';
$dbname = 'mauri_drones';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='color:red;padding:20px'>Erreur connexion : " . htmlspecialchars($e->getMessage()) . "</div>");
}

function h($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

// ─── Chargement des données ──────────────────────────────────
function loadDrones($pdo): array {
    return $pdo->query("SELECT d.*, c.nom as nom_categorie
                        FROM drones d
                        LEFT JOIN categorie c ON d.id_categorie = c.id_categorie
                        ORDER BY d.id_drone DESC")->fetchAll();
}

function loadCategories($pdo): array {
    return $pdo->query("SELECT * FROM categorie WHERE type='drone' ORDER BY nom")->fetchAll();
}

$message     = '';
$messageType = '';
$drones      = loadDrones($pdo);
$categories  = loadCategories($pdo);
$mode        = 'create';

if (isset($_GET['mode']) && in_array($_GET['mode'], ['create','update','delete'])) {
    $mode = $_GET['mode'];
}

// ─── Actions POST ────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $erreurs = [];
        foreach (['marque','modele','id_categorie','statut_stock'] as $c) {
            if (empty(trim($_POST[$c] ?? ''))) $erreurs[] = "Le champ « $c » est obligatoire.";
        }

        if (!empty($erreurs)) {
            $message     = implode(' · ', $erreurs);
            $messageType = 'error';
        } else {
            if ($action === 'create') {
                $sql = "INSERT INTO drones
                        (marque, modele, id_categorie, autonomie_m, capteur, portee_m, prix_final_MRU, statut_stock, lien_image)
                        VALUES
                        (:marque, :modele, :id_categorie, :autonomie_m, :capteur, :portee_m, :prix_final_MRU, :statut_stock, :lien_image)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':marque'         => trim($_POST['marque']),
                    ':modele'         => trim($_POST['modele']),
                    ':id_categorie'   => (int)$_POST['id_categorie'],
                    ':autonomie_m'    => (int)$_POST['autonomie_m'],
                    ':capteur'        => trim($_POST['capteur']),
                    ':portee_m'       => (int)$_POST['portee_m'],
                    ':prix_final_MRU' => (float)$_POST['prix_final_MRU'],
                    ':statut_stock'   => $_POST['statut_stock'],
                    ':lien_image'     => trim($_POST['lien_image']),
                ]);
                $message     = "Drone ajouté avec succès (ID : " . $pdo->lastInsertId() . ").";
                $messageType = 'success';
                $mode        = 'create';

            } elseif ($action === 'update') {
                $sql = "UPDATE drones SET
                        marque=:marque, modele=:modele, id_categorie=:id_categorie,
                        autonomie_m=:autonomie_m, capteur=:capteur, portee_m=:portee_m,
                        prix_final_MRU=:prix_final_MRU, statut_stock=:statut_stock, lien_image=:lien_image
                        WHERE id_drone=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':marque'         => trim($_POST['marque']),
                    ':modele'         => trim($_POST['modele']),
                    ':id_categorie'   => (int)$_POST['id_categorie'],
                    ':autonomie_m'    => (int)$_POST['autonomie_m'],
                    ':capteur'        => trim($_POST['capteur']),
                    ':portee_m'       => (int)$_POST['portee_m'],
                    ':prix_final_MRU' => (float)$_POST['prix_final_MRU'],
                    ':statut_stock'   => $_POST['statut_stock'],
                    ':lien_image'     => trim($_POST['lien_image']),
                    ':id'             => (int)$_POST['id'],
                ]);
                $message     = "Drone modifié avec succès.";
                $messageType = 'success';
                $mode        = 'update';
            }
        }
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM drones WHERE id_drone = :id");
        $stmt->execute([':id' => (int)$_POST['id']]);
        $message     = "Drone supprimé.";
        $messageType = 'success';
        $mode        = 'delete';
    }

    $drones = loadDrones($pdo);
}

// ─── Drone sélectionné pour modifier ────────────────────────
$droneEdit = null;
if ($mode === 'update' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM drones WHERE id_drone = :id");
    $stmt->execute([':id' => (int)$_GET['id']]);
    $droneEdit = $stmt->fetch();
}

// ─── Statut badge ────────────────────────────────────────────
function statutClass($s): string {
    return match($s) {
        'En stock'     => 's-actif',
        'Sur commande' => 's-maint',
        default        => 's-hors',
    };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion Drones — Mauri-Drones</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --bg:       #0f1117;
  --surface:  #161b22;
  --card:     #1c2128;
  --border:   #2d333b;
  --border2:  #373e47;
  --text:     #cdd9e5;
  --muted:    #768390;
  --blue:     #4d8ecb;
  --blue-h:   #5a9fd4;
  --white:    #ffffff;
  --green:    #22c55e;
  --orange:   #f97316;
  --red:      #ef4444;
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
body {
  font-family: 'Space Grotesk', -apple-system, sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  font-size: 14px;
}
nav {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  height: 56px;
  display: flex;
  align-items: center;
  padding: 0 28px;
  gap: 10px;
}
.nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
.nav-logo svg { width: 28px; height: 28px; }
.nav-logo-text { font-size: 1rem; font-weight: 700; color: var(--white); letter-spacing: -.3px; }
.page { max-width: 820px; margin: 0 auto; padding: 56px 24px 80px; }
.eyebrow { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: var(--blue); margin-bottom: 10px; }
.page-title { font-size: 2.2rem; font-weight: 700; color: var(--white); letter-spacing: -.5px; line-height: 1.15; margin-bottom: 36px; }
.page-title span { color: var(--blue); }
.tabs { display: flex; gap: 10px; margin-bottom: 36px; }
.tab { display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border-radius: 10px; font-family: inherit; font-size: .875rem; font-weight: 600; cursor: pointer; text-decoration: none; border: 1px solid transparent; transition: background .15s, border-color .15s, color .15s; }
.tab:hover { opacity: .9; }
.tab-create { background: var(--blue); color: #fff; border-color: var(--blue); }
.tab-update { background: var(--card); color: var(--text); border-color: var(--border2); }
.tab-update:hover, .tab-update.active { border-color: var(--blue); color: var(--white); background: rgba(77,142,203,.12); }
.tab-delete { background: var(--card); color: var(--text); border-color: var(--border2); }
.tab-delete:hover, .tab-delete.active { border-color: var(--red); color: #f87171; background: rgba(239,68,68,.1); }
.card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.card-head { padding: 22px 28px; display: flex; align-items: flex-start; gap: 14px; border-bottom: 1px solid var(--border); position: relative; }
.head-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(77,142,203,.18); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.head-icon svg { width: 20px; height: 20px; color: var(--blue); }
.head-info h3 { font-size: 1rem; font-weight: 600; color: var(--white); margin-bottom: 3px; }
.head-info p { font-size: .8rem; color: var(--muted); }
.id-badge { position: absolute; right: 28px; top: 50%; transform: translateY(-50%); background: var(--border2); color: var(--muted); font-size: .68rem; font-weight: 700; letter-spacing: .1em; padding: 4px 10px; border-radius: 6px; }
.card-body { padding: 28px; }
.alert { border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; font-size: .85rem; border-left: 3px solid; display: flex; gap: 10px; align-items: center; }
.alert.success { background: #0a1f10; border-color: var(--green); color: #86efac; }
.alert.error   { background: #1f0a0a; border-color: var(--red);   color: #fca5a5; }
.field { margin-bottom: 22px; }
.field-row   { display: grid; grid-template-columns: 1fr 1fr;     gap: 18px; margin-bottom: 22px; }
.field-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 22px; }
label.lbl { display: block; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; color: var(--muted); margin-bottom: 8px; }
label.lbl .req { color: var(--blue); margin-left: 2px; }
input[type=text], input[type=number], input[type=url], select {
  width: 100%; background: var(--surface); border: 1px solid var(--border2); color: var(--text);
  padding: 11px 14px; border-radius: 8px; font-family: inherit; font-size: .9rem;
  transition: border-color .2s, box-shadow .2s; appearance: none;
}
input:focus, select:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(77,142,203,.14); }
input::placeholder { color: var(--border2); }
select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23768390' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
select option { background: var(--surface); }
.form-footer { padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 24px; border: none; border-radius: 10px; font-family: inherit; font-size: .875rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: opacity .15s, transform .1s; }
.btn:hover { opacity: .88; transform: translateY(-1px); }
.btn-blue  { background: var(--blue); color: #fff; }
.btn-red   { background: var(--red);  color: #fff; }
.btn-ghost { background: var(--border2); color: var(--text); }
.drone-list { display: flex; flex-direction: column; gap: 8px; }
.drone-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 9px; border: 1px solid var(--border2); cursor: pointer; text-decoration: none; transition: background .12s, border-color .12s; background: var(--surface); }
.drone-item:hover { border-color: var(--blue); background: rgba(77,142,203,.07); }
.di-id   { width: 36px; font-size: .75rem; color: var(--muted); font-weight: 600; }
.di-info { flex: 1; }
.di-name { font-weight: 600; color: var(--white); font-size: .9rem; }
.di-sub  { font-size: .75rem; color: var(--muted); margin-top: 2px; }
.di-status { font-size: .72rem; font-weight: 600; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
.s-actif { background: rgba(34,197,94,.12);  color: #4ade80; }
.s-maint { background: rgba(249,115,22,.12); color: #fb923c; }
.s-hors  { background: rgba(239,68,68,.12);  color: #f87171; }
.di-arrow { color: var(--muted); font-size: 1rem; }
.empty-list { text-align: center; padding: 40px; color: var(--muted); font-size: .9rem; }
</style>
</head>
<body>

<nav>
  <a href="?" class="nav-logo">
    <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
      <line x1="9" y1="9" x2="27" y2="27" stroke="#c8cdd6" stroke-width="2.2" stroke-linecap="round"/>
      <line x1="27" y1="9" x2="9" y2="27" stroke="#c8cdd6" stroke-width="2.2" stroke-linecap="round"/>
      <rect x="14" y="14" width="8" height="8" rx="2" fill="#3e4450" stroke="#c8cdd6" stroke-width="1.2"/>
      <circle cx="18" cy="18" r="3.5" fill="#0b1018" stroke="#4d8ecb" stroke-width="1.5"/>
      <circle cx="18" cy="18" r="2" fill="#4d8ecb"/>
      <circle cx="9"  cy="9"  r="4" fill="#3e4450" stroke="#c8cdd6" stroke-width="1.2"/>
      <ellipse cx="9"  cy="9"  rx="7" ry="1.5" fill="#c8cdd6" opacity=".5"/>
      <circle cx="27" cy="9"  r="4" fill="#3e4450" stroke="#c8cdd6" stroke-width="1.2"/>
      <ellipse cx="27" cy="9"  rx="7" ry="1.5" fill="#c8cdd6" opacity=".5"/>
      <circle cx="9"  cy="27" r="4" fill="#3e4450" stroke="#c8cdd6" stroke-width="1.2"/>
      <ellipse cx="9"  cy="27" rx="7" ry="1.5" fill="#c8cdd6" opacity=".5"/>
      <circle cx="27" cy="27" r="4" fill="#3e4450" stroke="#c8cdd6" stroke-width="1.2"/>
      <ellipse cx="27" cy="27" rx="7" ry="1.5" fill="#c8cdd6" opacity=".5"/>
    </svg>
    <span class="nav-logo-text">Mauri-Drones</span>
  </a>
</nav>

<div class="page">

  <div class="eyebrow">Panneau d'administration</div>
  <h1 class="page-title">Gestion des <span>drones</span></h1>

  <div class="tabs">
    <a href="?mode=create" class="tab tab-create">
      <svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M10 4v12M4 10h12"/></svg>
      Ajouter
    </a>
    <a href="?mode=update" class="tab tab-update <?= $mode==='update'?'active':'' ?>">
      <svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5l4 4m-9 8H3v-3l8-8 3 3-8 8z"/></svg>
      Modifier
    </a>
    <a href="?mode=delete" class="tab tab-delete <?= $mode==='delete'?'active':'' ?>">
      <svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 5l10 10M15 5L5 15"/></svg>
      Supprimer
    </a>
  </div>

  <?php if ($message): ?>
    <div class="alert <?= $messageType ?>">
      <?= $messageType === 'success' ? '✓' : '!' ?>
      <?= h($message) ?>
    </div>
  <?php endif; ?>

  <!-- ══ MODE : AJOUTER ══ -->
  <?php if ($mode === 'create'): ?>
  <div class="card">
    <div class="card-head">
      <div class="head-icon">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M10 4v12M4 10h12"/></svg>
      </div>
      <div class="head-info">
        <h3>Nouveau drone</h3>
        <p>Ajouter un drone à la flotte</p>
      </div>
      <div class="id-badge">ID AUTO</div>
    </div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="action" value="create">

        <div class="field-row">
          <div>
            <label class="lbl">Marque <span class="req">*</span></label>
            <input type="text" name="marque" placeholder="Ex : DJI" required>
          </div>
          <div>
            <label class="lbl">Modèle <span class="req">*</span></label>
            <input type="text" name="modele" placeholder="Ex : Mavic 3" required>
          </div>
        </div>

        <div class="field">
          <label class="lbl">Catégorie <span class="req">*</span></label>
          <select name="id_categorie" required>
            <option value="">— Sélectionner —</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= (int)$cat['id_categorie'] ?>"><?= h($cat['nom']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field-row-3">
          <div>
            <label class="lbl">Autonomie (min)</label>
            <input type="number" name="autonomie_m" min="0" placeholder="46">
          </div>
          <div>
            <label class="lbl">Capteur</label>
            <input type="text" name="capteur" placeholder="Ex : 4K">
          </div>
          <div>
            <label class="lbl">Portée (m)</label>
            <input type="number" name="portee_m" min="0" placeholder="12000">
          </div>
        </div>

        <div class="field-row">
          <div>
            <label class="lbl">Prix (MRU)</label>
            <input type="number" name="prix_final_MRU" step="0.01" min="0" placeholder="38000">
          </div>
          <div>
            <label class="lbl">Statut stock <span class="req">*</span></label>
            <select name="statut_stock" required>
              <option value="">— Sélectionner —</option>
              <option value="En stock">En stock</option>
              <option value="Sur commande">Sur commande</option>
              <option value="Rupture">Rupture</option>
            </select>
          </div>
        </div>

        <div class="field">
          <label class="lbl">Lien image (URL)</label>
          <input type="text" name="lien_image" placeholder="https://...">
        </div>

        <div class="form-footer">
          <button type="submit" class="btn btn-blue">+ Ajouter le drone</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══ MODE : MODIFIER ══ -->
  <?php elseif ($mode === 'update'): ?>
  <div class="card">
    <div class="card-head">
      <div class="head-icon">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5l4 4m-9 8H3v-3l8-8 3 3-8 8z"/></svg>
      </div>
      <div class="head-info">
        <h3><?= $droneEdit ? 'Modifier · '.h($droneEdit['marque']).' '.h($droneEdit['modele']) : 'Sélectionner un drone' ?></h3>
        <p><?= $droneEdit ? 'Mettre à jour les informations' : 'Choisissez le drone à modifier' ?></p>
      </div>
    </div>
    <div class="card-body">

      <?php if (!$droneEdit): ?>
        <?php if (empty($drones)): ?>
          <div class="empty-list">Aucun drone enregistré.</div>
        <?php else: ?>
          <div class="drone-list">
            <?php foreach ($drones as $d): ?>
              <a href="?mode=update&id=<?= (int)$d['id_drone'] ?>" class="drone-item">
                <div class="di-id">#<?= (int)$d['id_drone'] ?></div>
                <div class="di-info">
                  <div class="di-name"><?= h($d['marque']) ?> <?= h($d['modele']) ?></div>
                  <div class="di-sub"><?= h($d['nom_categorie'] ?? '—') ?> · <?= h($d['autonomie_m']) ?> min</div>
                </div>
                <span class="di-status <?= statutClass($d['statut_stock']) ?>"><?= h($d['statut_stock']) ?></span>
                <span class="di-arrow">›</span>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      <?php else: ?>
        <form method="POST">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id"     value="<?= (int)$droneEdit['id_drone'] ?>">

          <div class="field-row">
            <div>
              <label class="lbl">Marque <span class="req">*</span></label>
              <input type="text" name="marque" value="<?= h($droneEdit['marque']) ?>" required>
            </div>
            <div>
              <label class="lbl">Modèle <span class="req">*</span></label>
              <input type="text" name="modele" value="<?= h($droneEdit['modele']) ?>" required>
            </div>
          </div>

          <div class="field">
            <label class="lbl">Catégorie <span class="req">*</span></label>
            <select name="id_categorie" required>
              <option value="">— Sélectionner —</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id_categorie'] ?>"
                  <?= $droneEdit['id_categorie'] == $cat['id_categorie'] ? 'selected' : '' ?>>
                  <?= h($cat['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="field-row-3">
            <div>
              <label class="lbl">Autonomie (min)</label>
              <input type="number" name="autonomie_m" min="0" value="<?= h($droneEdit['autonomie_m']) ?>">
            </div>
            <div>
              <label class="lbl">Capteur</label>
              <input type="text" name="capteur" value="<?= h($droneEdit['capteur']) ?>">
            </div>
            <div>
              <label class="lbl">Portée (m)</label>
              <input type="number" name="portee_m" min="0" value="<?= h($droneEdit['portee_m']) ?>">
            </div>
          </div>

          <div class="field-row">
            <div>
              <label class="lbl">Prix (MRU)</label>
              <input type="number" name="prix_final_MRU" step="0.01" min="0" value="<?= h($droneEdit['prix_final_MRU']) ?>">
            </div>
            <div>
              <label class="lbl">Statut stock <span class="req">*</span></label>
              <select name="statut_stock" required>
                <option value="">— Sélectionner —</option>
                <?php foreach (['En stock','Sur commande','Rupture'] as $s): ?>
                  <option value="<?= $s ?>" <?= $droneEdit['statut_stock']===$s?'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="field">
            <label class="lbl">Lien image (URL)</label>
            <input type="text" name="lien_image" value="<?= h($droneEdit['lien_image']) ?>">
          </div>

          <div class="form-footer">
            <a href="?mode=update" class="btn btn-ghost">← Retour</a>
            <button type="submit" class="btn btn-blue">Enregistrer les modifications</button>
          </div>
        </form>
      <?php endif; ?>

    </div>
  </div>

  <!-- ══ MODE : SUPPRIMER ══ -->
  <?php elseif ($mode === 'delete'): ?>
  <div class="card">
    <div class="card-head">
      <div class="head-icon" style="background:rgba(239,68,68,.15)">
        <svg viewBox="0 0 20 20" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 5l10 10M15 5L5 15"/></svg>
      </div>
      <div class="head-info">
        <h3>Supprimer un drone</h3>
        <p>Sélectionnez le drone à retirer de la flotte</p>
      </div>
    </div>
    <div class="card-body">
      <?php if (empty($drones)): ?>
        <div class="empty-list">Aucun drone enregistré.</div>
      <?php else: ?>
        <div class="drone-list">
          <?php foreach ($drones as $d): ?>
            <div class="drone-item" style="cursor:default">
              <div class="di-id">#<?= (int)$d['id_drone'] ?></div>
              <div class="di-info">
                <div class="di-name"><?= h($d['marque']) ?> <?= h($d['modele']) ?></div>
                <div class="di-sub"><?= h($d['nom_categorie'] ?? '—') ?> · <?= h($d['autonomie_m']) ?> min</div>
              </div>
              <span class="di-status <?= statutClass($d['statut_stock']) ?>"><?= h($d['statut_stock']) ?></span>
              <form method="POST" onsubmit="return confirm('Supprimer « <?= h($d['marque'].' '.$d['modele']) ?> » définitivement ?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id"     value="<?= (int)$d['id_drone'] ?>">
                <button type="submit" class="btn btn-red" style="padding:7px 16px;font-size:.78rem">Supprimer</button>
              </form>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php endif; ?>

</div>
</body>
</html>
