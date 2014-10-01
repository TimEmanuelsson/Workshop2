<?php

require_once ('view/HTMLView.php');
require_once ('controller/ListController.php');

$lc = new ListController();
$HTMLBody = $lc->showList();

$view = new HTMLView();
$view->echoHTML($HTMLBody);
