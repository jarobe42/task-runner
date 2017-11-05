# Concepts

TaskRunner has a few concepts that are used to run and monitor 
Tasks.

## TaskType

A TaskType defines the parameters that can be set for a Task.
In order to add your own tasks, simply add a class to your Type
folder that implements the `TaskTypeInterface`.

## TaskEvent

A TaskEvent represents a single instantiation of a Task. It is 
persisted by the entity manager, and will record when the task
was run, whether it was successful, and what errors it received 
if it was not.

## TaskDriver

A Task driver is the class responsible for running a Task.
TaskRunner provides a simple `TaskDriverInterface` that can
be used to register the TaskDrivers.