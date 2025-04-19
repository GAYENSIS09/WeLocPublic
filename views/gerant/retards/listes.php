<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Liste des Retards</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID-voiture</th>
                                <th>ID-client</th>
                                <th>nom</th>
                                <th>Prenom</th>
                                <th>Telephone</th>
                                <th>Date initiale de retour</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID-voiture</th>
                                <th>ID-client</th>
                                <th>nom</th>
                                <th>Prenom</th>
                                <th>Telephone</th>
                                <th>Date initiale de retour</th>
                            </tr>
                        </tfoot>
                        <tbody> <?php
                                Reservation::ShowRetards($_SESSION['agence_id']);
                                ?> </tbody>
                    </table>
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
<!-- /code -->

<!-- footer -->
<?php include_once(".././pages_sections/footer.php"); ?>
<!-- /footer -->