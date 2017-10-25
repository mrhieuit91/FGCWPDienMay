<?php
session_start();
    if(isset($_POST['id']) AND $_POST['id']!=''){
        $id = $_POST['id'];
        $manu = $_POST['manu'];
        $type = $_POST['type'];
        $color = $_POST['color'];
        $num = $_POST['num'];
        $_SESSION['s_pro'][] = array('id'=>$id,
                                         'manu'=>$manu,
                                         'type'=>$type,
                                         'color'=>$color,
                                         'num'=>$num);        
        echo 'GREAT';
    }
?>