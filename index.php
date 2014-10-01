<?php

require_once('model/MemberRepository.php');
require_once ('model/BoatRepository.php');
require_once ('view/HTMLView.php');

$lc = new ListController();
$HTMLBody = $lc->showList();

$view = new HTMLView();
$view->echoHTML($HTMLBody);
