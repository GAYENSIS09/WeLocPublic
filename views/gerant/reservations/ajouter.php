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
    if (isset($_POST['ajouter'])) {
        if (!Client::is_id(intval($_POST['id_client']), $_SESSION['agence_id'])) {
            echo 'id_client invalide';
            die();
        }
        if (!Offre_Locaton::is_id(intval($_POST['id_offre']),  $_SESSION['agence_id'])) {
            echo 'id_offre invalide';
            die();
        }
        if (!Promotion::usingPlus($_POST['code_promo'])) {
            echo 'code_promo invalide';
            die();
        }
        $reservation->add([
            'id_client' => intval($_POST['id_client']),
            'id_offre' => intval($_POST['id_offre']),
            'statut' => $_POST['statut'] ?? '',
            'total' => floatval($_POST['total']) ?? '',
            'date_reservation' => date('Y-m-d', strtotime($_POST['date_reservation'])) ?? '',
            'date_fin' => date('Y-m-d', strtotime($_POST['date_fin'])) ?? '',
            'date_debut' => date('Y-m-d', strtotime($_POST['date_debut'])) ?? '',
            'code_promo' => $_POST['code_promo'] ?? '',
        ]);
    }
    header("Location:./liste.php");
    exit();
}
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
                    <form method="post" action="./ajouter.php">
                        <div class="row mb-3 mt-1">
                            <div class="col-4"><label for="id_client"><strong>ID Client :</strong></label></div>
                            <div class="col-8"><input type="number" id="id_client" name="id_client" class="form-control" min="0"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="id_offre"><strong>ID Offre :</strong></label></div>
                            <div class="col-8"><input type="number" id="id_offre" name="id_offre" class="form-control" min="0"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><strong>Date :</strong></label></div>
                            <div class="col-8"><input type="date" id="date_reservation" name="date_reservation" class="form-control" value="2022-11-09"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><strong>Date de début :</strong></label></div>
                            <div class="col-8"><input type="date" id="date_debut" name="date_debut" class="form-control" value="2022-12-04"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><strong>Date de fin :</strong></label></div>
                            <div class="col-8"><input type="date" id="date_fin" name="date_fin" class="form-control" value="2022-12-07"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="code"><strong>Code Promo :</strong></label></div>
                            <div class="col-8"><input type="text" id="code" name="code_promo" class="form-control" value=""></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="status"><strong>Status :</strong></label></div>
                            <div class="col-8">
                                <select id="status" name="statut" class="form-control">
                                    <option value="en_attente">en attente</option>
                                    <option value="confirmee">confirmée</option>
                                    <option value="terminee">terminée</option>
                                    <option value="annulee">annulée</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="total"><strong>Total :</strong></label></div>
                            <div class="col-8"><input type="number" id="total" name="total" class="form-control" step="0.01" value="0"></div>
                        </div>


                        <div class="row mb-3 text-center">
                            <div class="col-6">
                                <button type="submit" onclick="if(!confirm('Voulez-vous annuler ?')){event.preventDefault();}" class="btn btn-danger w-100">
                                    <i class="fas fa-times"></i>&nbsp;<strong>Annuler</strong>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="ajouter" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i>&nbsp;<strong>Ajouter</strong>
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