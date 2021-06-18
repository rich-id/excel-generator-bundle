# Styles

Three annotations implements the main Style configuration:
    - `RichId\ExcelGeneratorBundle\Annotation\ContentStyle`
    - `RichId\ExcelGeneratorBundle\Annotation\HeaderStyle`
    - `RichId\ExcelGeneratorBundle\Annotation\HeaderTitle`

As they all implement the same features, the configuration is the same but used in different contexts. For the
following documentation, we will only use the `ContentStyle` annotation as the others are already explained in the
[Headers](Headers.md) documentation.


## Color

You can set either the text color using the `color` option, or the background color using the `backgroundColor` option.

Both option can either be a hexadecimal code, or an expression that returns a hexadecimal code. Therefore, the code should be either `#xxxxxx` or directly `xxxxxx` without the hash.

```php
use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ContentStyle(color="#012345", backgroundColor="this.getBackgroundColor()")
     */
    public $anyProperty;
    
    public function getBackgroundColor(): string
    {
        return '#' . substr(md5(mt_rand()), 0, 6);
    }
}
```


## Font

For now, only 2 font modifiers are supported: `bold` and `fontSize`. Their functions are explicit enough. However, an expression cannot be used as a value.

```php
use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ContentStyle(bold=true, fontSize=24)
     */
    public $anyProperty;
}
```


## Positions and behaviour

The horizontal and vertical position of the content as well. You also can choose if the text should wrap of been overflown.

The `position` option controls the horizontal position of the content. The value can only be `left`, `center` of `right`.

The `verticalPosition` option controls the vertical position of the content. The value can only be `top`, `center` of `bottom`.

The `wrapText` option is a boolean to control whether the text should be wrapped in the cell.

```php
use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ContentStyle(position="right", verticalPosition="bottom", wrapText=true)
     */
    public $anyProperty;
}
```
