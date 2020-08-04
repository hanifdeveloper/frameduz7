<?php

namespace app\service\controller;

use app\defaults\controller\application;

class v1 extends application{ 
	
	public function __construct(){
		parent::__construct();
		$this->data['url_path'] = $this->link($this->getProject().$this->getController());
	}

	protected function index(){
		$this->showResponse($this->errorMsg, 404);
	}

	protected function script(){
		header('Content-Type: application/javascript');
		$this->subView('script', $this->data);
	}

	protected function crud($method){
		$crud = 'app\crud\controller\custom';
		if((int)method_exists($crud, $method) > 0){
			if($this->checkAccessMethod($crud, $method, self::IS_PUBLIC)){
				$crud = new $crud();
				return $crud->{$method}();
			}else{
				$this->errorMsg['message']['text'] = 'Method Not Public';
				$this->showResponse($this->errorMsg, $this->errorCode);
			}
		}
		else{
			$this->showResponse($this->errorMsg, $this->errorCode);
		}
	}
}
?>
