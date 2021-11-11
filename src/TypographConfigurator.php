<?php

namespace chulakov\phptypograph;

class TypographConfigurator
{
    /**
     * @var string
     */
    public $additionalRulesPath = __DIR__ . '/config/additionalRules.php';

    /**
     * @var string
     */
    public $changedRulesPath = __DIR__ . '/config/changedRules.php';

    /**
     * @var array[] Массив с новыми правилами. Необязательный параметр.
     * В случае пустого массива типограф проинициализируется с правилами класса Typograph.
     */
    public $additionalRules;

    /**
     * @var array[] Массив с изменениями правил, которые уже существуют в третах. Необязательный параметр.
     * В случае пустого массива типограф проинициализируется с правилами класса Typograph.
     */
    public $changedRules;

    /**
     * @var array Массив с настройками правил третов. Можно отключать или подключать правила, существующие в Typograph
     */
    public $customizeOptions = [
        'Text.breakline' => false,
        'Text.paragraphs' => false,
        'Text.auto_links' => false,
        'Text.email' => false,
        'Text.no_repeat_words' => false,

        'OptAlign.oa_obracket_coma' => false,
        'OptAlign.oa_oquote' => false,
        'OptAlign.oa_oquote_extra' => false,

        'Abbr.ps_pps' => false,
        'Abbr.nobr_vtch_itd_itp' => false,
        'Abbr.nobr_gost' => false,

        'Date.nbsp_and_dash_month_interval' => false,
        'Date.nobr_year_in_date' => false,

        'Etc.split_number_to_triads' => false,

        'Nobr.dots_for_surname_abbr' => false,

        'Punctmark.auto_comma' => false,
        'Punctmark.punctuation_marks_limit' => false,

        'Space.clear_before_after_punct' => false,
        'Space.clear_percent' => false,
        'Space.nobr_twosym_abbr' => false,

        'Symbol.euro_symbol' => true,
        'Symbol.copy_replace' => true,
    ];

    /**
     * @var array Массив добавочных правил третов
     * Правила, которые присутствуют в классе TypographBase, но отключены в наследнике Typograph
     */
    public $additionalOptions = [
        'Punctmark.punctuation_marks_limit' => 'direct',
        'Symbol.euro_symbol' => 'direct',
        'Space.nobr_twosym_abbr' => 'direct'
    ];

    /**
     * Типограф
     *
     * @var Typograph
     */
    private $typograph;

    /**
     * Конструктор конфигуратора типографа
     * Создание объекта типографа без пользовательских настроек
     * Объявление правил типографа, которые будут настроены у него конфигуратором
     *
     * @param array $additionalRules
     * @param array $changedRules
     */
    public function __construct(array $additionalRules = [], array $changedRules = [])
    {
        if (empty($additionalRules)) {
            $additionalRules = $this->loadConfigRules($this->additionalRulesPath);
        }
        if (empty($changedRules)) {
            $changedRules = $this->loadConfigRules($this->changedRulesPath);
        }

        $this->additionalRules = $additionalRules;
        $this->changedRules = $changedRules;
        $this->typograph = new Typograph();
    }

    /**
     * @return Typograph
     */
    public function getConfiguredTypograph()
    {
        return $this->typograph;
    }

    /**
     * Конфигурирование (настройка) типографа
     * Инициализация правил типографа
     * Установка типографу пользовательских настроек правил
     * Добавление новых правил
     * Изменение существующих правил
     */
    public function configureTypograph()
    {
        $this->typograph->initOptions($this->additionalOptions);
        $this->customizeOptions();
        $this->addNewRules();
        $this->changeOldRules();
    }

    /**
     * Установка типографу пользовательских настроек правил, проинициализированных в initOptions()
     */
    protected function customizeOptions()
    {
        $this->typograph->setup($this->customizeOptions);
    }

    /**
     * Изменение регулярок правил
     */
    protected function changeOldRules()
    {
        foreach ($this->changedRules as $change) {
            $this->typograph->set($change['selector'], $change['keysOfRule'], $change['valuesOfKeyRule']);
        }
    }

    /**
     * Проверка на существование трета
     *
     * @param string $selector
     * @return bool
     */
    protected function isExistTret($selector)
    {
        foreach ($this->typograph->trets as $tret) {
            if (!strcasecmp($selector, $tret)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Добавление одного правила к существующему трету
     *
     * @param array $rule
     */
    protected function addRuleToTret(array $rule)
    {
        $isExistTret = $this->isExistTret($rule['selector']);
        if ($isExistTret) {
            $tretObj = $this->typograph->get_tret($rule['selector']);
            $tretObj->put_rule($rule['ruleName'], $rule['params']);
        }
    }

    /**
     * Добавление новых правил
     * Можно добавлять правила сразу для разных третов
     */
    protected function addNewRules()
    {
        foreach ($this->additionalRules as $rule) {
            $this->addRuleToTret($rule);
        }
    }

    /**
     * Загрузка файла конфигурации с правилами
     *
     * @param string $configPath
     * @return array
     */
    protected function loadConfigRules($configPath)
    {
        if (is_file($configPath)) {
            $data = include $configPath;
            if (!empty($data) && is_array($data)) {
                return $data;
            }
        }
        return [];
    }
}