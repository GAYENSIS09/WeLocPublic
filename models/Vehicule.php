<?php
// include_once('/var/www/html/WeLoc/models/Image_Vehicule.php');
class Vehicule extends Dbase
{
    protected array $data = [];
    protected array $datatype = [
        'id' => 'integer',
        'marque' => 'string',
        'modele' => 'string',
        'transmission' => 'string',
        'type' => 'string',
        'annee' => 'string',
        'prix_par_jour' => 'double',
        'carburant' => 'string',
        'disponibilite' => 'string',
        'agence_id' => 'integer',
        'etat' => 'string',
        'image_vehicule' => 'array',
        'entretien' => 'array',
        'offre_Location' => 'array',
    ];
    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'insert into Vehicule ' . $assembler[0] . ' values ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
        Image_Vehicule::add_imgs($this->data['image_vehicule'],intval(parent::$lastId)
    );
    }
    public static function get(int $id):array{
        return parent::select("select * from Vehicule where id=$id");
    }
    public static function delete(int $id){
        parent::instruction("delete from Vehicule where id=:id",['id'=>$id]);
    }
    public static function update(int $id,array $data){
        parent::instruction("update Vehicule set ".parent::equalizer($data)." where id={$id}",$data);
    }

    public static function is_id(int $id_vehicule,$agence_id):int{
        $tables= parent::select("SELECT id FROM Vehicule WHERE agence_id=:agence_id",["agence_id"=>$agence_id]);
        foreach($tables as $table){
            if($table['id']===$id_vehicule){
                return 1;
            }
        }
        return 0;
    }

    public static function ShowAll(int $agence_id){
        $tables= parent::select("select * from Vehicule where agence_id=:agence_id",["agence_id"=>$agence_id]);
        foreach($tables as $table){
            echo " <tr>
            <td>
                {$table['id']}
            </td>
            <td>
                {$table['marque']}
            </td>
            <td>
                {$table['modele']}
            </td>
            <td>
                {$table['annee']}
            </td>
            <td>
                {$table['type'] }
            </td>
            <td>";
             echo $table['disponibilite'] ? 'OUI' : 'NON';
            echo "</td>
            <td>
                 <a href='./DetailVoiture.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
            </td>
        </tr>";
        }
    

    }
}
