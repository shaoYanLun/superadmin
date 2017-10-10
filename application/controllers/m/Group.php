<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }

    function ajaxAddGroup()
    {}

    function ajaxUpdateGroup()
    {}

    function ajaxDelGroup()
    {}
}