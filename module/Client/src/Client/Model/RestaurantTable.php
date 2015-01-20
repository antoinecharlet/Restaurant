<?php
namespace Client\Model;

use Zend\Db\TableGateway\TableGateway;

class RestaurantTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getRestaurant($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveRestaurant(Restaurant $restaurant) {
        $data = array(
            'nb_place' => $restaurant->nb_place,
            'date' => $restaurant->date,
        );

        $id = (int) $restaurant->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRestaurant($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Restaurant id does not exist');
            }
        }
    }

    public function decrementePlace($nb_place, $date) {
        $this->tableGateway->update(array(
            'nb_place' => $nb_place), array(
            'date' => $date)
        );
    }

}

