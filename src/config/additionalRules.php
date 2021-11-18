<?php
return [
    // Обработка до н. э.
    [
        'selector' => 'Abbr',
        'ruleName' => 'nobr_vtch_BC',
        'params' => [
            'pattern' => '/(^|\s|\&nbsp\;)(\<.+?\>)?([дД]о)?[ ](н)\.?[ ]?э\.(\<.+?\>)?/ue',
            'replacement' => '$m[1] . $this->tag($m[3] . " н."." э.", "span", array("class" => "nowrap"))',
        ],
    ],
    // Добавление пробела перед символом процента
    [
        'selector' => 'Space',
        'ruleName' => 'space_before_percent',
        'params' => [
            'pattern' => '/(\d+)([\t\040]+)\%/',
            'replacement' => '\1&nbsp;%'
        ],
    ],
    // Пробел после числа
    [
        'selector' => 'Nobr',
        'ruleName' => 'space_after_number',
        'params' => [
            'pattern' => '/(\d+)(\s)([a-zа-яё]+)/',
            'replacement' => '\1&nbsp;\3'
        ],
    ],
// пробел после предлога \ союза, обернутого в тег(-и)
    [
        'selector' => 'Nobr',
        'ruleName' => 'space_after_short_word_in_tag',
        'params' => [
            'pattern' => '/(\s+|\&nbsp\;|\>)([a-zа-яё]{1,2})((\<\/[a-zа-яё0-9\=]+\>)+)(\s+|\&nbsp\;)([a-zа-яё0-9\-]|\<|\>|\&laquo\;)/ieu',
            'replacement' => '$m[1] . $m[2] . $m[3] . "&nbsp;" . $m[6]',
        ]
    ]
];