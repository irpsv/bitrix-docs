# Component AJAX

Класс компонента:
```php
<?php

use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;

class ComponentName extends \CBitrixComponent implements Controllerable
{
    public function executeComponent()
    {
        // process
    }

    public function configureActions()
    {
        return [
            'test' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST
                    ]),
                ],
                'postfilters' => [],
            ],
        ];
    }

    public function testAction(string $param)
    {
        return [
            'retParam1' => 'value',
        ];
    }
}
```

Вызов из JS:
```js
var request = BX.ajax.runComponentAction("idex:subscribe.form", 'subscribe', {
    mode: 'class',
    data: {
        param: 'value',
    }
});
request.then(function(response) {
    response.status;
    response.errors;
    response.data.retParam1;
})
```
