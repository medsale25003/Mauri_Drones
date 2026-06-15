<?php
$con=mysqli_connect("localhost","root","","mauri_drones");
if(isset($_POST['ajouter'])) {
$marque= isset($_POST['marque']) ? htmlspecialchars(trim($_POST['marque'])) : '';
$modele = isset($_POST['modele'] )? htmlspecialchars(trim($_POST['modele'])) : '';
switch($_POST['categorie']){
  case "Action":
    $categorie=18;
    break;
  case "360":
    $categorie=19;
    break;
  case "Plein Format":
    $categorie=20;
    break;
  case "Cinema":
    $categorie=21;
    break;
  default:
    $categorie='';
}
$resolution= isset($_POST['resolution_max']) ? htmlspecialchars(trim($_POST['resolution_max'])): '';
$capteur = isset($_POST['capteur']) ? htmlspecialchars(trim($_POST['capteur'])): '';
$vision = isset($_POST['vision'] )? htmlspecialchars(trim($_POST['vision'])) :'';
$autonomie = isset($_POST['autonomie']) ? htmlspecialchars(trim($_POST['autonomie'])): '';
$prix_mru = isset($_POST['prix_mru']) ? htmlspecialchars(trim($_POST['prix_mru'])) :'';
$statut_stock = isset($_POST['statut_stock']) ? htmlspecialchars(trim($_POST['statut_stock'])) : '';
$lien = isset($_POST['lien']) ? htmlspecialchars(trim($_POST['lien'])) : '';

if(!empty($marque) and !empty($modele) and !empty($categorie) and !empty($resolution) and !empty($capteur) and !empty($vision) and !empty($autonomie) and !empty($prix_mru) and !empty($statut_stock) and !empty($lien)){
$sql="insert into cameras (marque,modele,id_categorie,resolution_max,capteur,champ_de_vision,autonomie,prix_mru,statut_stock,lien_image) values(?,?,?,?,?,?,?,?,?,?)";
$stmt=$con->prepare($sql);
$stmt->bind_param("ssiisiiiss",$marque,$modele,$categorie,$resolution,$capteur,$vision,$autonomie,$prix_mru,$statut_stock,$lien);
if($stmt->execute()){
  header("location:cameras_formulaires.php?ajout=1");
  exit();
}
else echo "<script> alert('erreur lors de la sauvagarde dans la base !') </script>";
}}

if(isset($_POST['modifier'])){
print_r($_POST);
$id = isset($_POST['id'])  ? (int)htmlspecialchars(trim($_POST['id'])):'';
// $marque = isset($_POST['marque']) ? htmlspecialchars(trim($_POST['marque'])):'';
// $modele = isset($_POST['modele']) ? htmlspecialchars(trim($_POST['modele'])):'';
switch($_POST['categorie']){
  case "Action":
    $categorie=18;
    break;
  case "360":
    $categorie=19;
    break;
  case "Plein Format":
    $categorie=20;
    break;
  case "Cinema":
    $categorie=21;
    break;
  default:
    $categorie='';
}
$resolution = isset($_POST['resolution']) ? htmlspecialchars(trim($_POST['resolution'])):'';
$capteur = isset($_POST['capteur']) ? htmlspecialchars(trim($_POST['capteur'])):'';
$vision = isset($_POST['vision']) ? htmlspecialchars(trim($_POST['vision'])):'';
$autonomie = isset($_POST['autonomie']) ? htmlspecialchars(trim($_POST['autonomie'])):'';
$prix_mru = isset($_POST['prix_mru']) ? htmlspecialchars(trim($_POST['prix_mru'])):'';
$statut_stock = isset($_POST['statut_stock']) ? htmlspecialchars(trim($_POST['statut_stock'])):'';
$lien = isset($_POST['lien']) ? htmlspecialchars(trim($_POST['lien'])):'';

if(!empty($categorie) and !empty($resolution) and !empty($capteur) and !empty($vision) and !empty($autonomie) and !empty($prix_mru) and !empty($statut_stock) and !empty($lien)){
$sql="update cameras set id_categorie=?, resolution_max=?, capteur=?, champ_de_vision =?, autonomie=?, prix_mru=?, statut_stock=?, lien_image=? where id_modele=?";
$stmt=$con->prepare($sql);
$stmt->bind_param("isssiissi",$categorie,$resolution,$capteur,$vision,$autonomie,$prix_mru,$statut_stock,$lien,$id);
if ($stmt->execute()){
  header("location:cameras_formulaires.php?modification=1");
  exit();
}
else echo "<script> alert('erreur lors de la sauvagarde dans la base !') </script>";
}}


if(isset($_POST['supprimer'])){
$id = $_POST['id'] ? htmlspecialchars(trim($_POST['id'])):'';
$modele_confirme=$_POST['modele_confirm'] ?htmlspecialchars(trim($_POST['modele_confirm'])):'';
if(!empty($id) and !empty($modele_confirme)){
  $sql="delete from cameras where id_modele=?  and modele=? ";
  $stmt=$con->prepare($sql);
  $stmt->bind_param("is",$id,$modele_confirme);
  if ($stmt->execute()) {
     header("location:cameras_formulaires.php?suppression=1");
  exit();
  }
else echo "<script> alert('erreur lors de la sauvagarde dans la base !') </script>";
}
}
<?php
  $sql="select * from cameras";
  $res=mysqli_query($con,$sql);
  ?>
 
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Gestion Catalogue — Mauri-Drones</title>
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800&family=Barlow+Condensed:wght@600;700;800&display=swap" rel="stylesheet"/>
<style>
:root{
  --bg:#0d0f14;
  --surface:#13161e;
  --card:#181c27;
  --border:#1f2436;
  --border2:#2a2f45;
  --blue:#3b9eff;
  --blue-d:#1a7de8;
  --blue-glow:rgba(59,158,255,.2);
  --red:#ff4b4b;
  --red-glow:rgba(255,75,75,.18);
  --green:#2fd98e;
  --green-glow:rgba(47,217,142,.18);
  --text:#e9ecf5;
  --muted:#6b7490;
  --label:#8892b0;
  --r:14px;
  --r-sm:8px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:var(--bg);color:var(--text);font-family:'Barlow',sans-serif;font-size:15px;line-height:1.6;min-height:100vh}

/* ── HEADER ── */
.site-header{
  background:rgba(13,15,20,.95);
  border-bottom:1px solid var(--border);
  padding:0 40px;height:64px;
  display:flex;align-items:center;
  position:sticky;top:0;z-index:100;
  backdrop-filter:blur(10px);
}
.logo{display:flex;align-items:center;gap:10px;text-decoration:none;}
.logo-text{font-family:'Barlow Condensed',sans-serif;font-size:1.2rem;font-weight:800;letter-spacing:.3px;color:var(--text);}
.logo-dash{color:var(--blue)}

/* ── PAGE ── */
.page{max-width:860px;margin:48px auto 80px;padding:0 24px}

/* ── PAGE HEADER ── */
.page-header{margin-bottom:36px}
.page-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--blue);margin-bottom:6px;}
.page-title{font-family:'Barlow Condensed',sans-serif;font-size:2.2rem;font-weight:800;letter-spacing:-.4px;line-height:1.1;color:var(--text);}
.page-title span{color:var(--blue)}

/* ── TABS ── */
.tabs{display:flex;gap:10px;margin-bottom:32px}
.tab-btn{
  background:var(--card);border:1px solid var(--border2);
  color:var(--muted);font-family:'Barlow',sans-serif;font-size:.88rem;font-weight:700;
  padding:11px 22px;cursor:pointer;border-radius:var(--r-sm);
  display:flex;align-items:center;gap:8px;
  transition:background .18s,color .18s,border-color .18s,box-shadow .18s;letter-spacing:.3px;
}
.tab-btn:hover{background:var(--surface);color:var(--text)}
.tab-btn.active[data-tab="add"]   {background:var(--blue);color:#fff;border-color:var(--blue);box-shadow:0 4px 16px var(--blue-glow)}
.tab-btn.active[data-tab="edit"]  {background:var(--green);color:#0d1a10;border-color:var(--green);box-shadow:0 4px 16px var(--green-glow)}
.tab-btn.active[data-tab="delete"]{background:var(--red);color:#fff;border-color:var(--red);box-shadow:0 4px 16px var(--red-glow)}

/* ── PANEL ── */
.panel{display:none;animation:fadeUp .2s ease both}
.panel.active{display:block}
@keyframes fadeUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

/* ── CARD ── */
.form-card{background:var(--card);border:1px solid var(--border2);border-radius:var(--r);overflow:hidden;}

/* ── CARD HEAD ── */
.card-head{padding:22px 28px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:14px;}
.head-icon{width:40px;height:40px;border-radius:var(--r-sm);display:grid;place-items:center;font-size:18px;flex-shrink:0;}
.head-icon-add   {background:rgba(59,158,255,.12)}
.head-icon-edit  {background:rgba(47,217,142,.12)}
.head-icon-delete{background:rgba(255,75,75,.12)}
.head-text h2{font-family:'Barlow Condensed',sans-serif;font-size:1.15rem;font-weight:800;letter-spacing:.1px;}
.head-text p{color:var(--muted);font-size:.82rem;margin-top:2px}
.head-chip{
  margin-left:auto;
  background:rgba(59,158,255,.1);border:1px solid rgba(59,158,255,.22);
  color:var(--blue);border-radius:20px;
  font-size:.68rem;font-weight:700;letter-spacing:.6px;text-transform:uppercase;
  padding:3px 11px;white-space:nowrap;
}
.head-chip.red{background:rgba(255,75,75,.1);border-color:rgba(255,75,75,.22);color:var(--red)}

/* ── FORM BODY ── */
.card-body{padding:28px}

/* ── GRID ── */
.fgrid{display:grid;grid-template-columns:1fr 1fr;gap:18px 24px}
.fgrid .full{grid-column:1/-1}

/* ── FIELD ── */
.field{display:flex;flex-direction:column;gap:6px}
.field label{font-size:.72rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--label);}
.field label .req{color:var(--blue);margin-left:2px}

input[type=text],input[type=number],input[type=url],select,textarea{
  background:#0f1219;
  border:1px solid var(--border2);
  border-radius:var(--r-sm);
  color:var(--text);
  font-family:'Barlow',sans-serif;font-size:.92rem;
  padding:11px 14px;width:100%;
  transition:border-color .18s,box-shadow .18s;
  outline:none;-webkit-appearance:none;
}
input::placeholder,textarea::placeholder{color:var(--muted)}
input:focus,select:focus,textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px var(--blue-glow)}
#form-edit  input:focus,#form-edit  select:focus{border-color:var(--green);box-shadow:0 0 0 3px var(--green-glow)}
#form-delete input:focus{border-color:var(--red);  box-shadow:0 0 0 3px var(--red-glow)}

select option{background:#0f1219}
textarea{resize:vertical;min-height:72px}
.hint{font-size:.73rem;color:var(--muted)}

/* ── DIVIDER ── */
.divider{height:1px;background:var(--border);margin:24px 0}

/* ── ACTIONS ── */
.form-actions{display:flex;justify-content:flex-end;gap:10px}

/* ── BUTTONS ── */
.btn{
  padding:11px 22px;border-radius:var(--r-sm);
  font-family:'Barlow',sans-serif;font-size:.88rem;font-weight:700;border:none;cursor:pointer;
  display:inline-flex;align-items:center;gap:7px;letter-spacing:.3px;
  transition:background .18s,box-shadow .18s,transform .1s;
}
.btn:active{transform:scale(.97)}
.btn-ghost{background:transparent;border:1px solid var(--border2);color:var(--muted)}
.btn-ghost:hover{background:var(--surface);color:var(--text)}
.btn-add {background:var(--blue);color:#fff}
.btn-add:hover{background:var(--blue-d);box-shadow:0 4px 18px var(--blue-glow)}
.btn-edit{background:var(--green);color:#0d1a10}
.btn-edit:hover{filter:brightness(1.1);box-shadow:0 4px 18px var(--green-glow)}
.btn-del {background:var(--red);color:#fff}
.btn-del:hover{filter:brightness(1.08);box-shadow:0 4px 18px var(--red-glow)}

/* ── ALERT ── */
.alert{
  background:rgba(255,75,75,.08);border:1px solid rgba(255,75,75,.22);
  border-radius:var(--r-sm);padding:13px 16px;
  display:flex;gap:10px;align-items:flex-start;
  font-size:.84rem;color:#f5a4a4;margin-bottom:20px;
}
.alert strong{color:#ff9191}

/* ── RESPONSIVE ── */
@media(max-width:600px){
  .page{margin:28px auto 60px;padding:0 16px}
  .fgrid{grid-template-columns:1fr}
  .card-body{padding:20px 16px}
  .tabs{overflow-x:auto}
  .tab-btn{padding:12px 16px;white-space:nowrap}
  .form-actions{flex-direction:column-reverse}
  .btn{width:100%;justify-content:center}
}

/* ── TABLE CATALOGUE ── */
.catalogue-section{margin-top:60px}
.catalogue-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.catalogue-header h2{font-family:'Barlow Condensed',sans-serif;font-size:1.5rem;font-weight:800;letter-spacing:-.2px;}
.catalogue-header h2 span{color:var(--blue)}
.catalogue-count{
  background:rgba(59,158,255,.1);border:1px solid rgba(59,158,255,.22);
  color:var(--blue);border-radius:20px;
  font-size:.7rem;font-weight:700;letter-spacing:.6px;text-transform:uppercase;
  padding:4px 12px;
}
.table-wrap{background:var(--card);border:1px solid var(--border2);border-radius:var(--r);overflow:hidden;overflow-x:auto;}
table{width:100%;border-collapse:collapse;min-width:700px}
thead tr{background:rgba(59,158,255,.06);border-bottom:1px solid var(--border2)}
thead th{padding:12px 14px;text-align:left;font-size:.68rem;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--label);white-space:nowrap;}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(255,255,255,.03)}
tbody tr.selected{background:rgba(59,158,255,.07)!important;border-left:3px solid var(--blue)}
td{padding:12px 14px;font-size:.88rem;vertical-align:middle}
td.td-id{color:var(--muted);font-size:.78rem;font-weight:600}
td.td-modele{font-weight:600;color:var(--text)}
.td-cat{
  font-size:.75rem;font-weight:700;letter-spacing:.4px;
  background:rgba(59,158,255,.08);color:var(--blue);
  border-radius:20px;padding:3px 10px;white-space:nowrap;display:inline-block;
}
td.td-prix{font-weight:700;color:var(--green)}
.badge-stock{font-size:.72rem;font-weight:700;letter-spacing:.3px;border-radius:20px;padding:3px 10px;white-space:nowrap;display:inline-block;}
.badge-stock.s-en {background:rgba(47,217,142,.1);color:var(--green);border:1px solid rgba(47,217,142,.25)}
.badge-stock.s-nkc{background:rgba(47,217,142,.07);color:#a8f0d0;border:1px solid rgba(47,217,142,.15)}
.badge-stock.s-cmd{background:rgba(255,193,59,.08);color:#ffd96e;border:1px solid rgba(255,193,59,.2)}
.badge-stock.s-rpt{background:rgba(255,75,75,.08);color:#ff9191;border:1px solid rgba(255,75,75,.2)}
.btn-select{
  background:rgba(59,158,255,.12);border:1px solid rgba(59,158,255,.28);
  color:var(--blue);font-family:'Barlow',sans-serif;font-size:.78rem;font-weight:700;
  padding:7px 14px;border-radius:var(--r-sm);cursor:pointer;white-space:nowrap;
  transition:background .18s,box-shadow .18s;letter-spacing:.2px;
  display:inline-flex;align-items:center;gap:5px;
}
.btn-select:hover{background:var(--blue);color:#fff;box-shadow:0 3px 12px var(--blue-glow)}
tr.selected .btn-select{background:var(--blue);color:#fff}
.table-empty{text-align:center;padding:48px 24px;color:var(--muted);font-size:.9rem;}
</style>
</head>
<body>

<header class="site-header">
  <a class="logo" href="#">
    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
      <line x1="14" y1="2"  x2="14" y2="26" stroke="#e9ecf5" stroke-width="2.2" stroke-linecap="round"/>
      <line x1="2"  y1="14" x2="26" y2="14" stroke="#e9ecf5" stroke-width="2.2" stroke-linecap="round"/>
      <line x1="5"  y1="5"  x2="23" y2="23" stroke="#3b9eff" stroke-width="2"   stroke-linecap="round"/>
      <line x1="23" y1="5"  x2="5"  y2="23" stroke="#3b9eff" stroke-width="2"   stroke-linecap="round"/>
      <circle cx="14" cy="14" r="3.2" fill="#3b9eff"/>
      <circle cx="14" cy="3"  r="2"   fill="#e9ecf5"/>
      <circle cx="14" cy="25" r="2"   fill="#e9ecf5"/>
      <circle cx="3"  cy="14" r="2"   fill="#e9ecf5"/>
      <circle cx="25" cy="14" r="2"   fill="#e9ecf5"/>
    </svg>
    <span class="logo-text">Mauri<span class="logo-dash">-</span>Drones</span>
  </a>
</header>

<main class="page">

  <div class="page-header">
    <p class="page-eyebrow">Panneau d'administration</p>
    <h1 class="page-title">Gestion du <span>catalogue</span></h1>
  </div>

  <div class="tabs" role="tablist">
    <button class="tab-btn active" data-tab="add"    role="tab" aria-selected="true"  aria-controls="panel-add">    ＋ Ajouter</button>
    <button class="tab-btn"        data-tab="edit"   role="tab" aria-selected="false" aria-controls="panel-edit">   ✎ Modifier</button>
    <button class="tab-btn"        data-tab="delete" role="tab" aria-selected="false" aria-controls="panel-delete"> ✕ Supprimer</button>
  </div>

  <!-- ══ AJOUTER ══ -->
   
  <section id="panel-add" class="panel active" role="tabpanel">
    <div class="form-card">
      <div class="card-head">
        <div class="head-icon head-icon-add">➕</div>
        <div class="head-text">
          <h2>Nouvel article</h2>
          <p>Ajouter un appareil au catalogue</p>
        </div>
        <span class="head-chip">ID auto</span>
      </div>
      <div class="card-body">
        <form id="form-add" method="post" name="fo1">
          <input type="hidden" name="marque" value="add"/>
          <div class="fgrid">

            <div class="field full">
              <label for="a-modele">Marque <span class="req">*</span></label>
              <input type="text" id="a-modele" name="marque" placeholder="Ex : DJI " required maxlength="120" >
            </div>
            <div class="field full">
              <label for="a-modele">Modèle <span class="req">*</span></label>
              <input type="text" id="a-modele" name="modele" placeholder="Ex :Air 3S" required maxlength="120" >
            </div>
            <div class="field">
              <label for="a-categorie">Catégorie <span class="req">*</span></label>
              <select id="a-categorie" name="categorie">
                <option value="" disabled selected>— Sélectionner —</option>
                <option value="Action">Action</option>
                <option value="360">360</option>
                <option value="Plein Format">Plein Format</option>
                <option value="Cinema">Cinéma</option>
              </select>
            </div>

            <div class="field">
              <label for="a-resolution">Résolution Max <span class="req">*</span></label>
              <input type="text" id="a-resolution" name="resolution_max" placeholder="Ex : 4K/120 fps" required maxlength="60"/>
            </div>

            <div class="field">
              <label for="a-capteur">Capteur</label>
              <input type="text" id="a-capteur" name="capteur" placeholder="Ex : 1/1.3″ CMOS" maxlength="80"/>
            </div>

            <div class="field">
              <label for="a-fov">Champ de Vision</label>
              <input type="text" id="a-fov" name="vision" placeholder="Ex : 155°" maxlength="40"/>
            </div>

            <div class="field">
              <label for="a-autonomie">Autonomie</label>
              <input type="text" id="a-autonomie" name="autonomie" placeholder="Ex : 120 min" maxlength="40"/>
            </div>

            <div class="field">
              <label for="a-prix">Prix Estimé (MRU) <span class="req">*</span></label>
              <input type="number" id="a-prix" name="prix_mru" placeholder="Ex : 13400" min="0" step="0.01" required/>
            </div>

            <div class="field">
              <label for="a-statut">Statut Stock <span class="req">*</span></label>
              <select id="a-statut" name="statut_stock" required>
                <option value="" disabled selected>— Sélectionner —</option>
                <option value="En stock">En stock</option>
                <option value="Sur commande">Sur commande</option>
              </select>
            </div>
            <div class="field full">
              <label for="a-lien">Lien Image (URL)</label>
              <input type="url" id="a-lien" name="lien" placeholder="https://exemple.com/image.jpg" maxlength="500"/>
              <span class="hint">URL de l'image principale affichée sur la carte produit.</span>
            </div>

          </div>
          <div class="divider"></div>
          <div class="form-actions">
            <button type="reset"  class="btn btn-ghost" name="annuler">Annuler</button>
            <button type="submit" class="btn btn-add" name="ajouter">＋ Ajouter l'article</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  
  <!-- ══ MODIFIER ══ -->
   
  <section id="panel-edit" class="panel" role="tabpanel">
    <div class="form-card">
      <div class="card-head">
        <div class="head-icon head-icon-edit">✎</div>
        <div class="head-text">
          <h2>Modifier un article</h2>
          <p>Mettre à jour les informations d'un article existant</p>
        </div>
      </div>
      <div class="card-body">
        <form id="form-edit"  method="post" name="fo2">
          <input type="hidden" name="" value="edit"/>
          <div class="fgrid">

            <div class="field full">
              <label for="e-id">ID de l'article <span class="req">*</span></label>
              <input type="number" id="e-id" name="id" placeholder="Ex : 3" required min="1" step="1"/>
              <span class="hint">Identifiant auto-généré par la base de données (visible dans le tableau ci-dessous).</span>
            </div>

            <div class="field">
              <label for="e-categorie">Catégorie</label>
              <select id="e-categorie" name="categorie">
                <option value="">— Inchangé —</option>
                <option value="Action">Action</option>
                <option value="360">360°</option>
                <option value="Plein Format">Plein Format</option>
                <option value="Cinema">Cinéma</option>
              </select>
            </div>

            <div class="field">
              <label for="e-resolution">Résolution Max</label>
              <input type="text" id="e-resolution" name="resolution" placeholder="Laisser vide = inchangé" maxlength="60"/>
            </div>

            <div class="field">
              <label for="e-capteur">Capteur</label>
              <input type="text" id="e-capteur" name="capteur" placeholder="Laisser vide = inchangé" maxlength="80"/>
            </div>

            <div class="field">
              <label for="e-fov">Champ de Vision (FOV)</label>
              <input type="text" id="e-fov" name="vision" placeholder="Laisser vide = inchangé" maxlength="40"/>
            </div>

            <div class="field">
              <label for="e-autonomie">Autonomie</label>
              <input type="text" id="e-autonomie" name="autonomie" placeholder="Laisser vide = inchangé" maxlength="40"/>
            </div>

            <div class="field">
              <label for="e-prix">Prix Estimé (MRU)</label>
              <input type="number" id="e-prix" name="prix_mru" placeholder="Laisser vide = inchangé" min="0" step="0.01"/>
            </div>

            <div class="field">
              <label for="e-statut">Statut Stock</label>
              <select id="e-statut" name="statut_stock">
                <option value="">— Inchangé —</option>
                <option value="En stock">En stock</option>
                <option value="Sur commande">Sur Commande</option>
              </select>
            </div>

            <div class="field full">
              <label for="e-lien">Lien Image (URL)</label>
              <input type="url" id="e-lien" name="lien" placeholder="Laisser vide pour conserver l'image actuelle" maxlength="500"/>
            </div>

          </div>
          <div class="divider"></div>
          <div class="form-actions">
            <button type="reset"  class="btn btn-ghost" name="annuler_lamodification">Annuler</button>
            <button type="submit" class="btn btn-edit" name="modifier">✎ Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  
  <!-- ══ SUPPRIMER ══ -->
  <section id="panel-delete" class="panel" role="tabpanel">
    <div class="form-card">
      <div class="card-head">
        <div class="head-icon head-icon-delete">🗑</div>
        <div class="head-text">
          <h2>Supprimer un article</h2>
          <p>Retirer définitivement un article du catalogue</p>
        </div>
        <span class="head-chip red">Irréversible</span>
      </div>
      <div class="card-body">
        <div class="alert">
          <span style="font-size:16px;flex-shrink:0;margin-top:1px">⚠</span>
          <div><strong>Attention.</strong> Cette action est définitive. Vérifiez l'ID avant de confirmer.</div>
        </div>
        <form id="form-delete"  method="POST" autocomplete="off"
              onsubmit="return confirm('Supprimer définitivement cet article ?')">
          <input type="hidden" name="action2" value="delete"/>
          <div class="fgrid">

            <div class="field">
              <label for="d-id">ID de l'article <span class="req">*</span></label>
              <input type="number" id="d-id" name="id" placeholder="Ex : 7" required min="1" step="1"/>
              <span class="hint">Identifiant auto-généré par la base de données.</span>
            </div>

            <div class="field">
              <label for="d-confirm">Confirmer le modèle <span class="req">*</span></label>
              <input type="text" id="d-confirm" name="modele_confirm" placeholder="Nom exact du modèle" required maxlength="120"/>
              <span class="hint">Double vérification pour éviter toute erreur.</span>
            </div>

          </div>
          <div class="divider"></div>
          <div class="form-actions">
            <button type="reset"  class="btn btn-ghost" name="annuler_lasupression">Annuler</button>
            <button type="submit" class="btn btn-del" name="supprimer">✕ Supprimer l'article</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</main>

<!-- ══ TABLEAU CATALOGUE ══ -->
<div class="page" style="margin-top:0">
  <div class="catalogue-section">
    <div class="catalogue-header">
      <h2>Catalogue <span>actuel</span></h2>
      <span class="catalogue-count" id="row-count">3 articles</span>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Catégorie</th>
            <th>Résolution</th>
            <th>Capteur</th>
            <th>Champ de vision</th>
            <th>Autonomie</th>
            <th>Prix</th>
            <th>Statut</th>
            <th>lien_image</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($tab=mysqli_fetch_assoc($res)){
          echo "<tr>";
           echo " <td> <button class='btn-select'>↑ Sélectionner</button> </td>";
           echo " <td class='td-id'>".$tab['id_modele']." </td>";
           echo " <td class='td-modele'>".$tab['marque']."</td>";
           echo " <td class='td-modele'>".$tab['modele']."</td>";
            echo "<td><span class'td-cat'>".$tab['id_categorie']."</span></td>";
            echo "<td>".$tab['resolution_max']."</td>";
             echo "<td>".$tab['capteur']."</td>";
            echo "<td>".$tab['champ_de_vision']."</td>";
            echo "<td>".$tab['autonomie']."</td>";
           echo" <td class='td-prix'>".$tab['prix_mru']."</td>";
           echo "<td><span class='badge-stock s-en'>".$tab['statut_stock']."</span></td>";
           echo "<td>".$tab['autonomie']."</td>";
         echo " </tr>";
          }
      ?>
          
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Tabs
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById('panel-' + btn.dataset.tab).classList.add('active');
    });
  });
  // Row select — remplit les champs ID dans Modifier et Supprimer
  document.querySelectorAll('.btn-select').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('selected'));
      const row = btn.closest('tr');
      row.classList.add('selected');
      const rawId = row.querySelector('.td-id').textContent.replace('#','').trim();
      const eId = document.getElementById('e-id');
      const dId = document.getElementById('d-id');
      const dConfirm = document.getElementById('d-confirm');
      if (eId) eId.value = rawId;
      if (dId) dId.value = rawId;
      if (dConfirm) dConfirm.value = row.querySelector('.td-modele').textContent.trim();
    });
  });
</script>

<?php if(isset($_GET['ajout']) && $_GET['ajout']==1): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne Ajoutée dans la base !");
      window.history.replaceState({},document.title,"cameras_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>

<?php if(isset($_GET['modification']) && $_GET['modification']==1): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne modifiée avec succées !");
      window.history.replaceState({},document.title,"cameras_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>
<?php if(isset($_GET['suppression']) && $_GET['suppression']==1): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
      alert("Ligne suprimée avec succées !");
      window.history.replaceState({},document.title,"cameras_formulaire.php");
    }, 100);
  });
  </script>
<?php endif; ?>
</body>
</html>
