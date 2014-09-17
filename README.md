AmoCrm
=========

Класс для работы с API [AmoCrm]

Использование
-------------
Для использования нужно создать объект класса AmoCrm, в конструктор которого передать параметры авторизации.

```php
$amo = new AmoCrm('login', 'hash', 'domain');
```

В конструкторе AmoCrm вызывается метод auth() для авторизации пользователя. В случае неудачи, вызывется исключение.

Далее можем использовать полученный объект для вызова методов от текущего пользователя. 

```php
$result = $amo->LeadsList(array('query' => 'Иванов');
```

С помощью массива можно задать необходимые параметры API запроса. Список параметров можно посмотреть в свойствах метода. Если метод не реализует переданный параметр, юудет вызвано исключение. 

> Для корректной работы необходимо иметь права на запись в директории *base*
> Для Get-методов есть возможность задать параметр ifModifiedSince в формате D, d M Y H:i:s

Результат
-------------

```php
Array
(
    [0] => Array
        (
            [id] => 20068976
            [name] => 2345678
            [date_create] => 1389769560
            [created_user_id] => 169376
            [last_modified] => 1389777292
            [status_id] => 7405672
            [sort] => 701
            [price] => 
            [responsible_user_id] => 169376
            [tags] => Array
                (
                )

            [linked_company_id] => 
            [account_id] => 7403232
            [deleted] => 0
            [custom_fields] => Array
                (
                    [0] => Array
                        (
                            [id] => 727012
                            [name] => Страна
                            [values] => Array
                                (
                                    [0] => Array
                                        (
                                            [value] => Испания
                                            [enum] => 1623634
                                        )

                                )

                        )

                )

        )
        ...
```

Методы
-----------------

Методы находятся в папке *methods*, их названия начинаюся с *Amo*, наследуются они от классов *AmoGetMethod* или *AmoPostMethod*, в зависимости от типа запроса и реализуют интерфейс *IMethod*.

```php
interface IMethod {
    /**
     * Получение имени метода для запроса к API
     * @return mixed
     */
    public function getMethodName();

    /**
     * Код метода
     * @return mixed
     */
    public function run();
} 
```



Для вызова методов в классе AmoCrm используется волшебный метод __call();

```php
public function __call($name, $params) {
        $className = 'Amo'.$name;
        $params['domain'] = $this->domain;
        $object = new $className($params);
        return $object->run();
    }
```

Атрибуты объекта Method описывают возможные параметры API запроса


```php
class AmoLeadsList extends AmoGetMethod implements IMethod {

    /**
     * Получение имени метода для запроса к API
     * @return mixed
     */
    public function getMethodName() {
        return '/private/api/v2/json/leads/list';
    }

    /**
     * Код метода
     * @return mixed
     */
    public function run() {
        //print_r($this->url);
        $data = $this->get();
        return $data['leads'];
    }

    /**
     * Кол-во выбираемых строк (системное ограничение 500)
     * @var
     */
    public $limit_rows;

    /**
     * Оффсет выборки (с какой строки выбирать) (Работает, только при условии, что limit_rows тоже указан)
     * @var
     */
    public $limit_offset;

    /**
     * Выбрать элемент с заданным ID (Если указан этот параметр, все остальные игнорируются)
     * (Можно передавать в виде массива состоящий из нескольких ID)
     * @var
     */
    public $id;

    /**
     * Искомый элемент, по текстовому запросу
     * (Осуществляет поиск по таким полям как : почта, телефон и любым иным полям, Не осуществляет поиск по заметкам и         * задачам
     * @var
     */
    public $query;

    /**
     * Дополнительный фильтр поиска, по ответственному пользователю
     * @var
     */
    public $responsible_user_id;

    /**
     * Фильтр по ID статуса сделки (Как узнать список доступных ID см. здесь)
     * @var
     */
    public $status;
} 
```

В методе нужно использовать $this->get() или $this->post(), в зависимости от метода, для получения данных API запроса.


Roadmap
-----------

- описание всех list-методов AmoCrm


Version
----

0.1

[AmoCrm]:https://www.amocrm.ru/
