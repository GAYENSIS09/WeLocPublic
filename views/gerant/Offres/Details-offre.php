<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offre = new Offre_Locaton();
    if (isset($_POST['modifier'])) {
        if (!Vehicule::is_id(intval($_POST['id_Vehicule']), $_SESSION['agence_id'])) {
            echo 'id_Vehicule invalide';
            die();
        }
        $offre::update($_POST['id'], [
            'id_Vehicule' =>  intval($_POST['id_Vehicule']) ?? '',
            'description' =>  $_POST['description'] ?? '',
            'tarif' =>  floatval($_POST['tarif']) ?? '',
            'date_debut' => date('Y-m-d', strtotime($_POST['date_debut'])),
            'date_fin' => date('Y-m-d', strtotime($_POST['date_fin'])),
            'conditions' =>  $_POST['condition'] ?? '',
        ]);
        header("Location:./Details-offre.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['supprimer'])) {
        $offre::delete($_POST['id']);
        header("Location:./liste.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $offre = new Offre_Locaton();
    $data = $offre->get($_GET['id']);
?>
    <!-- /code -->

    <!-- body -->
    <?php include_once(".././pages_sections/body.php"); ?>
    <!-- /body -->

    <!-- code -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <form action="./Details-offre.php" method="post">
                            <div class="card shadow-lg p-4 sub-container">
                                <hr>
                                <div class="mb-3">
                                    <strong><i class="fas fa-id-card"></i> ID-véhicule :</strong>
                                    <input type="number" min="0" class="form-control" value="<?= $data[0]['id_vehicule'] ?>" name="id_Vehicule">
                                </div>

                                <div class="mb-3">
                                    <strong><i class="fas fa-dollar-sign"></i> Tarif :</strong>
                                    <input type="number" class="form-control" value="<?= $data[0]['tarif'] ?>" name="tarif">
                                </div>

                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar-day"></i> Date de début :</strong>
                                    <input type="date" class="form-control" value="<?= $data[0]['date_debut'] ?>" name="date_debut">
                                </div>

                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar-day"></i> Date de fin :</strong>
                                    <input type="date" class="form-control" value="<?= $data[0]['date_fin'] ?>" name="date_fin">
                                </div>

                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar-day"></i> Date de fin :</strong>
                                    <input type="text" class="form-control" value="<?= $data[0]['conditions'] ?>" name="condition">
                                </div>

                                <div class="mb-3">
                                    <strong><i class="fas fa-comment-dots"></i> Détails :</strong>
                                    <textarea class="form-control" name="description"><?= $data[0]['description'] ?></textarea>
                                </div>
                                <input type="hidden" value="<?= $data[0]['id'] ?>" name="id">
                                <div class="text-center mt-4">
                                    <button class="btn btn-primary w-100 mb-2" onclick="if (!confirm('Voulez-vous vraiment Modifier ?')) {event.preventDefault();}" type="submit" name="modifier">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                    <button class="btn btn-danger w-100 mb-2" onclick="confirmDelete(event)" type="submit" name="supprimer">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                <?php } ?>
                                <a href="./liste.php" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <script>

        </script>


    </div>
    <!-- /code -->

    <!-- footer -->
    <?php include_once(".././pages_sections/footer.php"); ?>
    <!-- /footer -->