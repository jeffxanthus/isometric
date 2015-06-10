<?php
$includeFile = $file . '.php';
$parameter = '';
$otherKeys = array_keys($paraArray);
for ($i = 0; $i < count($otherKeys); $i++){
    $_GET[$otherKeys[$i]] = $paraArray[$otherKeys[$i]];
    $_POST[$otherKeys[$i]] = $paraArray[$otherKeys[$i]];
    $_REQUEST[$otherKeys[$i]] = $paraArray[$otherKeys[$i]];
}
$keyDisplay = '';
if ($button == '' && $onclick == ''){
    $keyDisplay = "display:none;";
}

if ($close == ''){
    $close = 'getBackHash();';
}else{
    
}

?>
<div class="modal fade" id="<?=$title?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?=$title?>ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="history.back(-1);"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?=$title?>ModalLabel"><?=__($title);?></h4>
            </div>
        <div class="modal-body" id="<?=$title?>ModalBody">
            <?php require_once($includeFile);?>
        </div>
        <div class="modal-footer">
            <button type="button" id="closebutton" class="btn btn-default" data-dismiss="modal" onclick="<?=$close?>"><?=__('close');?></button>
            
            <button type="button" id="submitbutton" class="btn btn-primary" onclick="<?=$onclick?>();" style="<?=$keyDisplay?>"><?=__($button)?></button>
            </div>
        </div>
    </div>
</div>