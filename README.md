# Nova HugeRTE Editor

## Introduction

Based on [murdercode/Nova4-TinymceEditor](https://github.com/murdercode/Nova4-TinymceEditor) HugeRTE license free 
alternative editor for your Laravel Nova App.

## Features 
- Dark mode support
- Switch between 5 or 6 versions of TinyMCE
- Can be disabled (by passing readonly() to make method)

## Prerequisites
- Laravel >= 9
- PHP >= 8.0
- Laravel Nova >= 5

## How to install

In the root of your Laravel installation launch:

```shell
composer require pekhota/nova-hugerte
```

Then publish the config:
```shell
php artisan vendor:publish --provider="Pekhota\NovaHugeRTE\FieldServiceProvider"
```

A file in config/nova-hugerte.php will appear as follows (you can change the default values):

```php
<?php

return [
    /**
     * The default skin to use.
     */
    'skin' => 'oxide-dark',

    /**
     * The default options to send to the editor.
     * See https://github.com/hugerte/hugerte and https://www.tiny.cloud/docs/configure/ for all available options.
     */
    'init' => [
        'menubar' => false,
        'autoresize_bottom_margin' => 40,
        'branding' => false,
        'image_caption' => true,
        'paste_as_text' => true,
        'autosave_interval' => '20s',
        'autosave_retention' => '30m',
        'browser_spellcheck' => true,
        'contextmenu' => false,
    ],
    'plugins' => [
        'advlist',
        'anchor',
        'autolink',
        'autosave',
        'fullscreen',
        'lists',
        'link',
        'image',
        'media',
        'table',
        'code',
        'wordcount',
        'autoresize',
    ],
    'toolbar' => [
        'undo redo restoredraft | h2 h3 h4 |
                 bold italic underline strikethrough blockquote removeformat |
                 align bullist numlist outdent indent | image link anchor table | code fullscreen spoiler',
    ],
];
```

## Register the Field

In your Nova/Resource.php add the field as following:

```php
<?php

use Pekhota\NovaHugeRTE\HugeRTE;

class Article extends Resource
{
    //...
    public function fields(NovaRequest $request)
    {
        return [
            HugeRTE::make(__('Content'), 'content')
                ->rules(['required', 'min:20'])
                ->fullWidth()
                ->help(__('The content of the article.')),
        ];
    }
}

```



