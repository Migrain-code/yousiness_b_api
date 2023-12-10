<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path){
    return env('IMAGE_URL')."/".$path;
}
function setting($key){
    return config('settings.'.$key);
}
function clearPhone($phoneNumber){
    // Özel karakterleri temizle
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Başındaki + işaretini ve ülke kodunu kontrol et
    if (substr($phoneNumber, 0, 1) == '+') {
        $phoneNumber = substr($phoneNumber, 1); // Başındaki + işaretini kaldır
    } elseif (substr($phoneNumber, 0, 2) == '00') {
        $phoneNumber = substr($phoneNumber, 2); // Başındaki 00'yi kaldır
    }
    $phoneNumber = str_replace(' ', '', $phoneNumber);
    // Başındaki sıfırları kaldır
    $phoneNumber = ltrim($phoneNumber, '0');

    return $phoneNumber;
}
function calculateTotal($services)
{
    $total=0;
    foreach ($services as $service){
        if ($service->service){
            $total+=$service->service->price;
        }
    }
    return $total;
}


