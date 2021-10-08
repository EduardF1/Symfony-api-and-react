#### Annotations (plain php):

1. Annotations are not supported natively by php but can be installed by running
   `composer require doctrine/annotations` in the project directory. (See lesson 13)
2. Create a new symfony project, run `composer create-project symfony/skeleton projectName`, the command will create a
   project with the given projectName within the current directory.

#### Example of creating a (new Symfony) project:

1. cd into `D:user/userName/projects` or any other directory.
2. run `composer create-project symfony/skeleton projectName`.
3.  A project named `projectName` will be created in `D:user/userName/projects`.
4.  After the project was generated, run `php -S 127.0.0.1:8000 -t public/` to run the web development server.

#### Annotations (Symfony):
- Not present by default, i.e. using the skeleton project, but they can be installed using `composer require annotations`.

#### API Routes:
- All available routes can be listed by running `php bin/console debug:router`.