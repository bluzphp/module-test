# Module test for Bluz Skeleton

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/bluzphp/main)

### Achievements

[![Build Status](https://travis-ci.org/bluzphp/module-test.svg?branch=master)](https://travis-ci.org/bluzphp/module-test)

Usage
-------------------------
### Install module
To install the module run the command:
  

    $ composer require bluzphp/module-test

Then you must enter the environment


    Please, enter your environment[dev, production, testing or another] dev


If you use no-interaction mode, you must set an environment variable
  

    $ ENV=dev composer require bluzphp/module-test -n


### Remove module
To remove the module, run the command:
    

    $ composer remove bluzphp/module-test


After you will see a confirmation message for removing the module tables

    Do you want to remove table: test[y, n] y

And set an environment variable
    

    Please, enter  your environment[dev, production, testing or another] dev

    
If you use no-interaction mode, you must set an environment variable
  

    $ ENV=dev composer remove bluzphp/module-test -n


