<?php

namespace Tests\Unit;

use Tests\TestCase;

class RuleTretTest extends TestCase
{
    /**
     * @var array
     */
    protected $tests = [
        //Союзы в тексте
        [
            'text' => 'Nexign занимается внедрением биллинговых систем для операторов связи и крупнейших брендов России и мира. После масштабного ребрендинга компании потребовался редизайн основного сайта и новый HR-портал',
            'result' => 'Nexign занимается внедрением биллинговых систем для операторов связи и&nbsp;крупнейших брендов России и&nbsp;мира. После масштабного ребрендинга компании потребовался редизайн основного сайта и&nbsp;новый HR-портал',
        ],
        //Неразрывный пробел после %
        [
            'text' => 'Кейс 100 % качества',
            'result' => 'Кейс 100&nbsp;% качества',
        ],
        //Кавычки, тире, многоточие
        [
            'text' => 'Чтобы сделать это, мы отправились в офис «Эс-Би-Ай Банка», где проработали четыре месяца с командой клиента — продукт-оунерами...',
            'result' => 'Чтобы сделать это, мы&nbsp;отправились в&nbsp;офис &laquo;Эс-Би-Ай Банка&raquo;, где проработали четыре месяца с&nbsp;командой клиента&nbsp;&mdash; продукт-оунерами&hellip;',
        ],
        //Номер телефона
        [
            'text' => '+7 863 303-61-91',
            'result' => '<nobr>+7 863 303-61-91</nobr>',
        ],
        //Союз/предлог, обернутый в тег
        [
            'text' => 'Мама, папа, брат <i>и</i> я',
            'result' => 'Мама, папа, брат <i>и</i>&nbsp;я',
        ],
        //Сокращение т. е.
        [
            'text' => 'Типограф т. е. typograph',
            'result' => 'Типограф <nobr>т. е.</nobr> typograph',
        ],
        //ФИО
        [
            'text' => 'Васечкин А. А. и Kim Jh. работают над проектом старт-ап',
            'result' => 'Васечкин&nbsp;А.&nbsp;А. и&nbsp;Kim&nbsp;Jh. работают над проектом старт-ап',
        ],
        //Двойные союзы
        [
            'text' => 'и с помощью',
            'result' => 'и&nbsp;с&nbsp;помощью',
        ],
        //Преобразование кавычек и символов
        [
            'text' => '- «Типограф»? !"№;%:?*()_+- Телеком2',
            'result' => '&mdash;&nbsp;&laquo;Типограф&raquo;? !"№;%:?*()_&plusmn; Телеком<sup><small>2</small></sup>'
        ],
        //Неразрывный пробел после чисел
        [
            'text' => '28 попугаев, 10 $',
            'result' => '28&nbsp;попугаев, 10&nbsp;$'
        ],
        //Регистр символов
        [
            'text' => 'С обычным и Необычным И Возможно С прочим',
            'result' => 'С&nbsp;обычным и&nbsp;Необычным И&nbsp;Возможно С&nbsp;прочим'
        ],
        //Взаимодействие с иностранным текстом
        [
            'text' => 'Oh, hi Mark! И UX‑аналитика',
            'result' => 'Oh, hi&nbsp;Mark! И&nbsp;UX‑аналитика'
        ],
        //Взаимодействие с форматированным текстом / WYSIWYG
        [
            'text' => '<p><strong>И жирный</strong>, и<em> курсив</em>, и <strong>комбо</strong></p>',
            'result' => '<p><strong>И&nbsp;жирный</strong>, и<em>&nbsp;курсив</em>, и&nbsp;<strong>комбо</strong></p>'
        ],
        //Случай с инициалами без точек
        [
            'text' => 'А О Васечкин',
            'result' => 'А&nbsp;О&nbsp;Васечкин',
        ],
        //Сокращение до н. э.
        [
            'text' => 'до н. э.',
            'result' => '<nobr>до н. э.</nobr>',
        ],
        //Случай с точкой. После нее не должен добавляться пробел
        [
            'text' => 'Next.js и ргшршг',
            'result' => 'Next.js и&nbsp;ргшршг',
        ],
    ];

    /**
     * Тестирует главные случаи в тексте, которые правит типограф
     *
     * @return void
     */
    public function testMainCasesTypographUnits()
    {
        $this->runTypographTests($this->tests);
    }
}
