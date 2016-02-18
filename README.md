[![Code Climate](https://codeclimate.com/github/MadrakIO/persistent-command-bundle/badges/gpa.svg)](https://codeclimate.com/github/MadrakIO/persistent-command-bundle)
[![Packagist](https://img.shields.io/packagist/v/MadrakIO/persistent-command-bundle.svg)]()
[![Packagist](https://img.shields.io/packagist/dt/MadrakIO/persistent-command-bundle.svg)]()
[![Packagist](https://img.shields.io/packagist/l/MadrakIO/persistent-command-bundle.svg)]()

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require madrakio/persistent-command-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new MadrakIO\PersistentCommandBundle\MadrakIOPersistentCommandBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Use the bundle
-------------------------

[Configuration](https://github.com/MadrakIO/persistent-command-bundle/blob/master/Resources/doc/CONFIGURE.md)

[Creating a Command](https://github.com/MadrakIO/persistent-command-bundle/blob/master/Resources/doc/CREATE-A-COMMAND.md)