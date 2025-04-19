<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Location de Voiture</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #004080;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .banner {
            background: url('https://source.unsplash.com/1600x900/?car,rental') no-repeat center center/cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .search-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .car-card img {
            transition: 0.3s;
        }
        .car-card:hover img {
            transform: scale(1.05);
        }
        .testimonial {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #004080;
            color: white;
            padding: 15px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">LocationAuto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Nos voitures</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Réserver</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bannière -->
<header class="banner">
    <h1 class="fw-bold">Louez une voiture en toute simplicité</h1>
</header>

<!-- Formulaire de recherche -->
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="search-section">
                <h4 class="text-center mb-3">Rechercher une voiture</h4>
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Lieu</label>
                            <input type="text" class="form-control" placeholder="Ville ou aéroport">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de début</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de fin</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-primary w-100">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Liste des voitures -->
<div class="container my-5">
    <h2 class="text-center mb-4">Nos voitures disponibles</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card car-card shadow">
                <img src="https://source.unsplash.com/400x300/?toyota,car" class="card-img-top" alt="Voiture">
                <div class="card-body">
                    <h5 class="card-title">Toyota Corolla</h5>
                    <p class="card-text">À partir de 50€/jour</p>
                    <a href="#" class="btn btn-outline-primary w-100">Réserver</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card car-card shadow">
                <img src="https://source.unsplash.com/400x300/?bmw,car" class="card-img-top" alt="Voiture">
                <div class="card-body">
                    <h5 class="card-title">BMW X5</h5>
                    <p class="card-text">À partir de 120€/jour</p>
                    <a href="#" class="btn btn-outline-primary w-100">Réserver</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card car-card shadow">
                <img src="https://source.unsplash.com/400x300/?renault,car" class="card-img-top" alt="Voiture">
                <div class="card-body">
                    <h5 class="card-title">Renault Clio</h5>
                    <p class="card-text">À partir de 40€/jour</p>
                    <a href="#" class="btn btn-outline-primary w-100">Réserver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Témoignages -->
<div class="container my-5">
    <h2 class="text-center mb-4">Avis Clients</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="testimonial">
                <p>“Service impeccable ! La voiture était en parfait état et la réservation simple.”</p>
                <h6 class="text-end">- Jean Dupont</h6>
            </div>
        </div>
        <div class="col-md-6">
            <div class="testimonial">
                <p>“Je recommande à 100%, excellent rapport qualité/prix.”</p>
                <h6 class="text-end">- Sophie Martin</h6>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center">
    <p>&copy; 2025 LocationAuto. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

