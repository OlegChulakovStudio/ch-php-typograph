<?php

namespace tests\unit;

use chulakov\phptypograph\TypographFacade;
use tests\TestCase;

class TypographConfiguratorTest extends TestCase
{
    /**
     * @var array
     */
    protected $testsSuccessful = [
        [
            'text' => 'Nexign занимается внедрением биллинговых систем для операторов связи и крупнейших брендов России и мира. После масштабного ребрендинга компании потребовался редизайн основного сайта и новый HR-портал',
            'result' => 'Nexign занимается внедрением биллинговых систем для операторов связи и&nbsp;крупнейших брендов России и&nbsp;мира. После масштабного ребрендинга компании потребовался редизайн основного сайта и&nbsp;новый HR-портал',
        ],
        [
            'text' => 'Чтобы сделать это, мы отправились в офис «Эс-Би-Ай Банка», где проработали четыре месяца с командой клиента — продукт-оунерами...',
            'result' => 'Чтобы сделать это, мы&nbsp;отправились в&nbsp;офис &laquo;Эс-Би-Ай Банка&raquo;, где проработали четыре месяца с&nbsp;командой клиента&nbsp;&mdash; продукт-оунерами&hellip;',
        ],
        [
            'text' => '+7 863 303-61-91',
            'result' => '<nobr>+7 863 303-61-91</nobr>',
        ],
        [
            'text' => 'Типограф т. е. typograph',
            'result' => 'Типограф <nobr>т. е.</nobr> typograph',
        ],
        [
            'text' => 'Васечкин А. А. и Kim Jh. работают над проектом старт-ап',
            'result' => 'Васечкин&nbsp;А&nbsp;А. и&nbsp;Kim&nbsp;Jh. работают над проектом старт-ап',
        ],
    ];

    protected $testsFailed = [
        [
            'text' => 'Мама, папа, брат <i>и</i> я',
            'result' => 'Мама, папа, брат <i>и</i>&nbsp;я',
        ],
        [
            'text' => 'Кейс 100 % качества',
            'result' => 'Кейс 100&nbsp;% качества',
        ],
    ];

    protected $additionalRules = [
        [
            'selector' => 'Abbr',
            'ruleName' => 'nobr_vtch_BC',
            'params' => [
                'pattern' => '/(^|\s|\&nbsp\;|)([дД]о)?[ ](н)\.?[ ]?э\./ue',
                'replacement' => '$m[1] . $this->tag($m[2] . " н."." э.", "span", array("class" => "nowrap"))',
            ],
        ],
    ];

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->typograph = new TypographFacade($this->additionalRules);
    }

    /**
     * Тестирует конфигуратор типографа
     *
     *
     * @return void
     */
    public function testTypographConfiguratorUnits()
    {
        $this->runTypographTests($this->testsSuccessful);
    }

    protected function runTypographTests($tests = [])
    {
        parent::runTypographTests($tests);
        foreach ($this->testsFailed as $test) {
            $processedText = $this->typograph->process($test['text']);
            $this->assertNotEquals($test['result'], $processedText);
        }
    }
}