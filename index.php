<?php

require_once('model/MemberRepository.php');
require_once ('model/BoatRepository.php');

$memberRepo = new MemberRepository();

$members = $memberRepo->getAllMembersAndBoats();



foreach ($members as $member) {
	var_dump($member);
}
