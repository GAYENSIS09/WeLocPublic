<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die();
    }
    $myclient = new Client();
    if (isset($_POST['on_off'])) {
        $status = ($_POST['on_off'] === 'Activer') ? 'actif' : 'suspendu';
        $myclient->one_off($_POST['id'], $status);
        header("Location:./DetailClient.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['erase'])) {
        $myclient->delete($_POST['id']);
        header("Location:./listes.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $myclient = new Client();
    $data = $myclient->getAttributs($_GET['id']);

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
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <div class="card shadow-lg p-4 sub-container">
                            <div class="row">
                                <!-- Photo de profil -->
                                <div class="col-md-4 text-center">
                                    <img src="<?= $data[0]['photo'] ?>" class="profile-img mb-3" alt="Photo de profil">
                                    <h3 class="fw-bold"><?= $data[0]['prenom'] . ' ' . $data[0]['nom'] ?></h3>
                                </div>

                                <!-- Informations -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <strong><i class="fas fa-envelope"></i> Email :</strong> <?= $data[0]['email'] ?>
                                    </div>
                                    <div class="mb-3">
                                        <strong><i class="fas fa-phone"></i> Téléphone :</strong> <?= $data[0]['telephone'] ?>
                                    </div>
                                    <div class="mb-3">
                                        <strong><i class="fas fa-map-marker-alt"></i> Adresse :</strong> <?= $data[0]['adresse'] ?>
                                    </div>
                                    <div class="mb-3">
                                        <strong><i class="fas fa-id-card"></i> Permis de conduire :</strong>
                                        <a href="<?= $data[0]['permis_de_conduire'] ?>" target="_blank">voire</a>
                                    </div>
                                    <div class="mb-3">
                                        <strong><i class="fas fa-user-check"></i> Statut compte :</strong> <?= $data[0]['statut_compte'] ?>
                                    </div>
                                    <div class="mb-3">
                                        <strong><i class="fas fa-star"></i> Points fidélité :</strong> <?= $data[0]['points_fidelite'] ?>
                                    </div>
                                    <!-- Boutons d'action -->
                                    <div class="text-center mt-4">
                                        <form action="./DetailClient.php" method="post">
                                            <input type="hidden" value="<?= $data[0]['id'] ?>" name="id">

                                            <button class="btn btn-desable w-100 mb-2" onclick="confirm('voulez-vous l\'activer ?')" name="on_off" type="submit" value="Activer">
                                                activer
                                            </button>
                                            <button class="btn btn-desable w-100  mb-2 " onclick="confirm('voulez-vous le desactiver ?')" name="on_off" type="submit" value="Désactiver" id="disable-btn">
                                                Désactiver
                                            <?php  } ?>
                                            </button>
                                            <button class="btn btn-danger w-100 mb-2" onclick="confirmDelete(event)" name="erase" type="submit">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                        <a href="./listes.php" class="btn btn-secondary w-100">
                                            <i class="fas fa-arrow-left"></i> Retour
                                        </a>
                                    </div>
                                </div> <!-- Fin col-md-8 -->
                            </div> <!-- Fin row -->
                        </div>
                    </div>
                </div>
            </div>
        </main>


    </div>
    <!-- /code -->

    <!-- footer -->
    <?php include_once(".././pages_sections/footer.php"); ?>
    <!-- /footer -->