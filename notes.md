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

#### ORM:
- To install ORM  (doctrine), run `composer require symfony/orm-pack`.
- Install maker (scaffolding for the database), run `composer require symfony/maker-bundle --dev`.
- To generate an entity, run `php bin/console make:entity`.
- Whilst generating entities, `?` will provide a list of all available types.
- After generating the entity(ies), run `php bin/console make:migration` to create the database migrations.
- To execute the migrations to the target database, run `php bin/console doctrine:migrations:migrate`.
- To change an existing entity, add/remove the field(s) desired and run `php bin/console make:migration`, then
run `User`.
- After adding entity relations `1..*, *..* etc..` before executing the migrations, delete all tables within the 
database and previous migrations, otherwise errors will occur.

#### Serializer:
- Install with `composer require serializer`.
- Allows serialization/deserialization.

#### Fixture Bundles (fake data for testing, aka "Seeding"):
- docs.: https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html
- Installation, run `composer require --dev doctrine/doctrine-fixtures-bundle`.
- After installation, a class named `AppFixtures` will be found in `src/DataFixtures`,
within it, test objects can be created. After those are created, run `php bin/console doctrine:fixtures:load`
, type `y` or `yes` to load the data into the database. Note that the database records previous to the load will be
erased ("purged").

#### EasyAdmin:
- Install with `composer require admin`
- Create the dashboard with `php bin/console make:admin:dashboard`
- Create the dashboard controller with `php bin/console make:admin:crud`
- Additional steps: run `php bin/console cache:clar` (clear development dependencies),
run `symfony composer remove 'admin'` (remove the admin bundle), run `symfony composer req 'admin'`.
  - Ref.:  
    - https://stackoverflow.com/questions/65483207/easyadmin-bundle-problems-while-developing-my-web-app
    - https://stackoverflow.com/questions/33869521/how-can-i-enable-php-extension-intl

#### API platform:
- Install using `composer require api`. (installs api platform and CORS bundle)

#### Security:
- See https://symfony.com/blog/new-in-symfony-5-3-passwordhasher-component (Implementation).
- See https://symfony.com/doc/current/security.html#c-hashing-passwords (Configuration).

#### Faker:
- Install by running `composer require --dev fzaninotto/faker`
- Library docs.: https://github.com/fzaninotto/Faker