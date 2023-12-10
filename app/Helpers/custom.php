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
    $countryCodes = [
        '+1',
        '+20',
        '+211',
        '+212',
        '+212',
        '+213',
        '+216',
        '+218',
        '+220',
        '+221',
        '+222',
        '+223',
        '+224',
        '+225',
        '+226',
        '+227',
        '+228',
        '+229',
        '+230',
        '+231',
        '+232',
        '+233',
        '+234',
        '+235',
        '+236',
        '+237',
        '+238',
        '+239',
        '+240',
        '+241',
        '+242',
        '+243',
        '+244',
        '+245',
        '+246',
        '+248',
        '+249',
        '+250',
        '+251',
        '+252',
        '+253',
        '+254',
        '+255',
        '+256',
        '+257',
        '+258',
        '+260',
        '+261',
        '+262',
        '+262',
        '+263',
        '+264',
        '+265',
        '+266',
        '+267',
        '+268',
        '+269',
        '+27',
        '+290',
        '+291',
        '+297',
        '+298',
        '+299',
        '+30',
        '+31',
        '+32',
        '+33',
        '+34',
        '+350',
        '+351',
        '+352',
        '+353',
        '+354',
        '+355',
        '+356',
        '+357',
        '+358',
        '+358',
        '+359',
        '+36',
        '+370',
        '+371',
        '+372',
        '+373',
        '+374',
        '+375',
        '+376',
        '+377',
        '+378',
        '+380',
        '+381',
        '+382',
        '+383',
        '+385',
        '+386',
        '+387',
        '+389',
        '+39',
        '+39',
        '+40',
        '+41',
        '+420',
        '+421',
        '+423',
        '+43',
        '+44',
        '+44',
        '+44',
        '+44',
        '+44',
        '+45',
        '+46',
        '+47',
        '+47',
        '+48',
        '+49',
        '+500',
        '+501',
        '+502',
        '+503',
        '+504',
        '+505',
        '+506',
        '+507',
        '+508',
        '+509',
        '+51',
        '+52',
        '+53',
        '+54',
        '+55',
        '+56',
        '+57',
        '+58',
        '+590',
        '+590',
        '+590',
        '+591',
        '+592',
        '+593',
        '+594',
        '+595',
        '+596',
        '+597',
        '+598',
        '+599',
        '+599',
        '+60',
        '+61',
        '+61',
        '+61',
        '+62',
        '+63',
        '+64',
        '+65',
        '+66',
        '+670',
        '+672',
        '+673',
        '+674',
        '+675',
        '+676',
        '+677',
        '+678',
        '+679',
        '+680',
        '+681',
        '+682',
        '+683',
        '+685',
        '+686',
        '+687',
        '+688',
        '+689',
        '+690',
        '+691',
        '+692',
        '+7',
        '+7',
        '+81',
        '+82',
        '+84',
        '+850',
        '+852',
        '+853',
        '+855',
        '+856',
        '+86',
        '+880',
        '+886',
        '+90',
        '+91',
        '+92',
        '+93',
        '+94',
        '+95',
        '+960',
        '+961',
        '+962',
        '+963',
        '+964',
        '+965',
        '+966',
        '+967',
        '+968',
        '+970',
        '+971',
        '+972',
        '+973',
        '+974',
        '+975',
        '+976',
        '+977',
        '+98',
        '+992',
        '+993',
        '+994',
        '+995',
        '+996',
        '+998',
    ];
    $inFormatPhone= substr($phoneNumber,0,3);
    if (in_array($inFormatPhone , $countryCodes)){
        $phoneNumber = str_replace($countryCodes, '', $phoneNumber);
        return $phoneNumber;
    }
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


