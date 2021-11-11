<?php

namespace chulakov\phptypograph;

class TypographFacade implements TypografInterface
{
    /**
     * @var Typograph
     */
    private $typograph;

    /**
    * Конструктор пользовательского типографа
    *
    * @param array $additionalRules
    * @param array $changedRules
    */
    public function __construct(array $additionalRules = [], array $changedRules = [])
    {
        $configurator = new TypographConfigurator($additionalRules, $changedRules);
        $configurator->configureTypograph();
        $this->typograph = $configurator->getConfiguredTypograph();
    }

    /**
     * Типографирование текста
     *
     * @param string $text
     * @return string
     */
    public function process($text)
    {
        $this->typograph->set_text($text);
        return $this->typograph->apply();
    }
}