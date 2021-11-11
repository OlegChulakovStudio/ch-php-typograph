Компонент типографа на ЯП PHP с встроенным конфигуратором.<br><br>
Конфигуратор типографа настраивает правила типографа Муравьева.<br><br>
Добавление или удаление третов в конфигураторе не реализовано. Если какой-либо трет нужно полностью исключть из типографирования, то можно отключить все его правила.<br><br>

<ul>
    <li>
        Трет - это блок или модуль правил. Например: трет Symbol содержит правила обнаружения и обработки различных символов.
    </li>
    <li>
        Правило - это массив, состоящий из регулярок(-ки) обнаружения случая в тексте и регулярок(-ки), на которые соответственно необходимо заменить найденный случай в тексте. <br>Также имеется (неоябзательная) ячейка в массиве с описанием сути правила.
    </li>
    <li>  
        Typograph composer-пакета oleg-chulakov-studio/mdash - это наследник TypographBase. В нем объявлены не все правила третов, которые доступны в классе TypographBase. В результате не все правила класса TypographBase<br>можно подключить / отключить. Потому некоторые правила третов класса TypographBase прописаны в переменной $additionalOptions класса TypographConfigurator<br>для их последующей настройки.
    </li>
    <li>
        Класс Typograph с пространством имен chulakov\phptypograph наследуется от класса Typograph из composer-пакета oleg-chulakov-studio/mdash, т. к. необходимо было добавить<br>правила типографу, которые были доступны в классе TypographBase, но перестали быть доступны в<br>классе Typograph из composer-пакета oleg-chulakov-studio/mdash.
    </li>
</ul>

### Работа конфигуратора

1. Объявление конфигуратора типографа. Настройка типографа с правилами, прописанными в конфигах и внутри самого конфигуратора по умолчанию.

```php
$configurator = new TypographConfigurator();
$configurator->configureTypograph();
```

2. Настройка типографа с правилами переданными через конструктор конфигуратора.

```php
$configurator = new TypographConfigurator($additionalRules, $changedRules);
```

3. Пример объявления новых правил 

```php
$additionalRules = [
    [
        'selector' => 'Abbr',
        'ruleName' => 'nobr_vtch_BC',
        'params' => [
            'pattern' => '/(^|\s|\&nbsp\;|)([дД]о)?[ ](н)\.?[ ]?э\./ue',
            'replacement' => '$m[1] . $this->tag($m[2] . " н."." э.", "span", array("class" => "nowrap"))',
        ],
    ],
];
```

4. Пример объявления изменений правил 

```php
$changedRules = [
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
];
```

### Использование типографа

1. Создание объекта типографа с пользовательскими настройками и обработка текста. В момент создания обекта класса TypographFacade<br>внутри него создается конфигуратор типографа.

```php
$typograph = new TypographFacade();
$processedText = $typograph->process('до н. э.');
```
