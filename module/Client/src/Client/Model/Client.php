<?php

namespace Client\Model;

class Client {

    public $id;
    public $date;
    
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
    }


}
