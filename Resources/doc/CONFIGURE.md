Creating The Entities
=======================

The PersistentCommandBundle requires two entities to function correctly: **ConsoleNode** and **ConsoleNodeProcess**.

In order to add these to your project, you should extend the classes we've created and/or implement the interface as well. Here are the examples:

ConsoleNode
```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MadrakIO\PersistentCommandBundle\Entity\AbstractConsoleNode;
use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeInterface;

/**
 * ConsoleNode
 *
 * @ORM\Entity
 * @ORM\Table(name="console_node")
 */
class ConsoleNode extends AbstractConsoleNode implements ConsoleNodeInterface
{
}
```

ConsoleNodeProcess
```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MadrakIO\PersistentCommandBundle\Entity\AbstractConsoleNodeProcess;
use MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface;

/**
 * ConsoleNodeProcess
 *
 * @ORM\Entity
 * @ORM\Table(name="console_node_process")
 */
class ConsoleNodeProcess extends AbstractConsoleNodeProcess implements ConsoleNodeProcessInterface
{
}
```

Configuration Options
=======================

```yaml
doctrine:
    orm:
        resolve_target_entities:
            MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeInterface: AppBundle\Entity\ConsoleNode
            MadrakIO\PersistentCommandBundle\Entity\ConsoleNodeProcessInterface: AppBundle\Entity\ConsoleNodeProcess

madrak_io_persistent_command:
    console_node_class: AppBundle\Entity\ConsoleNode
    console_node_process_class: AppBundle\Entity\ConsoleNodeProcess
```

* The Doctrine ```resolve_target_entities``` configuration allows our parent class relationships to work

* ```console_node_class```: The classpath to the entity that extends ConsoleNode and implements ConsoleNodeInterface.
* ```console_node_process_class```: The classpath to the entity that extends ConsoleNodeProcess and implements ConsoleNodeProcessInterface.
