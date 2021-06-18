# Columns

You can edit the column options to fit your needs. 


## RichId\ExcelGeneratorBundle\Annotation\ColumnDimension

This annotation has 2 properties : 
- `dimension`: Dimension in pixel
- `autoResize`: Automatically resize the column to fit the content

```php
use RichId\ExcelGeneratorBundle\Annotation\ColumnDimension;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ColumnDimension(dimension=540)
     */
    public $anyProperty;
    
    /**
     * @ColumnDimension(autoResize=true)
     */
    public $anotherProperty;
}
```


## RichId\ExcelGeneratorBundle\Annotation\ColumnMerge

This annotation has only one property :
- `count`: Number of columns to merge

```php
use RichId\ExcelGeneratorBundle\Annotation\ColumnMerge;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ColumnMerge(count=4)
     */
    public $anyProperty;
}
```


## RichId\ExcelGeneratorBundle\Annotation\ColumnAutoResize

This annotation has no property. It auto resize the column.

```php
use RichId\ExcelGeneratorBundle\Annotation\ColumnsAutoResize;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class Content extends ExcelContent
{
    /**
     * @ColumnsAutoResize
     */
    public $anyProperty;
}
```
