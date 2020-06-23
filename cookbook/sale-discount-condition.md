# Создание условия корзины

Подписка на событие:
```php
AddEventHandler('sale', 'OnCondSaleControlBuildList', 'SaleCondCtrlPhpCode::GetControlDescr');
```

Реализация условия:
```php
class SaleCondCtrlPhpCode extends \CSaleCondCtrlCommon
{
    /**
     * Описание условия, то что выводиться в админке при нажатии на кнопк "Добавить условие" в блоке "Дополнительные условия"
     */
    public static function GetControlShow($arParams)
    {
        // указываем параметры группы условий
        $arResult = array(
            'controlgroup' => true,
            'group' =>  false,
            'label' => "PHP-код",
            'showIn' => static::GetShowIn(),
            'children' => array()
        );

        $arControls = static::GetControls();
        foreach ($arControls as $arOneControl) {
            // добавляем конкретное условие
            $arResult['children'][] = array(
                'controlId' => $arOneControl['ID'],
                'group' => false,
                'label' => $arOneControl['LABEL'],
                'showIn' => static::GetShowIn(),
                'control' => array(
                    $arOneControl['PREFIX'],
                    static::GetLogicAtom($arOneControl['LOGIC']),
                    static::GetValueAtom($arOneControl['JS_VALUE'])
                )
            );
        }

        return $arResult;
    }

    /**
     * Список условий
     */
    public static function GetControls($strControlID = false)
    {
        $arControlList = array(
            ___CLASS__.'Control' => array(
                'ID' => ___CLASS__.'Control',
                'EXECUTE_MODULE' => 'all',
                'MODULE_ID' => false,
                'MODULE_ENTITY' => 'string',
                'FIELD' => 'PHP_CODE',
                'FIELD_TYPE' => 'text',
                'MULTIPLE' => 'N',
                'GROUP' => 'N',
                'LABEL' => "Вызов функции или метода класса",
                'PREFIX' => "Вызов функции или метода класса",
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input',
                ),
            )
        );

        if (false === $strControlID) {
            return $arControlList;
        } elseif (isset($arControlList[$strControlID])) {
            return $arControlList[$strControlID];
        } else {
            return false;
        }
    }

    /**
     * Метод возвращает группы, в которой отображается условие
     */
    public static function GetShowIn($arControls)
    {
        return [
            CSaleCondCtrlGroup::GetControlID(),
        ];
    }

    /**
     * Непосредственно метод, который занимается генерацией PHP кода, используемого в дальнейшем для проверки выполнения условия
     */
    public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
    {
        $logic = $arOneCondition['logic'];
        $func = (string) $arOneCondition['value'];
        if ($func) {
            if ($logic === "Not") {
                return "true != call_user_func('{$func}')";
            } elseif ($logic === "Equal") {
                return "true == call_user_func('{$func}')";
            } else {
                throw new \Exception("Invalide logic condition: '{$logic}'");
            }
        }
        return false;
    }
}
```
