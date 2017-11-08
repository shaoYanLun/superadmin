<?php
class Autotemp{
	//是否覆盖已存在文件
	public $_overfile = false;
	/*
		model 生成中使用
	*/
	public $_database = "default";
	/*
		数据库名
	*/
	public $_tablename = "";
	/*
		查询字段
	*/
	public $_field = "";
	/*
		文件名
		默认与数据库名同
	*/
	public $_filename = "";



	/*
		生成文件存放目录
	*/
	private $_pathOutController = APPPATH."controllers/";
	private $_pathOutModel = APPPATH."models/";
	private $_pathOutView = APPPATH."views/";
	/*
		模板存放目录
	*/
	private $_pathTempController =APPPATH."libraries/autotemp/temp_controller.temp";
	private $_pathTempModel =APPPATH."libraries/autotemp/temp_model.temp";
	private $_pathTempView =APPPATH."libraries/autotemp/temp_view.temp";

	private $_mysqli = "";
	private $_databaseName = "";


	private $_resinfo = array();

	function creater($config = array())
	{

		$arrInit = $this->init($config);

		if($arrInit['code']!=1)
		{
			return $arrInit;
		}
		$arrView = $this->creatView();

		if($arrView['code']!=1)
		{
			return $arrView;
		}

		//生成控制器
		$arrContro = $this->creatController();
		if($arrContro['code']!=1)
		{
			return $arrContro;
		}
		

		$arrModel = $this->creatModel();

		if($arrModel['code']!=1)
		{
			return $arrModel;
		}

		return $this->resMsg("ok");
	}

	/*
		单独调用某个方法生成文件时，初始化使用
	*/
	function init($config)
	{
		foreach ($config as $key => $value) {
			isset($this->$key) && $this->$key =strtolower( $value);
		}
		if(empty($this->_tablename))
		{
			return $this->resMsg("缺少数据库名配置");
		}
		if(!$this->check_dir_iswritable($this->_pathOutController) ||!$this->check_dir_iswritable($this->_pathOutModel)|| !$this->check_dir_iswritable($this->_pathOutView))
		{
			return $this->resMsg("检查目录是否拥有可写权限");
		}

		$this->connectdb();
		if(empty($this->_mysqli) || !is_object($this->_mysqli))
		{
			return $this->resMsg("数据链接失败");
		}

		return $this->resMsg("ok");

	}
	//创建控制器
	function creatController()
	{
		$phpTempController = file_get_contents($this->_pathTempController);

		empty($this->_filename) && $this->_filename = $this->_tablename;
		$phpTempController = str_replace("{{FILENAME}}",ucfirst( $this->_filename), $phpTempController);
		$phpTempController = str_replace("{{FILENAMELOW}}", $this->_filename, $phpTempController);

		$fileconstroller = $this->_pathOutController.ucfirst($this->_filename).".php";
		$this->_resinfo['file'][] = $fileconstroller;
		return $this->output($fileconstroller , "<?php\n".$phpTempController."\n?>");
	}
	//创建模板
	function creatView()
	{

		$sql = "SELECT COLUMN_NAME,column_comment FROM INFORMATION_SCHEMA.Columns WHERE table_name='".$this->_tablename."' AND table_schema='".$this->_databaseName."'";
		$result = $this->_mysqli->query($sql);
		$fieldComment = array();
		while ($row = $result->fetch_assoc() ) {
			$fieldComment[$row['COLUMN_NAME']] = empty($row['column_comment'])?$row['COLUMN_NAME']:trim($row['column_comment']);
		}
		if(empty($fieldComment))
		{
			return $this->resMsg("检查数据表是否存在");
		}

		$HtmlTitle = "";
		$HtmlField = "";
		if(trim($this->_field) =="*")
		{
			foreach ($fieldComment as $key => $value) {
				$HtmlTitle.= "<th>{$value}</th>\n\t\t\t\t\t";
				$HtmlField.= "<td><?php echo \$value['".$key."'];?></td>\n\t\t\t\t\t";
			}
		}

		$phpTempView = file_get_contents($this->_pathTempView );

		empty($this->_filename) && $this->_filename = $this->_tablename;

		$phpTempView = str_replace("{{TITLE}}",$HtmlTitle, $phpTempView);
		$phpTempView = str_replace("{{FIELD}}",$HtmlField, $phpTempView);


		$fileViewPath = $this->_pathOutView.$this->_filename;
		if(!is_dir($fileViewPath))
		{
			mkdir($fileViewPath , 0777 , true);
			$this->_resinfo['dir'][] = $fileViewPath;
		}
		$this->_resinfo['file'][] = $fileViewPath."/index.php";
		return $this->output($fileViewPath."/index.php" , $phpTempView);
	}
	function creatModel()
	{
		$phpTempModel = file_get_contents($this->_pathTempModel);

		empty($this->_filename) && $this->_filename = $this->_tablename;
		$phpTempModel = str_replace("{{FILENAME}}",ucfirst( $this->_filename), $phpTempModel);
		$phpTempModel = str_replace("{{TABLENAME}}",strtolower( $this->_tablename), $phpTempModel);

		$strtable = $this->tableToStr( $this->_tablename);
		$phpTempModel = str_replace("{{STRTABLE}}",$strtable, $phpTempModel);
		$phpTempModel = str_replace("{{DATABASE}}",strtolower( $this->_database), $phpTempModel);

		$field = empty($this->_field)?"*":$this->_field;
		$sql = "select {$field} from {\$this->_{$strtable}} where 1=1 ";
		$sqlnum = "select count(*) as num from {\$this->_{$strtable}} where 1=1 ";

		$phpTempModel = str_replace("{{SQL}}",$sql, $phpTempModel);
		$phpTempModel = str_replace("{{SQLNUM}}", $sqlnum, $phpTempModel);

		$filemodel = $this->_pathOutModel.ucfirst($this->_filename)."_model.php";
		$this->_resinfo['file'][] = $filemodel;
		$this->_resinfo['sql'] = $sql;
		return $this->output($filemodel , "<?php\n".$phpTempModel."\n?>");
	}
	function tableToStr($table)
	{
		if(empty($table))
		{
			return "";
		}
		$arrTable = explode("_", $table);
		$strTable = "";
		foreach ($arrTable as $key => $value) {
			$strTable.= ucfirst($value);
		}
		return "str".$strTable;
	}
	//判断文件是否可写
	function check_dir_iswritable($dir_path){
		$is_writale=1;
		if(!is_dir($dir_path)){
			$is_writale=0;
			return $is_writale;
		}else{
			$file_hd=@fopen($dir_path.'/test.txt','w');
			if(!$file_hd){
				$is_writale=0;
				return $is_writale;
			}
			@fclose($file_hd);
			@unlink($dir_path.'/test.txt');
			$dir_hd=opendir($dir_path);
			while(false!==($file=readdir($dir_hd))){
				if ($file != "." && $file != "..") {
					if(is_file($dir_path.'/'.$file)){
						//文件不可写，直接返回
						if(!is_writable($dir_path.'/'.$file)){
						return 0;
						}
					}else{
						$file_hd2=@fopen($dir_path.'/'.$file.'/test.txt','w');
						if(!$file_hd2){
							$is_writale=0;
							return $is_writale;
						}
						@fclose($file_hd2);
						@unlink($dir_path.'/'.$file.'/test.txt');
						//递归
						$is_writale=$this->check_dir_iswritable($dir_path.'/'.$file);
					}
				}
			}
		}
		return $is_writale;
	}

	function resinfo()
	{
		return $this->_resinfo;
	}

	private function output($file , $content)
	{
		if(!$this->_overfile && file_exists($file))
		{
			return $this->resMsg("文件已存在");
		}

		if(file_exists($file))
		{
			$bool = unlink($file);
			if(!$bool)
			{
				return $this->resMsg("文件已存在,删除失败");
			}
		}



		$bool = file_put_contents($file,$content);

		if($bool<=0)
		{
			return $this->resMsg($file."创建失败");
		}
		return $this->resMsg("ok");
	}
	private function resMsg( $msg )
	{
		return  $msg == "ok"?
				array(
					'code'=>1 , 
					'msg' => 'ok'
				):
				array(
					'code'=>-1 , 
					'msg'=>$msg
				);
	}

	//数据库链接
	private function connectdb()
	{

		include APPPATH."config/database.php";

		$config = $db[$this->_database];

		$mysqli = new mysqli($config['hostname'],$config['username'],$config['password'],$config['database']);

		//检查连接是否成功 
		if (mysqli_connect_errno()){ 
			return $this->resMsg("数据库链接失败");
		}
		$this->_databaseName = $config['database'];
		$this->_mysqli = $mysqli;
	}
}