Creating a Command
================

*Special Notes*

By design, a command using this bundle can only be running once per node. If you run a command and, while that is running, try to run a second instance simultaneously it will throw an error. 

Additionally, memory management is specifically left out of this bundle because every project will have different requirements.

Extending AbstractPersistentCommand
-----------------------------------

By extending AbstractPersistentCommand, you get a simple command that is executed and runs through its runProcess method then stops.

**Example class:**
```php
<?php

namespace AppBundle\Command;

use MadrakIO\PersistentCommandBundle\Command\AbstractPersistentCommand;

class SimpleTestCommand extends AbstractPersistentCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('madrakio:test')
            ->setDescription("Test script.");
    }

    protected function runProcess()
    {
        $this->writeLog("TEST!");
    }
}
```

**Running the command:**

```app/console madrakio:test```

Extending AbstractContinuousPersistentCommand
----------------------------------------------

By extending AbstractContinuousPersistentCommand, you get a command that continuously runs until it is issued a stop, kill or clean.

**Example class:**
```php
<?php

namespace AppBundle\Command;

use MadrakIO\PersistentCommandBundle\Command\AbstractContinuousPersistentCommand;

class ContinuousTestCommand extends AbstractContinuousPersistentCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('madrakio:testloop')
            ->setDescription("Test loop script.");
    }

    protected function runProcess()
    {
        $this->writeLog("TEST!");
        sleep(5);
    }
}
```

**Running the command:**

```app/console madrakio:testloop start```

**Checking the status of the command (Returns whether it's running, crashed or stopping):**

```app/console madrakio:testloop status```

**Stopping the command (Issues a stop command which will stop the process before it's next loop):**

```app/console madrakio:testloop stop```

**Killing the command (Immediately terminates the process):**

```app/console madrakio:testloop kill```

**Cleaning the command (Meant to be used to cleanup after a crashed process):**

```app/console madrakio:testloop clean```

Adding Additional Requirements
-------------------------------

Sometimes, you may have a command that needs a certain criteria to be met before it can run (ie. a certain parameter is set or not set).

This parent classes in this bundle call the ```checkRequirements``` method before running a command. If this method returns false, it will not run. To add your own requirements, simply follow this example:

```php
//...
class ContinuousTestCommand extends AbstractContinuousPersistentCommand
{
    //...
    protected function checkRequirements()
    {
        if ($this->getContainer()->getParameter('commands_should_run') === true) {
            return true;
        }
        
        return false;
    }
}
```

If the method returns false, the command will output an error and will not run. It is up to you to output meaningful messages about the requirements that failed to pass.
