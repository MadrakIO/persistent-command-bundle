Creating a Command
================

By design, a command using this bundle can only be running once per node. If you run a command and, while that is running, try to run a second instance simultaneously it will throw an error.

* By extending AbstractPersistentCommand, you get a simple command that is executed and runs through it's runProcess method then stops.

Example class: 
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

Running the command:
```app/console madrakio:test```

* By extending AbstractContinuousPersistentCommand, you get a command that continuously runs until it is issued a stop, kill or clean.

Example class:
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

Running the command:
```app/console madrakio:testloop start```

Checking the status of the command (Returns whether it's running, crashed or stopping):
```app/console madrakio:testloop status```

Stopping the command (Issues a stop command which will stop the process before it's next loop):
```app/console madrakio:testloop stop```

Killing the command (Immediately terminates the process):
```app/console madrakio:testloop kill```

Cleaning the command (Meant to be used to cleanup after a crashed process):
```app/console madrakio:testloop clean```