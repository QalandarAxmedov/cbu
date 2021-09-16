<?php

header("Content-type:application/json");
$filename = "cbu.uz.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";
$flags = json_decode($contents, true);
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$res = json_decode($res, true);
$js = [];
foreach ($res as $item) {
    $jst = [
        'nominal' => $item['Nominal'],
        'name' => $item['Ccy'],
        'name_uz' => $item['CcyNm_UZ'],
        'name_kr' => $item['CcyNm_UZC'],
        'name_ru' => $item['CcyNm_RU'],
        'name_en' => $item['CcyNm_EN'],
        'value' => $item['Rate'],
        'diff' => $item['Diff'],
    ];
    if (array_key_exists($item['Ccy'], $flags)) {
        $jst['flag'] = $flags[$item['Ccy']];
    }
    $js[] = $jst;
}
echo html_entity_decode(json_encode($js, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT));
