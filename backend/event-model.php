<?php

namespace src;

use app\models;

/**
 * @Entity @Table(name="events")
 **/
class events extends model {

	/** @Id @Column(type="integer") @GeneratedValue  * */
	private $id;

	/** @Column(type="string") * */
	private $uid;

	/** @Column(type="string", name="identifier") * */
	private $identifier;

	/** @Column(type="datetime") * */
	private $created;

	/** @Column(type="datetime") * */
	private $updated;

	/**
	 * @Column(type="integer", name="created_by")
	 * ManyToOne(targetEntity="users", inversedBy="event")
	 * JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
	 */
	private $created_by;

	/**
	 * @ManyToOne(targetEntity="users")
	 * @JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
	 * @var users
	 */
	private $user;


	/**
	 * @OneToMany(targetEntity="delegates", mappedBy="event", fetch="EXTRA_LAZY")
	 */
	private $delegates;

	/**
	 * @OneToOne(targetEntity="events_settings", mappedBy="event")
	 * JoinColumn(name="id", referencedColumnName="event_id")
	 */
	private $event_settings;

	/**
	 * @OneToOne(targetEntity="events_login", mappedBy="event")
	 */
	private $event_credentials;

	/**
	 * @OneToOne(targetEntity="events_availability", mappedBy="event")
	 */
	private $event_availability;

	/**
	 * @OneToMany(targetEntity="clients_manageables", mappedBy="event", fetch="EAGER")
	 */
	private $clients_manageables;


	/** @Column(type="integer") * */
	private $record_status;



	public function getId() {

		return $this->id;
	}



	public function getUid() {

		return $this->uid;
	}



	public function setUid() {

		$this->uid = $this->get_uid_hash( "events" );
	}



	public function getIdentifier() {

		return $this->identifier;
	}



	public function setIdentifier( $identifier ) {

		$this->identifier = $identifier;
	}



	public function getCreatedBy() {

		return $this->created_by;
	}



	public function setCreatedBy( users $created_by ) {

		$this->user       = $created_by;
		$this->created_by = $created_by;

	}



	public function getStatus() {

		return $this->record_status;
	}



	public function setStatus( $status ) {

		$this->record_status = $status;
	}



	public function getCreated() {

		return $this->created;
	}



	public function setCreated( $created ) {

		$this->created = $created;
	}



	public function getUpdated() {

		return $this->updated;
	}



	public function setUpdated( $updated ) {

		$this->updated = $updated;
	}


}