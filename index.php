<?php

require_once ('src/navigation/view/HTMLView.php');
require_once ('src/list/controller/ListController.php');

$lc = new ListController();
$HTMLBody = $lc->showList();

$view = new HTMLView();
$view->echoHTML($HTMLBody);
