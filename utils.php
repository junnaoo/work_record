<?php
function alphanum_check($data){
    //入力値チェック
    //半角英数字の場合aからz AからZ 0から9の場合にTrueを返す
    if(preg_match('/^[a-zA-Z0-9]+$/',$data)){
        return TRUE;
    }else{
        return FALSE;
    }
}







?>
