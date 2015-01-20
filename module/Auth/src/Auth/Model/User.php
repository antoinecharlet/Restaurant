<?php
namespace Auth\Model;

class User
{
	public $mail;
	public $password;
	
	public function exchangeArray($data)
    {
        $this->mail = (isset($data['mail'])) ? $data['mail'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
    }
}