<?php
    class Support{
        private int $id;
        private int $id_utilisateur;
        private string $message;
        private string $type;
        private DateTime $date;
        private string $reponse;
        public function __construct(int $id, int $id_utilisateur, string $message, string $type, DateTime $date, string $reponse) {
            $this->id = $id;
            $this->id_utilisateur = $id_utilisateur;
            $this->message = $message;
            $this->type = $type;
            $this->date = $date;
            $this->reponse = $reponse;
        }

        public function getId(): int {
            return $this->id;
        }

        public function getIdUtilisateur(): int {
            return $this->id_utilisateur;
        }

        public function getMessage(): string {
            return $this->message;
        }

        public function getType(): string {
            return $this->type;
        }

        public function getDate(): DateTime {
            return $this->date;
        }

        public function getReponse(): string {
            return $this->reponse;
        }
    }
?>