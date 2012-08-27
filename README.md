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
        acmeType: acmeType_renderer_extension
    default_limit: 50
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

## Pagination
Pagination uses knp-pagination bundle, and it's on by default

Suppose the search is retreived via ajax, there's a jquery plugin included that binds the received pagination's logic to the actual search form with javascript.

As the pagination generally uses the search forms default fields, only the indices need configuration. page, term and submit button values can also be overridden
``` coffee
$('#search-result-container').xiSearchPaginate
        indices: ['#xi_searchbundle_searchtype_index_0', '#xi_searchbundle_searchtype_index_1', ...]
```

For these bindigs to work, configure the knp pagination to use the proper pagination template
```yml
knp_paginator:
    page_range: 9                      # default page range used in pagination control
    default_options:
        page_name: page                # page query parameter name
        sort_field_name: sort          # sort field query parameter name
        sort_direction_name: direction # sort direction query parameter name
        distinct: true                 # ensure distinct results, useful when ORM queries are using GROUP BY statements
    template:
        pagination: XiSearchBundle:Pagination:sliding.html.twig     # sliding pagination controls template
        sortable: KnpPaginatorBundle:Pagination:sortable_link.html.twig # sort link template
```
