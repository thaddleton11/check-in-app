<?php


namespace app\repositories;


use app\models\api;
use app\models\main;

class delegates_repository {

	public $delegates;
	public $model;
	public $api_model;

	public function __construct() {
		$this->model = new main();
		$this->api_model = new api();
	}


	public function all (): array {
		$this->delegates = $this->model->get_delegates();
		return $this->delegates;
	}


	public function all_by_event_id ($event_id): array {
		$this->delegates = $this->model->get_delegates_by_event_id($event_id);
		$this->process();
		return $this->delegates;
	}

	// get delegates updated since last key issued date
	public function updated_only ( $key ): array {
		$key_data = $this->api_model->get_api_key($key);

		if( !$key_data ) return [];

		$this->delegates = $this->model->get_delegates_by_event_id_after_date($key_data->getEventId(), $key_data->getCreated());
		$this->process();

		return $this->delegates;

	}


	public function count(): int {
		return count($this->delegates);
	}


	public function count_checked_in(): int{
		$counter = 0;

		foreach( $this->delegates as $delegate ) {
			if($delegate['checked_in'] != "No") $counter++;
		}

		return $counter;
	}

	// format some features for api
	public function process () {
		foreach( $this->delegates as &$delegate ) {
			// checkin time/date
			$delegate[ 'checked_in' ] = $this->format_checkedin( $delegate[ 'checked_in' ] );
			// uid
			$delegate[ 'id' ] = $delegate[ 'delegate_uid' ];
			unset($delegate['delegate_uid']);
		}


		// make id the key
		$array_keys = array_column($this->delegates, 'id');
		$this->delegates = array_combine($array_keys, $this->delegates);
	}


	public function format_checkedin( $date ): string {

		$checked_in_formatted = "No";


		if( $date ) {
			$formatted            = $date->format( "H:i:s j-M" );
			$checked_in_formatted = $formatted;
		}

		return $checked_in_formatted;
	}

}