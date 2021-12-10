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
     * Массив успешных тестов вида ['text' => 'Text to test', 'result' => 'Expected result']
     *
     * @var array
     */
    protected $testsSuccessful = [];

    /**
     * Массив проавльных тестов вида ['text' => 'Text to test', 'result' => 'Expected result']
     *
     * @var array
     */
    protected $testsFailed = [];

    /**
     * @var TypographFacade
     */
    protected $typograph;

    /**
     * @inheritDoc
     *
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
    protected function runSuccessfulTypographTests($testsSuccessful = [])
    {
        $this->runTypographTests($testsSuccessful, 'assertEquals');
    }

    /**
     * Запускает тесты
     * Проверяет на существования отличий между тестовыми данными и ожидаемым результатом
     *
     * @return void
     */
    protected function runFailedTypographTests($testsFailed = [])
    {
        $this->runTypographTests($testsFailed, 'assertNotEquals');
    }

    /**
     * Запуск тестов с передаваемым параметром сравнения тестовых данных и ожидаемым результатом
     *
     * @param array $tests
     * @param string $action
     */
    protected function runTypographTests($tests, $action)
    {
        foreach ($tests as $test) {
            $processedText = $this->typograph->process($test['text']);
            $this->{$action}($test['result'], $processedText);
        }
    }

    /**
     * Запуск всех тестов
     *
     * @param array $testsSuccessful
     * @param array $testsFailed
     */
    protected function runAllTests($testsSuccessful = [], $testsFailed = [])
    {
        $this->runSuccessfulTypographTests($testsSuccessful);
        $this->runFailedTypographTests($testsFailed);
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
