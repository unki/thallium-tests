This is the test suite of Thallium.

It is used to automate testing of Thallium - its controllers, models and views.

```run.sh``` is the script that shall be trigger.
It clones the offical Thallium GIT repository.
Afterwards it executes ```run_tests.sh```.

```run_tests.sh``` sets up an empty MySQL database instance, creates an empty
database and permissions. Afterwards it executes ```phpunit```.

```phpunit``` is used to perform the actual Thallium tests.
Thalliums MainController will be initialized and the previously created database flooded by the InstallerController.
Afterwards phpunit will continue with further tests on methods provided by controllers, models and views.

See LICENSE file for licensing information.

(c) 2015-2016 Andreas Unterkircher <unki@netshadow.net> 
