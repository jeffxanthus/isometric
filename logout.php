<?php
session_start();
require_once('func.php');
session_destroy();
echo "<script>$('#naviNum').val('0');makeMenu('left');makeMenu('right');$('#loginModal').modal('hide');document.getElementById('lastHash').value == ''?setHash('index'):history.back(-1);alert('" . __('youhadloggedoutsuccessfully') . "')</script>";
die();
?>
