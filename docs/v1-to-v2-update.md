# Updating from v1 to v2

Release 2.0.0 rebuilt the package. Views no longer require a model, the HTML view became a concrete
class backed by a renderer instead of an abstract class doing its own file lookups, and the
escaping helper was dropped.

## At a glance

| | v1 (1.3.0) | v2 (2.0.0) |
|---|---|---|
| PHP | `^5.3.10 \| ~7.0` | `^7.2.5 \| ^8.0` |
| Classes | `ViewInterface`, `AbstractView`, `AbstractHtmlView` | `ViewInterface`, `AbstractView`, `HtmlView`, `JsonView` |
| Model | required by `AbstractView` | not used at all |
| Templating | own layout file lookup, needed `joomla/filesystem` | delegated to a renderer |
| `escape()` | on `ViewInterface` | removed |

## Minimum supported PHP version raised

All Framework packages now require **PHP 7.2** or newer.

## `ViewInterface::escape()` removed

The interface no longer declares an escaping helper. Escaping still has to happen — it simply is
not this package's job any more. Where it happens now depends on the template engine you put behind
`HtmlView`: engines such as Twig escape automatically, plain PHP templates do not.

## Models are no longer compulsory

`AbstractView` used to require a model object. It now holds a plain keyed array instead, filled
through the data API:

```php
// v1
$view = new MyHtmlView($model, $paths);

// v2
$view = new HtmlView($renderer);
$view->setData(['articles' => $model->getItems()]);
```

Applications that want a model in their views are free to require one in their own subclass.

## `AbstractHtmlView` replaced by `HtmlView`

`AbstractHtmlView` resolved layout files itself and therefore depended on `joomla/filesystem`. It
was removed in favour of the concrete `HtmlView`, which delegates rendering to any
`Joomla\Renderer\RendererInterface` implementation:

```php
// v2
$view = new HtmlView($renderer);
$view->setLayout('articles/list');

echo $view->render();
```

`joomla/filesystem` is no longer needed.

## `JsonView` added

A second concrete view was added for API style responses. `render()` returns
`json_encode($this->getData())`.

## The data API

`AbstractView` gained the methods that replaced the model:

| Method | Effect |
|---|---|
| `addData(string $key, $value)` | Set one key |
| `setData(array $data)` | Merge an array into the existing data |
| `getData()` | The whole array |
| `removeData(string $key)` | Drop one key |
| `clearData()` | Drop everything |

All of them except `getData()` are fluent.

## Dependency changes

| Package | v1 (1.3.0) | v2 (2.0.0) |
|---|---|---|
| `php` | `^5.3.10 \| ~7.0` | `^7.2.5 \| ^8.0` |
| `joomla/filesystem` | suggested, for `AbstractHtmlView` | no longer used |
| `joomla/renderer` | — | suggested, for `HtmlView` |
