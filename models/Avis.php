<?php
    class Avis {
        private int $id;
        private int $id_client;
        private int $id_vehicule;
        private int $note;
        private string $commentaire;
        private DateTime $date;
        private string $status;

        public function getId(): int {
            return $this->id;
        }

        public function getIdClient(): int {
            return $this->id_client;
        }

        public function getIdVehicule(): int {
            return $this->id_vehicule;
        }

        public function getNote(): int {
            return $this->note;
        }

        public function getCommentaire(): string {
            return $this->commentaire;
        }

        public function getDate(): DateTime {
            return $this->date;
        }

        public function getStatus(): string {
            return $this->status;
        }
    }
?>