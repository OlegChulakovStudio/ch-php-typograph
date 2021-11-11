<?php

namespace chulakov\phptypograph;

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