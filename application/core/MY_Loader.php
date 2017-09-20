<?php


class MY_Loader extends CI_Loader {
    
    public function __construct() {
        parent::__construct ();
    }
    public function myview($body, $data = array(), $arrLayout = array() ) {

    	$CI =& get_instance();
    	$arrMenu = $CI->rabc->getMenu();
        empty($arrLayout)?$arrLayout=array(
            'header'=>'base_header',
            'footer'=>'base_footer',
        ):"";

        $atfunc = $CI->router->fetch_class()."/".$CI->router->fetch_method();
        $arrHeaderData = array(
            'menulist'=>$arrMenu,
            'atfunc'=>$atfunc
        );
        $this->view ( "layer/{$arrLayout['header']}" , $arrHeaderData );
        $this->view ( $body,$data);
        $this->view ( "layer/{$arrLayout['footer']}");
    }
}