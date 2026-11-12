# Updating from v3 to v4

Release 4.0.0 raises the PHP requirement. Nothing else changed in `src/`.

## At a glance

| | v3 (3.0.1) | v4 (4.0.0) |
|---|---|---|
| PHP | `^8.1.0` | `^8.3.0` |
| Public API | — | unchanged |

## Minimum supported PHP version raised

All Framework packages now require **PHP 8.3** or newer.

## No API changes

`git diff 3.0.1 HEAD -- src/` is empty. All four classes are byte-for-byte identical to 3.0.1.

## A note on `HtmlView` and the renderer

`HtmlView` type hints `Joomla\Renderer\RendererInterface`, and the `joomla/renderer` package is no
longer maintained. The type hint has not changed, so existing code keeps working — but for new
work, supply your own implementation of that interface, or use `JsonView` and `AbstractView`, which
have no such dependency. See [the overview](overview.md#the-renderer-dependency).

## Dependency changes

| Package | v3 (3.0.1) | v4 (4.0.0) |
|---|---|---|
| `php` | `^8.1.0` | `^8.3.0` |
