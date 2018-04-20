# Структура

Битрикс - это файловая CMS, каждая страница представляет из себя файл.
Система состоит из следующих составных частей:
- компоненты
- модули
- публичные страницы
- административные страницы

## Компоненты

Компоненты - это виджеты, объекты, которые на вход получают какие-либо данные и должны произвести какой-нибудь вывод.
В Битрикс компоненты делятся на 2 вида:
- простые
- комплексные

Комплексные компоненты - это по сути простые роутеры, которые подключают разные файлы в зависимости от URL.
Дополнительно можно нагрузить их логикой, чтобы хоть как то оправдать их существование.  

> НИКОГДА не используйте комплексные компоненты! Для маршрутизации страниц существует роутер (urlrewrite.php).
> Выделяйте конкретный функционал в конкретную страницу или сервис.

[Подробнее](./components.md)

## Модули

Модули - это набор компонентов, административных страниц, файлов бизнес-логики объедененных одним контектом (модули в обычном их понимании).
Каждый модуль может содержать:
- административные страницы и сервисы
- файлы установки/удаления
- конфигурацию (конфиг файл, который правиться через админку)
- компоненты
- бизнес-логика

[Подробнее](./modules.md)

## Публичные страницы

Это страницы сайта, которые видит пользователь.
Условно страницы можно разделить на 2 вида:
- страницы
- сервисы

Сервисы отличаются от страниц тем, что они не привязаны к шаблону.
Сервисы выполняют только определнный функционал и возвращают "голые" данные (без шаблонизации).

[Подробнее](./public-pages.md)

## Административные страницы

Это страницы сайта, которые отображаются в админке, в самом Битрикс.
Данные страницы также можно разделить на сервисы и страницы, но т.к. все административные страницы предтавляют из себя либо список, либо форму, то в этом нет необходимости.
Также существуют специализированные страницы/скрипты:
- menu.php - конфигурация меню админки
- options.php - конфигурация модуля

[Подробнее](./admin-pages.md)