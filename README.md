AmoCrm
======
[![Latest Stable Version](https://poser.pugx.org/mb24dev/amocrm/v/stable)](https://packagist.org/packages/mb24dev/amocrm)
[![Build Status](https://travis-ci.org/mb24dev/amocrm.svg?branch=master)](https://travis-ci.org/mb24dev/amocrm)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mb24dev/amocrm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mb24dev/amocrm/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mb24dev/amocrm/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mb24dev/amocrm/?branch=master)
[![License](https://poser.pugx.org/mb24dev/amocrm/license)](https://packagist.org/packages/mb24dev/amocrm)


Библиотека для интеграции с [AmoCrm]

## Фичи

- PSR7 Request/Response
- Любая реализация HttpClient (Guzzle отработает из коробки, к другим скорее всего нужен адаптер к HttpClientInterface)
- Возможность интегрировать свои сущности в либу посредством реализации интерфейсов AmoEntityInterface и AmoIdentityInterface
- Возможность подключать свои реализации хранилища сессий AmoCRM
- Один клиент на все домены. Пользователь принадлежит домену, а не клиент
- Возможность трансформировать ответы как душе угодно, можно для всех методов, можно для каждого вызова отдельно
- PSR логирование

[AmoCrm]:https://www.amocrm.ru/
