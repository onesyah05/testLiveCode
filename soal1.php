<?php
function generateToken($user) {
    // untuk menyimpan array
    $array = 'dataSoal1.json';
    //random string sebagai token
    $char = "-_1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $token = '';
    for ($i=0; $i < 36; $i++) { 
        $token .= $char[rand(0,strlen($char)-1)];
    }

    $data = file_get_contents($array);
    $data = json_decode($data,true);
    
    //cek data kosong
    if (count($data) == 0) {
        $data[$user] = array($token);
        $data = json_encode($data, JSON_PRETTY_PRINT);
        $save = file_put_contents($array,$data);
    }
    
    if (isset($data[$user])) {
        if (count($data[$user]) == 10) {
           $key = array_shift($data[$user]);
        }
        $data[$user][] = $token;
        $data = json_encode($data, JSON_PRETTY_PRINT);
        $save = file_put_contents($array,$data);
    }else{
        $data[$user] = array($token);
        $data = json_encode($data, JSON_PRETTY_PRINT);
        $save = file_put_contents($array,$data);
    }

    return $token;
}


function verifyToken($user, $token) {
    $array = 'dataSoal1.json'; 

    $data = json_decode(file_get_contents($array), true);

    if (isset($data[$user])) {
        $tokenList = $data[$user];

        if (($key = array_search($token, $tokenList)) !== false) {
            unset($tokenList[$key]); 

       
            $data[$user] = array_values($tokenList);
            file_put_contents($array, json_encode($data, JSON_PRETTY_PRINT));

            return 'true';
        } else {
            return 'false';
        }
    } else {
        return false; 
    }
}
// echo generateToken('joko');

echo verifyToken('joko','gToDj-u-cfAqONeMtzKU9xlRGpnvi81beEuw');