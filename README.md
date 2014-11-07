fo-re-gen
=========

Formatted response generator for use in REST API backend creation, to allow JSON and XML output response string creation using similar methods.

FILE STRUCTURE
--------------

```
yii_module_example                         Yii 1.x compatible module
	protected                              Web application
		modules                            Web application modules
			api                            "api" module
				components                 Module components
					ResponseType.php       Response generation base class
					JsonResponse.php       JSON response subclass
					XmlResponse.php        XML response subclass
				controllers                Module controllers
					HelpController.php     Example controller that handles requests to /api/help
```

REQUIREMENTS
------------

[Yii framework](http://www.yiiframework.com/) and [mtHeader](https://github.com/mintao/yii-ext-mtHeader) extension

USAGE
-----

### JSON response generation

Create JSON response class instance

```php
$response = new JsonResponse();
```

Add content

```php
$response->setResponse(
	'foo',
	'bar'
);
```

Output response

```php
$response->output();
```

Result

```js
{'foo': 'bar'}
```

### XML response generation

Create JSON response class instance

```php
$response = new XmlResponse();
```

Add content

```php
$response->setResponse(
	'foo',
	'bar'
);
```

Output response

```php
$response->output();
```

Result

```xml
<?xml version="1.0"?>
<root><foo>bar</foo></root>
```

PROGRESS
--------

- [x] Response generation base class
- [x] JSON response subclass
- [x] XML response subclass
- [ ] HTML response subclass
- [ ] Dynamic constructor (```Response::create(Response::XML)```)
- [ ] Standalone version example (without Yii)
- [ ] Namespace support