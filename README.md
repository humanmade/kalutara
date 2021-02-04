# Kalutara

A 'living' pattern library plugin for WordPress themes generated from template parts. Pattern libraries often exist separately from the real project, and can easily become stale over time. Kalutra helps to avoid this issue by automatically generating the pattern library from all PHP template parts that you're using within your theme, and can be browsed on your WordPress site.

Created as a hack project at the Human Made Retreat 2019 Kalutara, Sri Lanka.

## Usage

Any PHP template part located within the `template-parts` directory of a theme is included automatically.

Use the file comment to provide additional information about the template that is then displayed within the pattern library. Use the PHP Doc format to specify a summary or title, and a longer description.

Example:

```php
<?php
/**
 * Box Component
 *
 * Call out box for highlighting content.
 *
 */
?>
```
### Passing data to a template.

Templates are loaded using the WordPress function [get_template_part](https://developer.wordpress.org/reference/functions/get_template_part/), which supports passing data to the template.

Example template using test data.

```php
<?php
/**
 * Box Component
 *
 * Call out box for highlighting content.
 */

// Tip: Use `wp_parse_args` to set default template data.
$args = wp_parse_args( $args, [
	'title' => 'Default value',
] );

?>
<div class="box">
	<h1><?php echo esc_html( $args['title'] ); ?></h1>
</div>
```

Example usage of template.

```php
get_template_part( 'template-parts/box', '', [ 'title' => 'Test Title' ] );
```

### Test Data

To specify test data for the template use the phpDoc `@data` tag, and give the test data as JSON,

```php
<?php
/**
 * Box Component
 *
 * Call out box for highlighting content.
 *
 * @data {"title":"Test Title"}
 */
?>
<div class="box">
	<h1><?php echo esc_html( $args['title'] ); ?></h1>
</div>
```
### Multiple variations

To display multiple variations of a single template, with different test data for each variation, use multiple `@data` tags, one for each variation.

```php
<?php
/**
 * Box Component
 *
 * Call out box for highlighting content.
 *
 * @data {"title":"Test Title"}
 * @data {"title":"Alternate version"}
 */
?>
<div class="box">
	<h1><?php echo esc_html( $args['title'] ); ?></h1>
</div>
```

### Data provider functions

You can also use PHP to pass the data to the template. Use the `@dataProvider` tag to specify a function that will return the data. This also supports multiple variations by using multiple `@dataProvider` tags. Note that you can use both `@data` and `@dataProvider` tags within a single template.

This is really useful if you want to retrieve a post from the database and pass it to your template.


```php
<?php
/**
 * Box Component
 *
 * Call out box for highlighting content.
 *
 * @dataProvider HM\MyTheme\PatternLibraryData\box
 */
?>
<div class="box">
	<h1><?php echo esc_html( $args['post']->post_title ); ?></h1>
</div>
```

```php
<?php

namespace HM\MyTheme\PatternLibraryData;

function box {
	return [
		'post' => get_post( 1 ),
	];
}
```

## Using extended template parts. 

By default, the plugin loads each template using the core `get_template_part` function, which supports passing data to the template. However if you want to use this plugin with the [Extended Template Parts library](https://github.com/johnbillion/extended-template-parts) by John Blackbourn, you do so by adding the following code to your theme. 

```
add_filter( 'kalutara_use_extended_template_parts', '__return_true' );
```

## Limitations

One limitation of the pattern library is that it relies on data being passed to the template, and cannot use global data e.g. `the_title`. However this is very common practice in WordPress development, and I'd probably advise against changing the way you do things completely to comply with the pattern library too much. Often it's best to just use the pattern library for smaller components.
