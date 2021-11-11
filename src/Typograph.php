<?php

namespace chulakov\phptypograph;

use Emuravjev\Mdash\Typograph as MdashTypograph;

class Typograph extends MdashTypograph
{
    /**
     * Инициализация правил типографа, которые прописаны в TypographBase
     */
    public function initOptions($additionalOptions)
    {
        $this->all_options = array_merge($this->all_options, $additionalOptions);
    }
}