## Updating from v4 to v5

The following changes were made to the View package between v4 and v5.

### Native return and property types

The View classes now declare native types instead of documenting them in doc blocks only. Classes implementing `Joomla\View\ViewInterface` or extending one of the View classes must add the same types to methods and properties they override, otherwise PHP raises a fatal error when the class is loaded.

| Class | Member | v4 | v5 |
|---|---|---|---|
| `ViewInterface` | `render()` | `render()` | `render(): string` |
| `AbstractView` | `addData()` | `addData(string $key, $value)` | `addData(string $key, mixed $value): static` |
| `AbstractView` | `clearData()` | `clearData()` | `clearData(): static` |
| `AbstractView` | `removeData()` | `removeData(string $key)` | `removeData(string $key): static` |
| `AbstractView` | `setData()` | `setData(array $data)` | `setData(array $data): static` |
| `AbstractView` | `$data` | `private $data` | `private array $data` |
| `HtmlView` | `__toString()` | `__toString()` | `__toString(): string` |
| `HtmlView` | `render()` | `render()` | `render(): string` |
| `HtmlView` | `setLayout()` | `setLayout(string $layout)` | `setLayout(string $layout): static` |
| `HtmlView` | `setRenderer()` | `setRenderer(RendererInterface $renderer)` | `setRenderer(RendererInterface $renderer): static` |
| `HtmlView` | `$layout` | `protected $layout` | `protected string $layout` |
| `HtmlView` | `$renderer` | `private $renderer` | `private RendererInterface $renderer` |
| `JsonView` | `render()` | `render()` | `render(): string` |

For example, a view that extends `HtmlView` and overrides the layout must now declare the property type:

```php
use Joomla\View\HtmlView;

class ArticleView extends HtmlView
{
    protected string $layout = 'article';

    public function render(): string
    {
        // ...
    }
}
```
