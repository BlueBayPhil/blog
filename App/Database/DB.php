<?php

namespace App\Database;

use mysqli;

class DB
{
    private static ?DB $instance = null;

    private $_host = 'localhost';
    private $_username = 'root';
    private $_password = '';
    private $_db = 'bb_blog';

    private ?mysqli $dn = null;

    private function __construct() {
        $this->dn = new mysqli($this->_host, $this->_username, $this->_password, $this->_db);

        if($this->dn->connect_errno) {
            die("Failed to connect to database!<br>" . $this->dn->connect_error);
        }
    }

    public static function instance() : mysqli {
        if(null == DB::$instance) {
            DB::$instance = new DB();
        }

        return DB::$instance->dn;
    }
}