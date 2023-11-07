<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path){
    return env('APP_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}
function clearPhone($phoneNumber){
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);

    return $newPhoneNumber;
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


