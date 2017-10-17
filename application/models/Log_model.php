<?php

class Log_model extends CI_Model
{
   private $_strOpLog = "oplog";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }

    function getLog() {
        $p = "*";
        $sql = " select {$p} from {$this->_strOpLog} where 1=1  ";
        $sqlNum = " select count(*) as num from {$this->_strOpLog} where 1=1 ";
        
        $arrWhere = array();
        $arrWhereNum = array();
        
        if (isset($arr['ls'])) {
            $sql .= " limit ? , ?";
            $arrWhere[] = $arr['ls'];
            $arrWhere[] = $arr['le'];
        }
        
        $list = $this->_db->query($sql, $arrWhere)->result_array();
        $arrCount = $this->_db->query($sqlNum, $arrWhereNum)->row_array();
        
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }
    
}