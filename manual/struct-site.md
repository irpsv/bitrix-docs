# Структура сайта

Каждый сайт состоит из следующих составляющих:
- страницы
- формы
- сервисы

На **страницах** могут распологаться различные виджеты (списки, таблицы, в том числе и формы).  
**Формы** выделены в отдельный пункт, т.к. это единственный способ (не считая параметры запроса), взаимодействия с клиентом.  
**Сервисы** - это голая логика, т.е. выполнение конкретного действия. Причем это не ограничивается сервисы в плане отдачи данных, т.е. сервис может возвращать куски HTML кода.

## Структура страниц и сервисов

Для сайта, можно построить примерно такую структуру (на примере каталога):
- catalog
  - element.php
  - section.php
  - index.php
- basket
  - index.php
- api
  - basket
    - add-product.php
    - clear.php
  - catalog
    - element
      - like.php

Папка **api** содержит сервисы, все остальное - это страницы.
Каждая страница и каждый сервис, должны выполнять только 1 логическую функцию.  
Если сервис становится слишком большим, то **можно** разбить 1 сервис на несколько.  
Если сервис выполняет одновременно несколько функций, то **нужно** разбить 1 сервис на несколько.

Пример НЕ корректного сервиса:  
Сервис **like-product** - увеличивает счетчик лайков для товара и добавляет товар в список "понравившихся" пользователю, возвращает количество лайков текущего товара.

Пример корректного сервиса:  
Сервис **add-like-product** - добавляет товар в список "понравившихся" пользователю.  
Сервис **like-product** - увеличивает счетчик лайков для товара, вызывает сервис "add-like-product", возвращает количество лайков текущего товара.

Несмотря на то, что выполняется 3 действия - все они связаны с одной сущностью/логикой "лайк продукта".
В данном случае, допускается внутренний вызов сервиса, т.к. это необходимо для соблюдения логической целостности (если товар лайкнут пользователем, то он должен быть в списке понравившихся).

Выделять функционал в отдельный сервис необходимо по нескольким причинам:
1. простота
2. разграничение ответственности

Разобраться и поддерживать проще/удобнее много маленьких сервисов, чем немного больших.

## CURL

Сервисы внутри друг друга, нужно вызывать через CURL.
Пример вызова:
```php
$ch = curl_init("/api/service/name.php");
curl_setopt_array($ch, [
	CURLOPT_RETURNTRANSFER => true,
]);
$response = curl_exec($ch);
curl_close($ch);
```

[Подробнее](http://php.net/manual/ru/book.curl.php).
