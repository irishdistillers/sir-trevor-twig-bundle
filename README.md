# Sir Trevor Twig Bundle

## Usage

Add the following to your `composer.json`:

```json
"repositories": [{
    "type": "vcs",
    "url": "git@github.com:irishdistillers/sir-trevor-twig-bundle.git"
}]
```

and 

```json
"require": {
    "irishdistillers/sir-trevor-twig-bundle": "dev-master"
```

Then run `composer update irishdistillers/sir-trevor-twig-bundle`.

Finally, add the following to your `app/AppKernel.php` bundles section:

```php
$bundles = array(
    ...
    new IrishDistillers\SirTrevorTwig\SirTrevorTwig()
);
```

You will be able to render Sir Trevor content from any template:

```php
# Controller.php

return $this->render(
    'AppBundle::article.html.twig',
    ['content' => json_decode($some_sir_trevor_json)]
);
```


```html
<!-- article.html.twig -->

<div>
    {{ sirtrevor(content) | raw }}
</div>
```

## Overiding snippets

To override or add your own custom snippets, just add a file named `{$snippet_type}.html.twig` to the
`app/Resources/SirTrevorTwig/views/_snippets/sirtrevor/` folder in your bundle. By default you get the
following types:

- `captionable_image`
- `google_maps`
- `heading`
- `list`
- `quote`
- `soundcloud`
- `text`
- `youtube`