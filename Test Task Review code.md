# Review Code
- namespace - src\\Integration; - src - не соответсвует конвенции нейминга
## class DecoratorManager

### line 9
`class DecoratorManager extends DataProvider`

Исключить наследование. Лучше передать класс через конструктор используя инъекцию зависимости
### line 11

```
public $cache;
public $logger;
```
Изменить область видимости и реализовать геттеры  и сеттеры для текущих свойств. Думаю стоит исключить изменение свойства на прямую
### line 20
`public function __construct($host, $user, $password,`
Эти параметры будут переданы только в класс DataProvider

`public function __construct($host, $user, $password, CacheItemPoolInterface $cache)`
$cache является не обязательным параметром,
Добавить как параметр LoggerInterface

### line 22
`parent::__construct($host, $user, $password);`
Вызов родителя исключаем

### line 43 
 `$result = parent::get($input);`
Вызов родительского метода убираем, заменяем на вызов метода переданного класса из свойства 

### line 48
`(new DateTime())->modify('+1 day')`
Вынести в отдельный метод, чтобы была возможность конфигурировать время жизни кеша
### line 53
`$this->logger->critical('Error');`
Вызов метода логгера, без проверки на существования, так как не является обязательным параметром
В лог не передается описание ошибки. Лог является не информативным

Отсутсвуют аннотации к функциям и типизация методов

## class DataProvider
### line 28
`public function get(array $request)`
Что из себя представляет массив $request, какие параметры необходимо передать для выполнения запроса

Необходимо описать или реализовать объект с необходимыми полями.

Метод ничего не возвращает.

Реалзиация создания реквеста, я так понял в самом методе гет с отдельной реализацией.

Метод get в реализации должен подразумевать наличия Exception

## Общие рекомендации

Реализовать интерфейсы для текущих классов, чтобы при использование классов, зависимость была от абстракции.