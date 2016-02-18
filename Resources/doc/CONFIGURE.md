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