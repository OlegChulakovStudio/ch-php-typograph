<?php

namespace Tests;

use Chulakov\PhpTypograph\TypographFacade;
use PHPUnit_Framework_TestCase;

/**
 * Base class for all tests.
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Массив тестов вида ['text' => 'Text to test', 'result' => 'Expected result']
     *
     * @var array
     */
    protected $tests = [];

    /**
     * @var TypographFacade
     */
    protected $typograph;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->typograph = new TypographFacade();
    }

    /**
     * Запускает тесты
     * Проверяет на совпадение тестовых данных с ожидаемым результатом
     *
     * @return void
     */
    protected function runTypographTests($tests = [])
    {
        $tests = empty($tests) ? $this->tests : $tests;
        foreach ($tests as $test) {
            $processedText = $this->process($test['text']);
            $this->assertEquals($test['result'], $processedText);
        }
    }

    /**
     * Функция типографирования. Можно указать, сколько раз типографировать один и тот же текст
     *
     * @param $text
     * @param int $times
     * @return string
     */
    public function process($text, $times = 1)
    {
        $processedText = $text;
        for ($i = $times; $i != 0; $i--) {
            $processedText = $this->typograph->process($processedText);
        }
        return $processedText;
    }
}
