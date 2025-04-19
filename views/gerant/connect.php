<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/autoload.php';

function convert_to_assoc(array $tableau): array
{
    $resultat = [];
    foreach ($tableau as $key => $value) {
        if (!is_int($key)) {
            $resultat[$key] = $value;
        }
    }
    return $resultat;
}

$gerant = new Gerant();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['user_id'], $_POST['agence_id'])) {
        $_SESSION['agence_id'] = intval($_POST['agence_id']);
        header("Location: ./gerant.php");
        exit();
    }

    if (!empty($_POST['Username2']) && !empty($_POST['InputEmail2']) && !empty($_POST['InputPassword2'])) {
        $tmp = Autentification::connection(
            $_POST['InputPassword2'],
            $_POST['InputEmail2'],
            $_POST['role']
        );

        if ($tmp < 0) {
            die("Erreur d'authentification.");
        }
        $_SESSION['user_id'] = intval($tmp);
        header("Location: ./gerant.php");
        exit();
    }

    if (isset($_SESSION['user_id'], $_POST['deconnect'])) {
        Autentification::deconnection($_SESSION['user_id']);
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
        exit();
    }
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'] ?? null;

    if ($userId) {
        $user = $gerant->get($userId);
        $agences = $gerant->getAgences($userId);

        $_SESSION['user'] = array_map('convert_to_assoc', $user)[0] ?? [];
        $_SESSION['agences'] = array_map('convert_to_assoc', $agences);

        if (empty($_SESSION['agence_id']) && !empty($_SESSION['agences'][0]['id'])) {
            $_SESSION['agence_id'] = intval($_SESSION['agences'][0]['id']);
        }
    }
}
