<?php
class Rabc{
	public  function check($a){

		$ci = & get_instance();
		$ci->load->library('session');
		$strP=$ci->session->userdata('permission');
		if(getUserLevel(2)){
			return true;
			exit();
		}
		$strP=substr($strP, 1,-1);
		$arrP=explode("','", $strP);
		$a = strtolower($a);
		foreach ($arrP as $key => $value) {
			$arrP[$key] = strtolower($value);
		}
		return in_array($a,$arrP);
	}
	/*
		获取左侧导航目录
	*/
	function getMenu()
	{
		$CI = &get_instance();

		$CI->load->model('Manage_model');

		$arrMenuList = $CI->Manage_model->getMenu();

		$arrRes = array();

		if(!empty($arrMenuList))
		{
			$arrLinkMenu = array();
			foreach ($arrMenuList as $key => $arrMenu) {

				!isset($arrLinkMenu[$arrMenu['id']])?$arrLinkMenu[$arrMenu['id']]=array():"";

				if(empty($arrMenu['parent']) )
				{
					$arrMenu['_list'] = &$arrLinkMenu[$arrMenu['id']];
					$arrRes[] = $arrMenu;
				}else{
					$arrLinkMenu[$arrMenu['parent']][] = $arrMenu;
				}
			}
		}

		return $arrRes;
	}
}