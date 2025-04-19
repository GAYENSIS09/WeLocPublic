<?php
class Autentification extends Dbase
{
    protected array $datatype = [
        'id' => 'integer',
        'id_utilisateur' => 'integer',
        'typeAuthent' => 'string',
        'dateAuthent' => 'datetime',
        'adresse_ip' => 'string',
        'device_info' => 'string',
    ];

    static private function add(array $data): void
    {
        $assembler = parent::assembler($data);
        $query = 'INSERT INTO Authentification ' . $assembler[0] . ' VALUES ' . $assembler[1];
        parent::instruction($query, $assembler[2]);
    }

    public static function connection(string $passwd, string $email, string $role): int
    {
        $user = parent::select("SELECT id, mot_de_passe FROM Utilisateur WHERE email = :email AND Utilisateur.role=:U_role", ["email" => $email, "U_role" => $role]);
        if ($user && password_verify($passwd, $user[0]['mot_de_passe'])) {
            $data = [
                'id_utilisateur' => $user[0]['id'],
                'typeAuthent' => 'connexion',
                'dateAuthent' => date('Y-m-d', time()),
                'adresse_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'device_info' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            ];
            Autentification::add($data);
            return $user[0]['id'];
        }
        return -1;
    }

    public static function deconnection(string $id_gerant):void
    {
             $data = [
                'id_utilisateur' => $id_gerant,
                'typeAuthent' => 'deconnexion',
                'dateAuthent' => date('Y-m-d', time()),
                'adresse_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'device_info' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            ];
            Autentification::add($data);
    }

    public static function changement_mdp(string $id_gerant):void
    {
             $data = [
                'id_utilisateur' => $id_gerant,
                'typeAuthent' => 'changement_mdp',
                'dateAuthent' => date('Y-m-d', time()),
                'adresse_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'device_info' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            ];
            Autentification::add($data);
    }
}
