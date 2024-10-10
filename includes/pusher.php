<?php

$options = array(
    'cluster' => 'ap1',
    'useTLS' => false
);
$pusher = new Pusher\Pusher(
    '6bde96fb5927bfee7cdc', 
    'e35473811246267f99fc', 
    '1805714',              
    $options
);

?>
