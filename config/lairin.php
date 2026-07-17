<?php

return [

    'domain' => env('APP_DOMAIN', 'lairin.lv'),

    'show_blog' => false,

    'ga4_measurement_id' => env('GA4_MEASUREMENT_ID', ''),

    'site_description' => 'Lairin ir tehnoloģiju uzņēmums, kas projektē, ievieš un uztur mūsdienīgus IT risinājumus. Mēs nodrošinām IT infrastruktūru, serverus, datortīklus, kiberdrošību, mākslīgā intelekta risinājumus, biznesa procesu digitalizāciju, mājaslapu un sistēmu izstrādi, GIS, dronu tehnoloģijas un videonovērošanas sistēmas. Mūsu mērķis ir palīdzēt uzņēmumiem strādāt efektīvāk, drošāk un sasniegt ilgtspējīgu izaugsmi.',

    'default_og_image' => '/images/og-image.png',

    'company' => [
        'name' => 'Lairin',
        'legal_name' => 'SIA VENAB',
        'registration' => '40203639381',
        'vat' => '',
        'email' => 'info@lairin.lv',
        'phone' => '+371 26447608',
        'legal_address' => 'Jelgava, Loka maģistrāle 30, LV-3004',
        'bank_name' => '',
        'bank_account' => '',
        'bank_swift' => '',
    ],

    'seo' => [
        'default_keywords' => 'IT pakalpojumi Latvijā, IT ārpakalpojumi, kiberdrošība, AI risinājumi, digitalizācija, dronu pakalpojumi, GIS, ģis, videonovērošana, mājaslapu izstrāde, e-veikalu izstrāde, Microsoft 365, Azure, cloud, Lairin',
        'geo_region' => 'LV',
        'geo_placename' => 'Latvija',
        'language' => 'lv-LV',
    ],

];
