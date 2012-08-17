# Search form & result renderer for Symfony2

XiSearchBundle provides simple way to display your search data when you do not know exactly what
kind of data to expect. 

You can use XiSearchBundle with any searchengine as XiSearchBundle provides you interfaces that your 
final search data object structure must implement.

## Installing

### deps -file
```
[XiSearchBundle]
    git=http://github.com/xi-project/xi-bundle-search.git
    target=/bundles/Xi/Bundle/SearchBundle
```

### autoload.php file
```php
<?php
'Xi\\Bundle'       => __DIR__.'/../vendor/bundles',
?>
```

### appKernel.php -file
```php
<?php
            new Xi\Bundle\SearchBundle\XiSearchBundle(), 
?>
```

### routing.yml -file
```yml
XiSearchBundle:
    resource: "@XiSearchBundle/Resources/config/routing.yml"
    prefix:   /
```

### config.yml -file
```yml
xi_search:
    result_renderer_extensions:
        [type]: [type]_renderer_extension
    default_limit: [50]
```

### extend ajaxForm (from ajaxbundle) and make sure you bind your custom class as your ajax form handler (see ajaxbundle documentation)

``` coffee
class App.AjaxForm.YourCustomClass extends App.AjaxForm.Default

    xiSearchResultCallback: (content) ->
        @searchResult =  $(@element).siblings('.search-result')
        if !@searchResult.length
            $(@element).after('<div class="search-result"></div>')
            @searchResult =  $(@element).siblings('.search-result')

        @searchResult.html(content)
```

## Integration to ElasticSearch

Probably most easiest way to use this bundle is to use it with ElasticSearch because XiSearchBundle provides you
premade implementation for it. This however requires [FOQElasticaBundle](https://github.com/Exercise/FOQElasticaBundle) to work.
