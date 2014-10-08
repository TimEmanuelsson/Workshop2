<?php

Class BoatView {

	private $boatRepository;

	public function __construct(BoatRepository $boatRepository) {
		$this->boatRepository = $boatRepository;
	}

	public function getBoatID() {
		return $_GET['boat'];
	}

	public function showBoat($boat) {
		var_dump($boat);
	}
}