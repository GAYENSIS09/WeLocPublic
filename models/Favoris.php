<?php
class Favoris {
    private int $id;
    private int $id_client;
    private int $id_vehicule;

    public function __construct(int $id, int $id_client, int $id_vehicule) {
        $this->id = $id;
        $this->id_client = $id_client;
        $this->id_vehicule = $id_vehicule;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdClient(): int {
        return $this->id_client;
    }

    public function getIdVehicule(): int {
        return $this->id_vehicule;
    }
}
?>