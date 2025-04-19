<?php 
class Offre_Locaton extends Dbase {
    protected array $datatype = [
        'id' => 'integer',
        'description' => 'string',
        'id_Vehicule' => 'integer',
        'description' => 'string',
        'tarif' => 'double',
        'date_debut' => 'string',
        'date_fin' => 'string',
        'conditions'=> 'string',
        'reservation' => 'array',
    ];
    public function add(array $data): void
    {
        $this->setAttributs($data);
        $assembler = $this->assembler($data);
        $query = 'insert into Offre_Location ' . $assembler[0] . ' values ' . $assembler[1];
        
        $this->instruction($query, $assembler[2]);
    }

    public static function is_id(int $id_offre,$agence_id):int{
        $tables= parent::select("select O.id from Offre_Location O JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id where DATEDIFF(date_fin,CURDATE())>0",['agence_id'=>$agence_id]);
        foreach($tables as $table){
            if($table['id']===$id_offre){
                return 1;
            }
        }
        return 0;
    }

    public static function ShowActual(int $agence_id){
        $tables= parent::select("select O.* from Offre_Location O JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id where DATEDIFF(date_fin,CURDATE())>0",['agence_id'=>$agence_id]);
        foreach($tables as $table){
            echo " <tr>
            <td>
                {$table['id']}
            </td>
            <td>
                {$table['id_vehicule']}
            </td>
            <td>
                {$table['description']}
            </td>
            <td>
                {$table['tarif']}
            </td>
            <td>
                {$table['date_debut'] }
            </td> 
            <td>
                {$table['date_fin'] }
            </td>
            
            <td>
                 <a href='./Details-offre.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
            </td>
        </tr>";
        }
    }

    public static function ShowPast(int $agence_id){
        $tables= parent::select("select O.* from Offre_Location O  JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id where DATEDIFF(date_fin,CURDATE())<=0",['agence_id'=>$agence_id]);
        foreach($tables as $table){
            echo " <tr>
            <td>
                {$table['id']}
            </td>
            <td>
                {$table['id_vehicule']}
            </td>
            <td>
                {$table['description']}
            </td>
            <td>
                {$table['tarif']}
            </td>
            <td>
                {$table['date_debut'] }
            </td> 
            <td>
                {$table['date_fin'] }
            </td>
           
            <td>
                 <a href='./Details-offre.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
            </td>
        </tr>";
        }
    }
    public static function get(int $id):array{
        return parent::select("select * from Offre_Location where id=$id");
    }
    public static function delete(int $id){
        parent::instruction("delete from Offre_Location where id=:id",['id'=>$id]);
    }
    public static function update(int $id,array $data){
        parent::instruction("update Offre_Location set ".parent::equalizer($data)." where id={$id}",$data);
    }
}
?>