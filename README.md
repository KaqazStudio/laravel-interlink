# Index pages in Google

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kaqazstudio/laravel-interlink.svg?style=flat-square)](https://packagist.org/packages/kaqazstudio/laravel-interlink)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/kaqazstudio/laravel-interlink/run-tests?label=tests)](https://github.com/kaqazstudio/laravel-interlink/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/kaqazstudio/laravel-interlink.svg?style=flat-square)](https://scrutinizer-ci.com/g/kaqazstudio/laravel-interlink)
[![Total Downloads](https://img.shields.io/packagist/dt/kaqazstudio/laravel-interlink.svg?style=flat-square)](https://packagist.org/packages/kaqazstudio/laravel-interlink)

**WORK IN PROGRESS, some functionalities may be changed in the future.**

Add internal link to your published assets.

## Installation

You can install the package via composer:

```bash
composer require kaqazstudio/laravel-interlink
``` 

## Manual Registration
If autodiscovery doesn't work, register the package in your project __manually__.

■ Add this line to `config/app.php > providers array`
```php
KaqazStudio\LaravelInterlink\ServiceProvider\LaravelInterlinkServiceProvider::class
```

■ Then add the line below to `config/app.php > aliases array`
```php
'LaravelInterlink' => KaqazStudio\LaravelInterlink\Facade\LaravelInterlinkFacade::class
```

## Use with Facade

Initialize Interlink
```php
LaravelInterlink::single();
```

## Use without Facade

Initialize Interlink without facade
```php
LaravelInterlink::access();
```

Laravel Interlink are available on chains! :)

<div dir="ltr">

### Methods

Method                | Required |  Type  |   Default   | Description
----------------------|----------|--------|-------------|-------------------------------------
`init`                | true     | chain  |             | Fire the engine
`setKeyword`          | true     | string | null        | Set target keyword
`setTitle`            | false    | string | _`keyword`_ | Replace with the keyword
`setLink`             | true     | string | null        | Set internal link url
`rawLink`             | false    | bool   | false       | Set link url to raw format
`setCount`            | false    | int    | infinite    | Count of link replacement
`setPosts`            | true     | array  | null        | Set posts collection
`column`              | true     | string | null        | Set content column
`markdown`            | false    | bool   | false       | MarkDown format for links
`blank`               | false    | bool   | false       | Set links target to `_blank`
`noFollow`            | false    | bool   | false       | Set links rel to `nofollow`
`setCustomAttributes` | false    | string | null        | Set custom html attributes for a tag
`process`             | true     | chain  |             | Process link internalization  
`getUpdatedPosts`     | false    | chain  |             | Get updated posts as a collection
`updatePosts`         | false    | chain  |             | Do `update` method on all posts
</div>

## Example

For example, you want to refer all first __AirPods__ words to __/apple-airpods__ in all of your published Blog posts.

```php
LaravelInterlink::single()
                ->init()                     // Warm engine
                ->setKeyword('AirPods')      // Target Keyword
                ->setLink('/apple-airpods')  // Target url
                ->setCount(1)                // For first word
                ->setPosts(BlogPost::all())  // Get all blog posts
                ->setColumn('body')          // Set `body` column for content target
                ->process()                  // Process internalization
                ->updatePosts();             // Run update on posts!
```
Also, you can get all updated contents as a collection!

So, you MOST use `getUpdatedPosts()` __INSTEAD OF__ `updatePosts()`

### Use customized links

When you need to use your own format for link you can easily do like this

```php
LaravelInterlink::single()
                ...
                ->setLink('<a href="own.com">Custom-Link</a>')  // Your custom format
                ->rawLink()                                     // Raw link format [+]
                ...
```

Or, Maybe you to add custom html attributes to default link format - "Default a tag"

```php
LaravelInterlink::single()
                ...
                ->setCustomAttributes('custom-data="Hello"')  // Raw link format [+]
                ...
```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email `dev@kaqaz.studio` instead of using the issue tracker.

## Credits

- [Armin Hooshmand](https://github.com/realmrhex) ([personal site](https://hex.kaqaz.studio))
- [Kaqaz Studio Corp](https://kaqaz.studio)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
