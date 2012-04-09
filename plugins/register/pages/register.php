<?php
$register_config = new register_config();

$Smarty->assign('register_config', $register_config);


$Smarty->display('register/index.tpl');
?>