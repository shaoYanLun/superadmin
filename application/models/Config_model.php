<?php

class Config_model extends CI_Model
{

    private static $_strPlatConfig = 'plat_config';

    private static $_db = "";

    private static $gconfig;

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            self::$_db = $this->load->database('default', true);
        }
    }

    public static function getPlatConfig()
    {
        if (self::$gconfig) {
            return self::$gconfig;
        }
        $sql = "select * from " . self::$_strPlatConfig;
        $config = self::$_db->query($sql)->result_array();
        if (! $config) {
            return false;
        }
        $arrConfig = array();
        foreach ($config as $key => $value) {
            $arrConfig[$value['ckey']] = $value['cvalue'];
        }
        self::$gconfig = $arrConfig;
        return $arrConfig;
    }
}