<?php
namespace Inscription\Model;

class Inscription{

    public $id;
    public $nom;
    public $prenom;
    public $mail;
    public $password;       

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nom = (isset($data['nom'])) ? $data['nom'] : null;
        $this->prenom = (isset($data['prenom'])) ? $data['prenom'] : null;
        $this->mail = (isset($data['mail'])) ? $data['mail'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
    }


}
