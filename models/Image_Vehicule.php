<?php
// include_once('/var/www/html/WeLoc/models/Dbase.php');
class Image_Vehicule extends Dbase
{
    protected array $datatype = [
        'id' => 'integer',
        'id_vehicule' => 'integer',
        'url_image' => 'string',
    ];
    private function add(array $data): void
    {
        $assembler = $this->assembler($data);
        $query = 'insert into Image_Vehicule ' . $assembler[0] . ' values ' . $assembler[1];
        $this->instruction($query, $assembler[2]);
    }
    static public function add_imgs(array $uploaded_imgs, int $id_vehicule)
    {
        $paths = [];
        foreach ($uploaded_imgs['name'] as $key => $name) {
            if (!$uploaded_imgs['error'][$key]) {
                $paths[$key] = "/var/www/html/WeLoc/public/img-cars/" . strval(time()) . "_" . basename($name);
              if(!move_uploaded_file($uploaded_imgs['tmp_name'][$key], $paths[$key])){
                    throw new Exception('echec de transfert vers le folder !');
                }
            } else {
                throw new Exception('echec de telechargement !');
            }
        }
        // si enregistrement local effectuée je procede a celui de la base de donnée
        foreach ($paths as $path) {
            $tmp_img = new Image_Vehicule();
            $tmp_img->setAttributs([
                'id_vehicule' => $id_vehicule,
                'url_image' => $path,
            ]);
            $tmp_img->add($tmp_img->data);
        }
    }
    public static function get(int $id):array{
        return parent::select("select id,url_image from Image_Vehicule where id_vehicule=$id");
    }
    public static function delete(int $id){
        $paths=self::get($id);
        parent::instruction("delete from Image_Vehicule where id=:id",['id'=>$id]);
        foreach($paths as $e) {
                  if($e['id']===$id){
                   unlink("/var/www/html/WeLoc/public/img-cars/".basename($e['url_image']));
                }
        }   
    }
    public static function showAll(array $paths){
        echo '<table>
                <tr>';
        foreach(array_reverse($paths) as $e) {
            echo '<td class="photo-container">
                    <img src="../../.././public/img-cars/'.basename($e['url_image']).'" class="liste-photos">
                    <input type="hidden" value="'.$e['id'].'"/>
                  </td>';
        }
        echo '</tr>
            </table>';
    }
    
    public static function showOne(array $paths){
        foreach(array_reverse($paths) as $e) {
            echo '<img src="../../.././public/img-cars/'.basename($e['url_image']).'" alt="img-voiture" id="img_voiture">
                  <input id="hiddenId" type="hidden" name="id" value="'.$e['id'].'"/>';
            break;
        }   
    }
    
    
}
