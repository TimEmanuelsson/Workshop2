<?php

require_once ('./src/member/view/MemberView.php');
require_once('./src/boat/model/BoatRepository.php');
require_once('./src/list/view/ListView.php');

Class MemberController {

	private $memberView;
	private $memberRepository;
	private $boatRepository;

	public function __construct() {
		$this->memberRepository = new MemberRepository();
		$this->boatRepository = new BoatRepository();
		$this->memberView = new MemberView($this->memberRepository, $this->boatRepository);
	}


}