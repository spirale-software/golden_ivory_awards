<?php namespace G_I_A\Exception;

class DAOException extends \Exception {
    
    public function __construct($message) {
        parent:: __construct($message);
    }
}
