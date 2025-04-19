<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
} ?>

<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Liste des Paiements</h1>
            <ol class="breadcrumb mb-4">
                <!-- <li class="breadcrumb-item active">user name</li> -->
            </ol>

            <div class="row">

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Paiements
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID-reservation</th>
                                    <th>ID-transaction</th>
                                    <th>Mode de Paiements</th>
                                    <th>Date</th>
                                    <th>status</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>ID-reservation</th>
                                    <th>ID-transaction</th>
                                    <th>Mode de Paiements</th>
                                    <th>Date</th>
                                    <th>status</th>
                                    <th>Montant</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                Paiement::ShowAll($_SESSION['agence_id']);
                                ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div> <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->

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