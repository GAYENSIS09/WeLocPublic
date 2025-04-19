<?php 
    class Reservation extends Dbase{
       protected array $datatype = [
            'id' => 'integer',
            'id_client' => 'integer',
            'id_offre' => 'integer',
            'statut' => 'string',
            'date_reservation' => 'string',
            'date_debut' => 'string',
            'date_fin' => 'string',
            'total' => 'double',
            'code_promo' => 'string', 
            'paiment' => 'Paiement'
        ];
        public function add(array $data): void
        {
            $this->setAttributs($data);
            $assembler = $this->assembler($data);
            $query = 'insert into Reservation ' . $assembler[0] . ' values ' . $assembler[1];
            $this->instruction($query, $assembler[2]);
        }
        public static function get(int $id):array{
            return parent::select("select * from Reservation where id=$id");
        }
        public static function delete(int $id){
            parent::instruction("delete from Reservation where id=:id",['id'=>$id]);
        }
        public static function update(int $id,array $data){
            parent::instruction("update Reservation set ".parent::equalizer($data)." where id={$id}",$data);
        }

        public static function is_id(int $id_reservation,$agence_id):int{
            $tables= parent::select("select R.id from Reservation R JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
            foreach($tables as $table){
                if($table['id']===$id_reservation){
                    return 1;
                }
            }
            return 0;
        }
    

        public static function ShowAll(int $agence_id){
            $tables= parent::select("select R.* from Reservation R JOIN Offre_Location O ON O.id=R.id_offre JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id",['agence_id'=>$agence_id]);
            foreach($tables as $table){
                echo " <tr>
                <td>
                    {$table['id']}
                </td>
                <td>
                    {$table['id_client']}
                </td>
                <td>
                    {$table['id_offre']}
                </td>
                <td>
                    {$table['statut']}
                </td>
                <td>
                    {$table['date_reservation'] }
                </td>
                <td>
                    {$table['date_debut'] }
                </td>
                <td>
                    {$table['date_fin'] }
                </td>
               <td>
                    {$table['code_promo'] }
                </td>
                <td>
                     <a href='./DetailReservation.php?id={$table['id']}'><button class='more-btn'><i class='bi bi-eye'></i></button></a>
                </td>
            </tr>";
            }
        }
        public static function ShowRetards(int $agence_id){
            $tables= parent::select("select O.id_vehicule,R.id_client,U.nom,U.prenom,U.telephone,R.date_fin from Reservation R JOIN Offre_Location O ON O.id=R.id_offre AND R.date_fin<CURDATE() JOIN Utilisateur U ON U.id=R.id_client JOIN Vehicule V ON V.id=O.id_vehicule AND V.agence_id=:agence_id AND V.disponibilite=0",['agence_id'=>$agence_id]);
            foreach($tables as $table){
                echo " <tr>
                <td>
                    {$table['id_vehicule']}
                </td>
                <td>
                    {$table['id_client']}
                </td>
                <td>
                    {$table['nom']}
                </td>
                <td>
                    {$table['prenom']}
                </td>
                <td>
                    {$table['telephone'] }
                </td>
                <td>
                    {$table['date_fin'] }
                </td>
            </tr>";
            }
        }
    }
?>