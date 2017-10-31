<?php

class Order_model extends CI_Model
{
    private $_strOrder = 'test_order';
    private $_strGoods = 'test_goods';
    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }
    function getOrderlist($arrWhere = array() )
    {
        $sql = " select o.*,g.name from {$this->_strOrder} as o left join {$this->_strGoods} as g on o.gid = g.id where 1=1  ";
        $sqlNum = " select count(*) as num from {$this->_strOrder} where 1=1 ";
        $arrParam = array();
        $arrParamNum = array();

        if (isset($arrWhere['status'])) {
            $sql .= " and o.status = ? ";
            $sqlNum .= " and status = ? ";
            $arrParam[] = $arrWhere['status'];
            $arrParamNum[] = $arrWhere['status'];
        }

        if (isset($arrWhere['ls'])) {
            $sql .= " limit ? , ?";
            $arrParam[] = $arrWhere['ls'];
            $arrParam[] = $arrWhere['le'];
        }

        $list = $this->_db->query($sql, $arrParam)->result_array();
        $arrCount = $this->_db->query($sqlNum, $arrParamNum)->row_array();
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }
}