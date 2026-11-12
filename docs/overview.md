# Overview

The View package is the presentation half of the framework's MVC triple. It provides a data
container and two output classes: one that hands the data to a template engine, one that encodes
it as JSON.

```bash
composer require joomla/view
```

## What is in the package

| Class | Purpose |
|---|---|
| `Joomla\View\ViewInterface` | The contract — `render(): string` |
| `Joomla\View\AbstractView` | Holds the data array; `addData()`, `setData()`, `getData()`, `removeData()`, `clearData()` |
| `Joomla\View\HtmlView` | Renders a named layout through a renderer |
| `Joomla\View\JsonView` | `json_encode()`s the data |

## The data container

`AbstractView` is a keyed bag of values with a fluent API:

```php
$view->addData('title', 'Hello')
     ->addData('articles', $articles);

$view->setData(['title' => 'Hello', 'articles' => $articles]);   // merges
$view->removeData('title');
$view->clearData();

$data = $view->getData();
```

`setData()` **merges** into the existing data rather than replacing it. Note that it uses
`array_merge()`, so numeric keys are renumbered instead of overwritten — call `clearData()` first
if you need a clean slate.

## `JsonView`

```php
use Joomla\View\JsonView;

$view = new JsonView();
$view->setData(['id' => 1, 'title' => 'Hello']);

$app->mimeType = 'application/json';
$app->setBody($view->render());
```

`render()` calls `json_encode($this->getData())` with no flags. Two consequences worth planning
for:

* **Encoding failures are silent.** Invalid UTF-8, `INF`, `NAN` or a recursive structure make
  `json_encode()` return `false`, which becomes an empty response body rather than an error.
* **The output is not safe to embed in a `<script>` block.** A value containing `</script>` will
  close the tag.

If either matters, encode yourself:

```php
$app->setBody(json_encode(
    $view->getData(),
    JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
));
```

## `HtmlView`

`HtmlView` pairs the data with a layout name and a renderer:

```php
use Joomla\View\HtmlView;

$view = new HtmlView($renderer);
$view->setLayout('articles/list')
     ->setData(['articles' => $articles]);

$app->setBody($view->render());
```

| Method | Returns | Notes |
|---|---|---|
| `__construct(RendererInterface $renderer)` | | The renderer is required |
| `getLayout()` / `setLayout(string $layout)` | `string` / `$this` | Defaults to `'default'` |
| `getRenderer()` / `setRenderer(RendererInterface $renderer)` | `RendererInterface` / `$this` | |
| `render()` | `string` | `$renderer->render($layout, $data)` |

### The renderer dependency

`HtmlView` type hints `Joomla\Renderer\RendererInterface`. That package is **no longer maintained**,
so for new work either

* keep `HtmlView` and supply your own class implementing that interface, or
* skip `HtmlView` and call your template engine from the controller, using `JsonView` or plain
  strings where appropriate.

`AbstractView` and `JsonView` have no such dependency and are usable on their own.

### Do not rely on `__toString()`

`HtmlView` implements `__toString()` as:

```php
try {
    return $this->render();
} catch (\Exception $e) {
    return $e->getMessage();
}
```

A failed render therefore becomes the page body — unescaped. Exception messages routinely contain
file paths, template names and request values, so this both leaks internals and creates a reflected
XSS vector, and the request still ends with status 200 because the failure was swallowed.

Call `render()` explicitly and handle failure yourself:

```php
try {
    $app->setBody($view->render());
} catch (\Throwable $e) {
    $app->getLogger()->error('View rendering failed', ['exception' => $e]);
    $app->setHeader('Status', '500', true);
    $app->setBody('<h1>Something went wrong</h1>');
}
```

## Escaping

The package does no escaping. Values pass from `getData()` to the renderer untouched, so whether
output is safe depends entirely on the template engine behind it. Engines with automatic escaping
(Twig, Latte) are safe by default; plain PHP templates are not. Decide which you are using and be
consistent — there is no `escape()` helper here to fall back on.

## What this package does not do

* No model binding — the view holds a flat array, and nothing connects it to `joomla/model`.
* No layout paths, fallbacks or template overrides; layout resolution belongs to the renderer.
* No content type handling — `JsonView` does not set `Content-Type`.
* No events, no caching, no `XmlView`/`CsvView`.
