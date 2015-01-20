<?php

namespace Client\Model;

class Restaurant {

    public $nb_place;
    public $date;
    
    public function exchangeArray($data) {
        $this->nb_place = (isset($data['nb_place'])) ? $data['nb_place'] : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
    }


}