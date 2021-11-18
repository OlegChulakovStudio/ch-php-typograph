<?php
return [
    [
        'selector' => 'Etc.time_interval',
        'keysOfRule' => [
            'pattern',
            'replacement',
        ],
        'valuesOfKeyRule' => [
            '/([\d]{1,2}\:[\d]{2})(-|\&mdash\;|\&minus\;)([\d]{1,2}\:[\d]{2})/eui',
            '$this->tag($m[1] . "&ndash;" . $m[3], "span", array("class" => "nowrap"))',
        ],
    ],
    [
        'selector' => 'Symbol.copy_replace',
        'keysOfRule' => [
            'pattern',
            'replacement',
        ],
        'valuesOfKeyRule' => [
            '/\((?:c|с)\)/',
            '&copy;',
        ],
    ],
    [
        'selector' => 'Nobr.spaces_nobr_in_surname_abbr',
        'keysOfRule' => [
            'pattern',
            'replacement',
        ],
        'valuesOfKeyRule' => [
            [
                '/([А-ЯЁ][а-яё]+|[A-Z][a-z]+)((\s|\&nbsp\;)([А-ЯЁ]|[A-Z][a-z]?)\.)?(\s|\&nbsp\;)([А-ЯЁ]|[A-Z][a-z]?)\.(\W|\$)/ue',
                '/([А-ЯЁ][а-яё]+|[A-Z][a-z]+)((\s|\&nbsp\;)([А-ЯЁ]|[A-Z][a-z]?))?(\s|\&nbsp\;)([А-ЯЁ]|[A-Z][a-z]?)(\W|\$)/ue',
                '/(([А-ЯЁ]|[A-Z][a-z]?)\.(\s|\&nbsp\;))?([А-ЯЁ]|[A-Z][a-z]?)\.(\s|\&nbsp\;)([А-ЯЁ][а-яё]+|[A-Z][a-z]+)/ue',
                '/(([А-ЯЁ]|[A-Z][a-z]?)(\s|\&nbsp\;))?([А-ЯЁ]|[A-Z][a-z]?)(\s|\&nbsp\;)([А-ЯЁ][а-яё]+|[A-Z][a-z]+)/ue',
            ],
            [
                '$m[1] . ($m[4] != "" ? "&nbsp;" . trim($m[4]) : "") . "&nbsp;" . $m[6] . "." . $m[7]',
                '$m[1] . ($m[4] != "" ? "&nbsp;" . trim($m[4]) : "") . "&nbsp;" . $m[6] . $m[7]',
                '($m[1] != "" ? trim($m[1]) . "&nbsp;" : "") . $m[4] . ".&nbsp;" . $m[6]',
                '($m[1] != "" ? trim($m[1]) . "&nbsp;" : "") . $m[4] . "&nbsp;" . $m[6]',
            ],
        ],
    ],
    [
        'selector' => 'Nobr.nbsp_in_the_end',
        'keysOfRule' => [
            'pattern',
            'replacement',
        ],
        'valuesOfKeyRule' => [
            '/([a-zа-яё0-9\-]{2,}) ([a-zа-яё]{1,2})(\.|$)/',
            '\1&nbsp;\2\3',
        ],
    ],
    [
        'selector' => 'Nobr.super_nbsp',
        'keysOfRule' => [
            'pattern',
            'replacement',
        ],
        'valuesOfKeyRule' => [
            [
                '/(\s|\&nbsp\;|\>)([a-zа-яё]{1,2})(\s|\&nbsp\;)([a-zа-яё]{1,2})((\s+)|\&nbsp\;)/eu',
                '/(\s|\&(la|bd)quo\;|\>|\(|\&mdash\;|\&nbsp\;)([a-zа-яё]{1,2}\s+)([A-zА-яё0-9\-]|\<|\>|\&laquo\;)/eu',
                '/(^|\>)([A-zА-яё][a-zа-яё]?\s+)([a-zа-яё0-9\-]+|[0-9]|\<|\>|\&laquo\;)/eu',
            ],
            [
                '$m[1] . $m[2] . "&nbsp;" . $m[4] . "&nbsp;"',
                '$m[1] . trim($m[3]) . "&nbsp;" . $m[4]',
                '$m[1] . trim($m[2]) . "&nbsp;" . $m[3]',
            ],
        ],
    ],
];