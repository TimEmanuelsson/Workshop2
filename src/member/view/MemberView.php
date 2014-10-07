<?php

Class MemberView {

	private $memberRepository;
	private $boatRepository;

	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository)
	{
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}
	
	public function getMemberID()
	{
		return $_GET['member'];
	}
	
	public function showMember($member)
	{
		var_dump($member);
		
		// TODO: Plocka ut data ur $member och lägg in i html som skall returneras till kontrollern.
	}
}