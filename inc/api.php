<?php
function classify_record($record_path){
    $url = 'http://127.0.0.1:9000/predict';
    $data = array('path' => $record_path);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    return $result;
}
?>