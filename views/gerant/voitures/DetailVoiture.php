<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_SESSION['user_id']))) {
    $voiture = new Vehicule();
    $img = new Image_Vehicule();
    if (isset($_POST['mod'])) {
        $voiture::update($_POST['id'], [
            'marque' => $_POST['marque'] ?? '',
            'modele' => $_POST['modele'] ?? '',
            'transmission' => $_POST['transmission'] ?? '',
            'type' => $_POST['type'] ?? '',
            'annee' => date('Y', strtotime($_POST['annee'])) ?? '',
            'prix_par_jour' => floatval($_POST['prix_par_jour']) ?? '',
            'carburant' => $_POST['carburant'] ?? '',
            'disponibilite' => $_POST['disponibilite'] ?? '',
            'agence_id' =>intval($_SESSION['agence_id']),
            'etat' => $_POST['etat'] ?? '',
        ]);
        header("Location:./DetailVoiture.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['sup'])) {
        $voiture::delete($_POST['id']);
        header("Location:./listes.php");
        exit();
    } else if (isset($_POST['delImg'])) {
        $img::delete($_POST['id']);
        header("Location:./DetailVoiture.php?id={$_POST['id_voiture']}");
        exit();
    } else if (isset($_FILES['image_vehicule'])) {
        $img::add_imgs($_FILES['image_vehicule'], $_POST['id_voiture']);
        header("Location:./DetailVoiture.php?id={$_POST['id_voiture']}");
        exit();
    }
}
if ((isset($_SESSION['user_id'])) && ($_SERVER['REQUEST_METHOD'] === 'GET')) {
    $voiture = new Vehicule();
    $img = new Image_Vehicule();
    $data = $voiture->get($_GET['id']);
    $path_id = $img->get($_GET['id']);
?>
    <!-- /code -->

    <!-- body -->
    <?php include_once(".././pages_sections/body.php"); ?>
    <!-- /body -->

    <div id="layoutSidenav_content">
        <main class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="container more-voiture">
                <div class="row g-4">
                    <!-- Car Info Section -->
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <form method="POST" action="./DetailVoiture.php">
                                    <div class="row g-3">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"><strong>Marque</strong></label>
                                                <input type="text" class="form-control" name="marque" value="<?= htmlspecialchars($data[0]['marque']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>Modèle</strong></label>
                                                <input type="text" class="form-control" name="modele" value="<?= htmlspecialchars($data[0]['modele']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>Année</strong></label>
                                                <input type="date" class="form-control" name="annee" value="<?= $data[0]['annee'] ?>-01-01">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>Type</strong></label>
                                                <select class="form-control" name="type">
                                                    <?php
                                                    $types = ["berline", "suv", "utilitaire", "luxe", "monospaces", "4x4", "breaks"];
                                                    foreach ($types as $type): ?>
                                                        <option value="<?= $type ?>" <?= $type === $data[0]['type'] ? 'selected' : '' ?>>
                                                            <?= ucfirst($type) ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <!-- Disponibilité Checkbox -->

                                            <div class="form-group">
                                                <hr>
                                                <label class="form-label"><strong>Disponibilité</strong></label>
                                                <input type="radio" name="disponibilite" value="1" <?= $data[0]['disponibilite'] ? 'checked' : '' ?>>
                                                <label class="form-label"><strong>oui</strong></label>
                                                <input type="radio" name="disponibilite" value="0" <?= !$data[0]['disponibilite'] ? 'checked' : '' ?>>
                                                <label class="form-label"><strong>non</strong></label>


                                                </select>
                                            </div>

                                        </div>


                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="transmission"><strong>Transmission</strong></label>
                                                <select class="form-control" id="transmission" name="transmission">
                                                    <option value="manuelle" <?= $data[0]['transmission'] === 'manuelle' ? 'selected' : '' ?>>Manuelle</option>
                                                    <option value="automatique" <?= $data[0]['transmission'] === 'automatique' ? 'selected' : '' ?>>Automatique</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>Carburant</strong></label>
                                                <select class="form-control" name="carburant">
                                                    <?php $carburants = ["essence", "diesel", "electrique", "hybride"];
                                                    foreach ($carburants as $carb): ?>
                                                        <option value="<?= $carb ?>" <?= $carb === $data[0]['carburant'] ? 'selected' : '' ?>>
                                                            <?= ucfirst($carb) ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>Prix/jour</strong></label>
                                                <input type="number" class="form-control" name="prix_par_jour" value="<?= $data[0]['prix_par_jour'] ?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label"><strong>État</strong></label>
                                                <select class="form-control" name="etat">
                                                    <?php $etats = ["excellent", "bon", "maintenance", "hors_service"];
                                                    foreach ($etats as $etat): ?>
                                                        <option value="<?= $etat ?>" <?= $etat === $data[0]['etat'] ? 'selected' : '' ?>>
                                                            <?= ucfirst($etat) ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-grid gap-3 d-md-flex justify-content-end">
                                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                        <button type="submit" class="btn btn-danger" name="sup" onclick="return confirm('Confirmer la suppression?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                        <button type="submit" class="btn btn-primary" name="mod" onclick="return confirm('Confirmer la modification?')">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <form method="POST" action="./DetailVoiture.php" enctype="multipart/form-data">
                                    <div class="text-center mb-4">
                                        <?php $img::showOne($path_id); ?>
                                        <input type="hidden" name="id_voiture" value="<?= $_GET['id'] ?>">
                                    </div>

                                    <div class="d-grid gap-3">
                                        <div class="form-group">
                                            <label for="img-cars"><i class="fas fa-plus"></i>&nbsp;Ajouter</label>
                                            <input type="file" class="form-control" name="image_vehicule[]" id="img-cars" multiple accept="image/*">
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-danger" name="delImg">
                                                Supprimer l'image
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Section -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Galerie Photos</h5>
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                                <?php $img::showAll($path_id);
                            } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy;WeLoc 2025</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- footer -->
    <?php include_once(".././pages_sections/footer.php"); ?>
    <!-- /footer -->