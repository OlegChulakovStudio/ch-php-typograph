<?php

namespace Chulakov\PhpTypograph;

interface TypografInterface
{
    /**
     * Типографирование текста
     *
     * @param string $text
     * @return string
     */
    public function process($text);
}