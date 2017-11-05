# Getting Started

After adding the Task Runner to your project, you'll need
to register it in your `AppKernel.php`

```
<?php

# app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
        ...
            new Jarobe\TaskRunnerBundle\JarobeTaskRunnerBundle(),
        ...
        ];
        ...
```

Once that's been done, the next step is to configure a few
parameters that the bundle requires.

```
#app/config/config.yml

jarobe_task_runner:
    entity_manager: null
    types:
        directory: YourBundle\Task\Type
        namespace: YourBundle\Task\Type
```
`entity_manager` is used to set the EntityManager that you wish
to use to save the TaskEvent entities.

`directory` and `namespace` are used to find the different 
TaskTypes that you wish to use. Just specify the 

Once that's done, you're ready to start using the task runner!