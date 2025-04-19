<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation = new Reservation();
    if (isset($_POST['modifier'])) {
        if (!Client::is_id(intval($_POST['id_client']), $_SESSION['agence_id'])) {
            echo 'id_client invalide';
            die();
        }
        if (!Offre_Locaton::is_id(intval($_POST['id_offre']), $_SESSION['agence_id'])) {
            echo 'id_offre invalide';
            die();
        }
        if (!Promotion::usingPlus($_POST['code_promo'])) {
            echo 'code_promo invalide';
            die();
        }
        if (!Promotion::usingMinus($_POST['past_code_promo'])) {
            echo 'code_promo invalide';
            die();
        }
        $reservation::update($_POST['id'], [
            'id_client' => $_POST['id_client'] ?? '',
            'id_offre' => $_POST['id_offre'] ?? '',
            'statut' => $_POST['statut'] ?? '',
            'total' => floatval($_POST['total']) ?? '',
            'date_reservation' => date('Y-m-d', strtotime($_POST['date_reservation'])) ?? '',
            'date_fin' => date('Y-m-d', strtotime($_POST['date_fin'])) ?? '',
            'date_debut' => date('Y-m-d', strtotime($_POST['date_debut'])) ?? '',
            'code_promo' => $_POST['code_promo'] ?? '',
        ]);
        header("Location:./DetailReservation.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['supprimer'])) {
        $reservation::delete($_POST['id']);
        header("Location:./liste.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $reservation = new Reservation();
    $data = $reservation->get($_GET['id']);
?>
    <!-- /code -->

    <!-- body -->
    <?php include_once(".././pages_sections/body.php"); ?>
    <!-- /body -->

    <!-- code -->
    <div id="layoutSidenav_content">
        <main class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="container more-voiture">
                <div class="row mb-4 align-items-center">
                    <!-- Informations voiture -->
                    <div class="col-lg-6 col-md-8 col-sm-12 sub-container mb-3 card">
                        <form action="./DetailReservation.php" method="post">
                            <div class="row mb-3 mt-1">
                                <div class="col-4"><label for="id_client"><strong>ID Client :</strong></label></div>
                                <div class="col-8"><input type="number" id="id_client" class="form-control" min="0" name="id_client" value="<?= $data[0]['id_client'] ?>"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="id_offre"><strong>ID Offre :</strong></label></div>
                                <div class="col-8"><input type="number" id="id_offre" class="form-control" min="0" name="id_offre" value="<?= $data[0]['id_offre'] ?>"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><strong>Date :</strong></label></div>
                                <div class="col-8"><input type="date" id="date_reservation" class="form-control" name="date_reservation" value="<?= $data[0]['date_reservation'] ?>"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><strong>Date de début :</strong></label></div>
                                <div class="col-8"><input type="date" id="date_debut" class="form-control" name="date_debut" value="<?= $data[0]['date_debut'] ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><strong>Date de fin :</strong></label></div>
                                <div class="col-8"><input type="date" id="date_fin" class="form-control" name="date_fin" value="<?= $data[0]['date_fin'] ?>"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><label for="type"><strong>Code Promo :</strong></label></div>
                                <div class="col-8"><input type="text" id="code" class="form-control" name="code_promo" value="<?= $data[0]['code_promo'] ?>"></div>
                                <input type="hidden" name="past_code_promo" value="<?= $data[0]['code_promo'] ?>">
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><label for="status"><strong>Status :</strong></label></div>
                                <div class="col-8">
                                    <select id="status" class="form-control" name="statut">
                                        <?php $enum = ['en_attente' => 'en attente', 'confirmee' => 'confirmée', 'annulee' => 'annulée', 'terminee' => 'terminée'];
                                        foreach ($enum as $key => $value) {
                                            echo "<option value='$key'";
                                            echo ($data[0]['statut'] == $key)  ? 'selected' : '';
                                            echo ">{$value}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><label for="total"><strong>total:</strong></label></div>
                                <div class="col-8"><input type="number" id="total" name="total" class="form-control" value="<?= $data[0]['total'];
                                                                                                                        } ?>"></div>
                            </div>
                            <input type="hidden" name="id" value="<?= $data[0]['id'] ?>">
                            <!-- Boutons responsive -->
                            <div class="row mb-3 text-center">
                                <div class="col-6">
                                    <button type="submit" onclick="confirmDelete(event)" class="btn btn-danger w-100" name="supprimer">
                                        <i class="fas fa-trash"></i>&nbsp;<strong>Supprimer</strong>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100" onclick="if(!confirm('Voulez-vous modifier ?')){event.preventDefault();}" name="modifier">
                                        <i class="fas fa-edit"></i>&nbsp;<strong>Modifier</strong>
                                    </button>
                                </div>
                            </div>
                        </form>
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
    <!-- /code -->

    <!-- footer -->
    <?php include_once(".././pages_sections/footer.php"); ?>
    <!-- /footer -->