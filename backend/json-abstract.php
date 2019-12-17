<?php


namespace app\services\json\abstracts;


abstract class json_abstract {

	protected function new_key() {
		$old_key = $this->app->request()->post("api_key");
		$new_key = $this->api_model->process_new_key( $old_key );

		if(!$new_key) {
			$this->keyError();
		}

		return $new_key->getApiKey();
	}

	// build the array to encode, return array
	abstract protected function build():array;

	public function send(array $array) {
		echo json_encode($array);
		exit(0);
	}

	public function keyError() {
		$this->send([
			'status' => "API Key failure"
		]);
	}

}