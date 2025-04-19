<?php
class Gerant extends User
{
    protected array $datatype = ['id' => 'inteeger', 'nom' => 'string', 'prenom' => 'string', 'email' => 'string', 'telephone' => 'string', 'mot_de_passe' => 'string', 'role' => 'string', 'created_at' => 'string', 'role_specifique' => 'string'];
    public function get($id): array
    {
        return parent::select("SELECT * FROM Utilisateur U JOIN Gerant G ON G.id_utilisateur=U.id WHERE id=:id", ['id' => $id]);
    }
    public function getAgences(int $id_gerant)
    {
        return parent::select("SELECT id,nom FROM Agence WHERE id_gerant=:id_gerant", ['id_gerant' => $id_gerant]);
    }
    static function addPhoto(array $photo, int $id,string $old_path)
    {
        if (!$photo['error']) {
            $path = "../.././public/img/" . strval(time()) . "_" . basename($photo['name']);
            if (!move_uploaded_file($photo['tmp_name'], $path)) {
                throw new Exception('echec de transfert vers le folder !');
            }
            parent::instruction("UPDATE Utilisateur SET photo=:photo WHERE id=:id", ['photo' => $path, 'id' => $id]);
            if (!unlink("/var/www/html/WeLoc/public/img/".basename($old_path))) {
                throw new Exception('echec de suppression !');
            } 
        } else {
            throw new Exception('echec de telechargement !');
        }
    }
    public static function update(int $id, array $data)
    {
        if (empty($data['mot_de_passe'])) unset($data['mot_de_passe']);
        parent::instruction("update Utilisateur set " . parent::equalizer($data) . " where id={$id}", $data);
    }
    
    public function ShowAgence(int $id_gerant)
    {
        $tables = parent::select("SELECT * FROM Agence  WHERE id_gerant=:id_gerant", ['id_gerant' => $id_gerant]);
        foreach ($tables as $table) {
            echo " <tr>
            <td>
                {$table['nom']}
            </td>
            <td>
                {$table['adresse']}
            </td>
            <td>
                {$table['email']}
            </td>
            <td>
                {$table['horaires_ouverture']}
            </td>
        </tr>";
        }
    }
}
