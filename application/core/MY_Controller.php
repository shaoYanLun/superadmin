<?php

class MY_Controller extends CI_Controller
{

    public $GUSER = null;

    function __construct()
    {
        parent::__construct();
        $this->GUSER = $this->init();
    }

    function init()
    {
        
    }
}