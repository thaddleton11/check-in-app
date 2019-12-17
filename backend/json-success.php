<?php


namespace app\services\json;

use app\models\api;
use app\services\json\abstracts\json_abstract;
use Slim\Slim;

class json_success extends json_abstract {

	private $status;
	private $old_key;
	private $data;

	protected $api_model;
	protected $app;

	public function __construct( $data = false, $status = "success" ) {
		$this->api_model = new api();
		$this->app = Slim::getInstance();

		$this->status = $status;
		$this->data = $data;

		$this->send(
			$this->build()
		);
	}


	protected function build():array {
		$array = [
			"status" => $this->status,
			"new_key" => $this->new_key()
		];

		if( is_array($this->data) ) {
			$array = array_merge($array, $this->data);
		}

		return $array;
	}

}<?php
