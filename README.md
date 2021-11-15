### Компонент типографа на ЯП PHP со встроенным конфигуратором
Конфигуратор типографа настраивает правила типографа Муравьева.<br><br>
Добавление или удаление третов в конфигураторе не реализовано. Если какой-либо трет нужно полностью исключть из типографирования, то можно отключить все его правила.<br><br>

<ul>
    <li>
        <b>Трет</b> - это блок или модуль правил. Например: трет Symbol содержит правила обнаружения и обработки различных символов.
        <hr>        
    </li>
    <li>
        <b>Правило</b> - это массив, состоящий из регулярок(-ки) обнаружения случая в тексте и регулярок(-ки), на которые соответственно необходимо заменить найденный случай в тексте. <br>Также имеется (неоябзательная) ячейка в массиве с описанием сути правила.
        <hr>  
    </li>
    <li>  
        <b>Typograph composer-пакета oleg-chulakov-studio/mdash</b> - это наследник <i>TypographBase</i>. В нем объявлены не все правила третов, которые доступны в классе <i>TypographBase</i>.<br>В результате не все правила класса TypographBase можно подключить / отключить. Потому некоторые правила третов класса <i>TypographBase</i> прописаны<br>в переменной <i>$additionalOptions</i> класса <i>TypographConfigurator</i> для их последующей настройки.
        <hr>  
    </li>
    <li>
        Класс <i>Typograph</i> с пространством имен <i>Chulakov\PhpTypograph</i> наследуется от класса <i>Typograph</i> из composer-пакета <i>oleg-chulakov-studio/mdash</i>, т. к. необходимо было добавить<br>правила типографу, которые были доступны в классе <i>TypographBase</i>, но перестали быть доступны в классе <i>Typograph</i> из composer-пакета <i>oleg-chulakov-studio/mdash</i>.
        <hr>  
    </li>
</ul>

### Установка

Чтобы установить компонент, нужно в composer.json добавить следующие строки:

```php
"require": {
    "chulakov/ch-php-typograph": "^1.0.0",
}
```

Или набрать команду:

```php
composer require chulakov/ch-php-typograph
```

### Работа конфигуратора

1. Объявление конфигуратора типографа. Настройка типографа с правилами, прописанными в конфигах и внутри самого конфигуратора по умолчанию

```php
$configurator = new TypographConfigurator();
$configurator->configure();
```

2. Настройка типографа с правилами, переданными через конструктор конфигуратора

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

1. Создание объекта типографа с пользовательскими настройками и обработка текста. В момент создания обекта класса <i>TypographFacade</i> внутри него создается<br>конфигуратор типографа

```php
$typograph = new TypographFacade();
$processedText = $typograph->process('до н. э.');
```
