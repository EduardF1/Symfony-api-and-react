### Annotations (plain php):

1. Annotations are not supported natively by php but can be installed by running
   `composer require doctrine/annotations` in the project directory. (See lesson 13)
2. Create a new symfony project, run `composer create-project symfony/skeleton projectName`, the command will create a
   project with the given projectName within the current directory.

### Example of creating a (new Symfony) project:

1. cd into `D:user/userName/projects` or any other directory.
2. run `composer create-project symfony/skeleton projectName`.
3. A project named `projectName` will be created in `D:user/userName/projects`.
4. After the project was generated, run `php -S 127.0.0.1:8000 -t public/` to run the web development server.
5. Additionally, for starting/stopping the development server the following commands can be run:
`symfony server:start` and `symfony server:stop`.

### Annotations (Symfony):

- Not present by default, i.e. using the skeleton project, but they can be installed
  using `composer require annotations`.
- Sometimes for new changes to take place, it is necessary to clear the development cache, run `php bin/console cache:clear`.

### API Routes:

- All available routes can be listed by running `php bin/console debug:router`.

### ORM:

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

### Serializer:

- Install with `composer require serializer`.
- Allows serialization/deserialization.

### Fixture Bundles (fake data for testing, aka "Seeding"):

- docs.: https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html
- Installation, run `composer require --dev doctrine/doctrine-fixtures-bundle`.
- After installation, a class named `AppFixtures` will be found in `src/DataFixtures`, within it, test objects can be
  created. After those are created, run `php bin/console doctrine:fixtures:load`
  , type `y` or `yes` to load the data into the database. Note that the database records previous to the load will be
  erased ("purged").

### EasyAdmin:

- Install with `composer require admin`
- Create the dashboard with `php bin/console make:admin:dashboard`
- Create the dashboard controller with `php bin/console make:admin:crud`
- Additional steps: run `php bin/console cache:clar` (clear development dependencies),
  run `symfony composer remove 'admin'` (remove the admin bundle), run `symfony composer req 'admin'`.
    - Ref.:
        - https://stackoverflow.com/questions/65483207/easyadmin-bundle-problems-while-developing-my-web-app
        - https://stackoverflow.com/questions/33869521/how-can-i-enable-php-extension-intl

### API platform:

- Install using `composer require api`. (installs api platform and CORS bundle)
- Each of the API Platform routes is called "an operation".
- `collectionOperations` are for manipulating lists of items whilst `itemOperations` are for manipulating individual
  items (CRUD on 1 resource).
- Regardless of single item manipulation or collection manipulation, specific operations can be enabled/disabled from
  the defaults provided by API Platform through using annotations on the resource class:
- There property `normalizationContext` allows for custom serialization/deserialization contexts (https://api-platform.com/docs/core/serialization/).
If no serialization/deserialization group (https://api-platform.com/docs/core/serialization/#using-serialization-groups) is provided, the "default" group is used.
- Available api routes can be accessed using `php bin/console debug:router`.
```
Example:
/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 */
 class BlogPost {}
```

### Security:

- See https://symfony.com/blog/new-in-symfony-5-3-passwordhasher-component (Implementation).
- See https://symfony.com/doc/current/security.html#c-hashing-passwords (Configuration).

### Faker:

- Install by running `composer require --dev fzaninotto/faker`
- Library docs.: https://github.com/fzaninotto/Faker

### Serialization & Deserialization:

```
    (PHP) Object (Ex.: Array)                Specified format (JSON,XML)
            |___ 1)Normalize                        |
                       |_________ 2)Encode__________|
            
            |_________SERIALIZATION PROC.___________| 
            
      Specified format (JSON,XML)           (PHP) Object (Ex.: Array)
            |___ 1)Decode                           |
                       |_____ 2)Denormalize_________|
            
            |_________DESERIALIZATION PROC._________| 
```

### Example of Serialization

```
class User {
    private $id;
    private $name;
    private $fullName;
}    
        ||
        || --- by normalizing, we mean encoding the class data into an
        ||     associative array/map.
        \/
        
    $normalizedUser = [
        'id' => 1,
        'name' => 'eduard_f',
        'fullName' => 'Eduard F.'
    ];
        
        ||
        ||
        ||
        \/
        
    JSON (Serialization):
    {
        "id":1,
        "name":"eduard_f",
        "fullName":"Eduard F."
    }
```

### Example of Deserialization

```
    JSON object:
        {
            "id":1,
            "name":"eduard_f",
            "fullName":"Eduard F."
        }
        
        ||
        ||  --- Decode (convert to ass. array)
        ||
        \/
        
    $denormalizedUser = [
        'id' => 1,
        'name' => 'eduard_f',
        'fullName' => 'Eduard F.'
    ];   
    
         ||
         ||  --- Denormalization (convert to obj.)
         ||
         \/
         
    class User {
        private $id;
        private $name;
        private $fullName;
    }       
```

#### Serialization groups
- These can be used to include/exclude certain entity properties from the serialization. Typically, 
there are 2 main categories, `read` (the serialized property will be present in the response) and `write`
  (the property will be hidden within the response).
- Docs.: https://api-platform.com/docs/core/serialization/#using-serialization-groups

#### Adding services
- After implementing a new service, it will be autowired and configured within the application by Symfony 
itself, example run `php bin/console debug:container PasswordHashSubscriber` to verify the service's properties.

#### Validation
- Symfony's validation component allows parameter validation on certain constraints.
- Import (with "Assert" alias):
```
use Symfony\Component\Validator\Constraints as Assert;
```
- Example usage:
```
     * @Assert\NotBlank()               --->    assert that the property is not blank in the request object
     * @Assert\Length(min=6, max=255)   --->    assert that the length is in [6,255]
     */
    private $username;
    
     * @Assert\NotBlank()
     * @Assert\Email()                  --->    assert that the property is a valid email address email@email.org
     */
    private $email;
```

#### Regex
- Need to be surrounded with "/".
Example:
```
(?=.*[A-Z])     (?=.*[a-z])     (?=.*[0-9])     .{7,}
    |               |               |             |_ match on an input/text length of [7,inf)  
    |               |               |_ match against numbers
    |               |_ match against lower case letters
    |_ match against upper case letters
```