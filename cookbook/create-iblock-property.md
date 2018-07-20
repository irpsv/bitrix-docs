# Создание свойства инфоблока

Событие `iblock OnIBlockPropertyBuildList`

https://dev.1c-bitrix.ru/api_help/iblock/classes/user_properties/GetUserTypeDescription.php

## Пример кода

```php
<?php

namespace olof\iblockPropertyType;

class SelectPriceType extends \CUserTypeIBlockElement
{
	const USER_TYPE = 'PropertySelectPriceType';

	function GetUserTypeDescription()
	{
		return array(
			"PROPERTY_TYPE" => \Bitrix\Iblock\PropertyTable::TYPE_STRING,
			"USER_TYPE" => self::USER_TYPE,
			"DESCRIPTION" => "Олоф. Список типа цен",
			"GetPropertyFieldHtml" => [__CLASS__, "GetPropertyFieldHtml"],
		);
	}

	public function GetPropertyFieldHtml($property, $value, $htmlControlName)
	{
		\CModule::includeModule('catalog');

		$value = $value['VALUE'] ?? null;
		$name = $htmlControlName['VALUE'];
		$priceTypes = \Bitrix\Catalog\GroupTable::getList()->fetchAll();

		echo "<select name='{$name}'>";
		echo "<option></option>";
		foreach ($priceTypes as $price) {
			$id = $price['ID'];
			$label = $price['NAME'];
			$selected = $id == $value ? "selected" : "";

			echo "<option value='{$id}' {$selected} >{$label}</option>";
		}
		echo "</select>";
	}
}
```

## Подписка на событие

```php
AddEventHandler('iblock', 'OnIBlockPropertyBuildList', function(){
	return \olof\iblockPropertyType\SelectPriceType::GetUserTypeDescription();
});
```
