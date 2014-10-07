<?php

Class MemberView {

	private $memberRepository;
	private $boatRepository;

	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository) {
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}
}