# Headers

It is common to add a header above a set of data. This can be implemented 2 ways.


## Add the header only if data are available

Let's say you want to add a list of people information but only if at least one person is available in this list. Check
the class under.

You will transform all the people into a list of `PersonContent`. From there, if the list is empty, the header will be
not added to your sheet since no data are available.

About the Header style, checkout the [Styles](Styles.md) documentation. Both annotation inherits from the global style annotation.

```php
use RichId\ExcelGeneratorBundle\Annotation as Excel;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * @Excel\HeaderStyle(color="#FFFFFF", backgroundColor="#C1D9E1", fontSize=18, position=Excel\Style::POSITION_CENTER)
 */
class PersonContent extends ExcelContent
{
    /**
     * @var string
     *            
     * @Excel\HeaderTitle(title="app.person.firstname")
     */
   public $firstname;
   
    /**
     * @var string
     *            
     * @Excel\HeaderTitle(title="app.person.lastname")
     */
   public $lastname;
   
    /**
     * @var string
     *            
     * @Excel\HeaderTitle(title="app.person.age")
     */
   public $age;
}
```


## Add the header even if there is no data available

Let's say now you want to add the header event if the list is empty. To do that, you will need to create a new class
that will contain the same number of property and implement the header using the `ContentStyle`.

Let's use the same class as before. First, you need to remove all annotation related to the header since we will
implement it as a wrapper. Then, create a new class to implement the header explicitly:


```php
use RichId\ExcelGeneratorBundle\Annotation as Excel;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

class PersonHeader extends ExcelContent
{
    /**
     * @var string
     *            
     * @Excel\ContentStyle(color="#FFFFFF", backgroundColor="#C1D9E1", fontSize=18, position=Excel\Style::POSITION_CENTER)
     */
   public $firstname = 'Firstname';
   
    /**
     * @var string
     *            
     * @Excel\ContentStyle(color="#FFFFFF", backgroundColor="#C1D9E1", fontSize=18, position=Excel\Style::POSITION_CENTER)
     */
   public $lastname = 'Lastname';
   
    /**
     * @var string
     *            
     * @Excel\ContentStyle(color="#000000", fontSize=12, bold=true, wrapText=true)
     */
   public $age = 'Age';
}
```
