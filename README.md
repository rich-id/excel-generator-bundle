![Logo](.github/excel-generator-bundle.svg)

Rich ID Excel Generator Bundle
=======================================

[![Package version](https://img.shields.io/packagist/v/rich-id/excel-generator-bundle)](https://packagist.org/packages/rich-id/excel-generator-bundle)
[![Actions Status](https://github.com/rich-id/excel-generator-bundle/workflows/Tests/badge.svg)](https://github.com/rich-id/excel-generator-bundle/actions)
[![Coverage Status](https://coveralls.io/repos/github/rich-id/excel-generator-bundle/badge.svg?branch=master)](https://coveralls.io/github/rich-id/excel-generator-bundle?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/144a5e6be7cc097ddc2c/maintainability)](https://codeclimate.com/github/rich-id/excel-generator-bundle/maintainability)
![Symfony 4.4+](https://img.shields.io/badge/Symfony-4.4+-000000)
![PHP 7.3+](https://img.shields.io/badge/PHP-7.3+-858ebb.svg)
[![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/rich-id/excel-generator-bundle/issues)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

Quickly and easily generate complex Excel files hydrated with your own data with style.


# Quick start

The Excel is built from 3 different models: the spreadsheet, a sheet and a content.

- The spreadsheet contains only the filename, and a list of sheets
- A sheet has only a name and a list of child
- A child is often a custom class that extends from the ExcelContent class to hydrate the content

This is an example of a custom content that has some children. Any children will take its own row, which is very handy
for recursion.

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
     * @Excel\ContentStyle(color="#000000", fontSize=12, wrapText=true)
     * @Excel\HeaderTitle(title="app.person.firstname")
     */
   public $firstname;
   
    /**
     * @var string
     *            
     * @Excel\ContentStyle(color="#000000", fontSize=12, bold=true, wrapText=true)
     * @Excel\HeaderTitle(title="app.person.lastname")
     */
   public $lastname;
   
    /**
     * @var string
     *            
     * @Excel\ContentStyle(color="#000000", fontSize=10)
     * @Excel\HeaderTitle(title="app.person.age")
     */
   public $age;
   
   public function __construct(User $user)
   {
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->age = $user->getAge();
        
        foreach ($user->getAddresses() as $address) {
            $addressContent = new AddressContent($address);
            $this->addChild($addressContent);
        }
   }
}
```


# Table of content

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
    - [Columns](docs/Columns.md)
    - [Headers](docs/Headers.md)
    - [Styles](docs/Styles.md)
3. [Versioning](#3-versioning)
4. [Contributing](#4-contributing)
5. [Hacking](#5-hacking)
6. [License](#6-license)


# 1. Installation

This version of the bundle requires Symfony 4.4+ and PHP 7.3+.

```bash
composer require rich-id/excel-generator-bundle
```

# 2. Configuration

- [Columns](docs/Columns.md)
- [Headers](docs/Headers.md)
- [Styles](docs/Styles.md)


# 3. Versioning

excel-generator-bundle follows [semantic versioning](https://semver.org/). In short the scheme is MAJOR.MINOR.PATCH where
1. MAJOR is bumped when there is a breaking change,
2. MINOR is bumped when a new feature is added in a backward-compatible way,
3. PATCH is bumped when a bug is fixed in a backward-compatible way.

Versions bellow 1.0.0 are considered experimental and breaking changes may occur at any time.


# 4. Contributing

Contributions are welcomed! There are many ways to contribute, and we appreciate all of them. Here are some of the major ones:

* [Bug Reports](https://github.com/rich-id/excel-generator-bundle/issues): While we strive for quality software, bugs can happen and we can't fix issues we're not aware of. So please report even if you're not sure about it or just want to ask a question. If anything the issue might indicate that the documentation can still be improved!
* [Feature Request](https://github.com/rich-id/excel-generator-bundle/issues): You have a use case not covered by the current api? Want to suggest a change or add something? We'd be glad to read about it and start a discussion to try to find the best possible solution.
* [Pull Request](https://github.com/rich-id/excel-generator-bundle/pulls): Want to contribute code or documentation? We'd love that! If you need help to get started, GitHub as [documentation](https://help.github.com/articles/about-pull-requests/) on pull requests. We use the ["fork and pull model"](https://help.github.com/articles/about-collaborative-development-models/) were contributors push changes to their personal fork and then create pull requests to the main repository. Please make your pull requests against the `master` branch.

As a reminder, all contributors are expected to follow our [Code of Conduct](CODE_OF_CONDUCT.md).


# 5. Hacking

You might use Docker and `docker-compose` to hack the project. Check out the following commands.

```bash
# Start the project
docker-compose up -d

# Install dependencies
docker-compose exec application composer install

# Run tests
docker-compose exec application bin/phpunit

# Run a bash within the container
docker-compose exec application bash
```


# 6. License

excel-generator-bundle is distributed under the terms of the MIT license.

See [LICENSE](LICENSE.md) for details.
