<?php
namespace Inscription\Model;

use Zend\Db\TableGateway\TableGateway;

class InscriptionTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function saveInscription(Inscription $inscription) {
        $data = array(
            'nom' => $inscription->nom,
            'prenom' => $inscription->prenom,
            'mail' => $inscription->mail,
            'password' => $inscription->password,
        );

        $this->tableGateway->insert($data);
    }
}
