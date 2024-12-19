<?php 
require_once 'BaseController.php'; 
 
class dummyController extends BaseController { 
    public function __construct($db) { 
        parent::__construct($db, ['#']);  
    } 
 
} 
