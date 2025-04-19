<?php
abstract class User extends Dbase{
    private int $id;
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected string $telephone;
    protected string $mot_de_passe;
    protected string $role;
    protected ?array $support;
    protected ?array $authentification;
    private DateTime $created_at;

}
?>