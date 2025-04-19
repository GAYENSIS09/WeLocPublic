<?php
require '/var/www/html/WeLoc/includes/FPDF/fpdf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/WeLoc/includes/PHPMailer/src/Exception.php';
require '/var/www/html/WeLoc/includes/PHPMailer/src/PHPMailer.php';
require '/var/www/html/WeLoc/includes/PHPMailer/src/SMTP.php';
class email extends FPDF
{
    function genererFacture($facture)
    {
        $this->AddPage();
        if (file_exists('/var/www/html/WeLoc/assets/img/logo.png')) {
            $this->Image('/var/www/html/WeLoc/assets/img/logo.png', 10, 6, 30);
        }
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Facture de Location', 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', '', 12);

        $this->Cell(0, 10, 'Facture N : ' . $facture['id'], 0, 1, 'L');
        $this->Cell(0, 10, 'Date d\'emission : ' . $facture['date_emission'], 0, 1, 'L');
        $this->Ln(5);


        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(255, 100, 100);
        $this->Cell(95, 10, 'Informations du Client', 0, 0, 'L', true);
        $this->Cell(0, 10, '', 0, 1);

        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(95, 10, 'client(e) : ' . $facture['prenom'] . ' ' . $facture['nom'], 1, 0, 'L', true);
        $this->Cell(95, 10, 'Email : ' . $facture['email'], 1, 1, 'R', true);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(95, 10, 'Details de la Location', 0, 0, 'L', true);
        $this->Cell(0, 10, '', 0, 1);


        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(95, 10, 'Date de depart : ' . $facture['date_depart'], 1, 0, 'L', true);
        $this->Cell(95, 10, 'Date d\'arrivee : ' . $facture['date_arrivee'], 1, 1, 'R', true);
        $this->Ln(10);


        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);


        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(80, 10, 'Designation', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Quantite', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Prix Unitaire', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Total', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 12);

        $this->Cell(80, 10, 'Reservation', 1);
        $this->Cell(30, 10, $facture['qte_reservation'], 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_unit_reservation'], 0, ',', ' ') . ' CFA', 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_tot_reservation'], 0, ',', ' ') . ' CFA', 1, 1, 'C');

        $this->Cell(80, 10, 'Location', 1);
        $this->Cell(30, 10, $facture['qte_location'], 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_unit_location'], 0, ',', ' ') . ' CFA', 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_tot_location'], 0, ',', ' ') . ' CFA', 1, 1, 'C');

        $this->Cell(80, 10, 'Supplement', 1);
        $this->Cell(30, 10, $facture['qte_sup'], 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_unit_sup'], 0, ',', ' ') . ' CFA', 1, 0, 'C');
        $this->Cell(40, 10, number_format($facture['p_tot_sup'], 0, ',', ' ') . ' CFA', 1, 1, 'C');

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(150, 10, 'Montant Total : ', 0, 0, 'R');
        $this->Cell(40, 10, number_format($facture['montant_total'], 0, ',', ' ') . ' CFA', 1, 1, 'C');

        $this->Ln(90);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Merci pour votre confiance !', 0, 1, 'C');
        $path = "/var/www/html/WeLoc/public/factures/facture_" . $facture['id_paiement'] . ".pdf";
        $this->Output($path, 'F');

        return $path;
    }

    function sendFacture($facture)
    {
        if (!$facture) {
            die("Facture introuvable.");
        }

        $pdfPath = $this->genererFacture($facture);

        if (!file_exists($pdfPath)) {
            die("Erreur : la facture n'existe pas !");
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'adounake@gmail.com';
            $mail->Password   = 'gnib zezg zpkh sivf';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('adounake@gmail.com', 'WeLoc');

            if (!filter_var($facture['email'], FILTER_VALIDATE_EMAIL)) {
                die("Adresse e-mail invalide");
            }

            $mail->addAddress($facture['email'], $facture['prenom'] . ' ' . $facture['nom']);
            $mail->addAttachment($pdfPath, 'Facture.pdf');

            $mail->isHTML(true);
            $mail->Subject = 'Votre facture';
            $mail->Body    = 'Bonjour ' . $facture["prenom"] . " " . $facture["nom"] . ' , <br> Vous trouverez en pièce jointe votre facture.<br><br> Cordialement, <br> WeLoc.';
            $mail->AltBody = 'Bonjour, Vous trouverez en pièce jointe votre facture. Cordialement, WeLoc.';

            $mail->send();
            echo "Facture envoyee avec succès.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi : {$e->getMessage()}";
        }
    }

    function sendMessage($MScontainer){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'adounake@gmail.com';
            $mail->Password   = 'gnib zezg zpkh sivf';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            $mail->setFrom('adounake@gmail.com', 'WeLoc');

            if (!filter_var($MScontainer['email'], FILTER_VALIDATE_EMAIL)) {
                die("Adresse e-mail invalide");
            }
            
            $mail->addAddress($MScontainer['email'], $MScontainer['prenom'] . ' ' . $MScontainer['nom']);
            $mail->isHTML(true);
            $mail->Subject = $MScontainer['sujet'];
            $mail->Body    = 'Bonjour ' . $MScontainer["prenom"] . " " . $MScontainer["nom"] . ' , <br> <p>'.$MScontainer['contenue'].'</p>.<br><br> Cordialement,<br> WeLoc.';
            $mail->AltBody = $MScontainer['contenue'].'. Cordialement, WeLoc.';
            $mail->send();
            
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi : {$e->getMessage()}";
        }
    }

}
