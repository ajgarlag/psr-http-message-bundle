AjgarlagPsrHttpMessageBundle
============================

This bundle provides support for HTTP messages interfaces defined
in [PSR-7]. It allows to inject instances of ``Psr\Http\Message\ServerRequestInterface``
and to return instances of ``Psr\Http\Message\ResponseInterface`` in controllers.


The inital code is borrowed from [sensio/framework-extra-bundle] which [removed support] for [PSR-7] since version 6.0.


Installation
------------

To install the latest stable version of this component, open a console and execute the following command:
```
$ composer require ajgarlag/psr-http-message-bundle
```

Note that [autowiring aliases for PSR-17] must be installed. An easy way to provide them is to require [nyholm/psr7] :
```
$ composer require nyholm/psr7
```

Configuration
-------------

If your code depends on old `sensio_framework_extra_...` services identifiers, you shoud enable aliasing defining:
```yaml
ajgarlag_psr_http_message:
    alias_sensio_framework_extra_services:
        enabled: true
```


Usage
-----

Then, [PSR-7] messages can be used directly in controllers like in the following code snippet

```php
namespace App\Controller;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController
{
    public function index(ServerRequestInterface $request, ResponseFactoryInterface $responseFactory)
    {
        // Interact with the PSR-7 request

        $response = $responseFactory->createResponse();
        // Interact with the PSR-7 response

        return $response;
    }
}
```

Note that internally, Symfony always use `Symfony\Component\HttpFoundation\Request`
and `Symfony\Component\HttpFoundation\Response` instances.


License
-------

This component is under the MIT license. See the complete license in the [LICENSE] file.


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker].


Author Information
------------------

Developed with ♥ by [Antonio J. García Lagar].

If you find this component useful, please add a ★ in the [GitHub repository page] and/or the [Packagist package page].

[sensio/framework-extra-bundle]: https://github.com/sensiolabs/SensioFrameworkExtraBundle
[removed support]: https://github.com/sensiolabs/SensioFrameworkExtraBundle/pull/710
[PSR-7]: http://www.php-fig.org/psr/psr-7/
[autowiring aliases for PSR-17]: https://github.com/symfony/recipes/blob/master/nyholm/psr7/1.0/config/packages/nyholm_psr7.yaml
[nyholm/psr7]: https://github.com/Nyholm/psr7
[LICENSE]: LICENSE
[Github issue tracker]: https://github.com/ajgarlag/psr-http-message-bundle/issues
[Antonio J. García Lagar]: http://aj.garcialagar.es
[GitHub repository page]: https://github.com/ajgarlag/psr-http-message-bundle
[Packagist package page]: https://packagist.org/packages/ajgarlag/psr-http-message-bundle
