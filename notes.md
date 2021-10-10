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
- Sometimes for new changes to take place, it is necessary to clear the development cache,
  run `php bin/console cache:clear`.

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
- There property `normalizationContext` allows for custom serialization/deserialization
  contexts (https://api-platform.com/docs/core/serialization/). If no serialization/deserialization
  group (https://api-platform.com/docs/core/serialization/#using-serialization-groups) is provided, the "default" group
  is used.
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

- These can be used to include/exclude certain entity properties from the serialization. Typically, there are 2 main
  categories, `read` (the serialized property will be present in the response) and `write`
  (the property will be hidden within the response).
- Docs.: https://api-platform.com/docs/core/serialization/#using-serialization-groups

#### Adding services

- After implementing a new service, it will be autowired and configured within the application by Symfony itself,
  example run `php bin/console debug:container PasswordHashSubscriber` to verify the service's properties.

### Validation

- Symfony's validation component allows parameter validation on certain constraints.
- Flow : API Platform --> deserialize data --> call the validator component for validation on the data.
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

- Need to be surrounded with "/". Example:

```
(?=.*[A-Z])     (?=.*[a-z])     (?=.*[0-9])     .{7,}
    |               |               |             |_ match on an input/text length of [7,inf)  
    |               |               |_ match against numbers
    |               |_ match against lower case letters
    |_ match against upper case letters
```

#### Uniqueness of fields

- Can be specified as combinations (set) of fields that have to be unique by
  adding `@UniqueEntity(fields={"field1", "field2", "fieldN"})`. With this strategy, the set will be validated (checked)
  against existing records for uniqueness, however if one of the fields is duplicate it will not matter as the entire
  set is evaluated as a whole rather than individual fields.
- Or as individual fields by adding several statements of the form `@UniqueEntity("field1")`, `@UniqueEntity("field2")`
  , `@UniqueEntity("fieldN")`. With this strategy, each field will be validated (checked) against existing records for
  uniqueness.
- The latter is preferred.

#### JWT Tokens (Authentication)

- Resources: 
- https://www.vaadata.com/blog/jwt-tokens-and-security-working-principles-and-use-cases/
- https://jwt.io/introduction
- The user (via the client) sends his credentials and then receives an authentication token (given the credentials are
  valid).
- The authentication token is generated automatically as JSON (server).
- Any subsequent request (client) will include in its headers the JWT and if the JWT is valid, access is granted.
- Tokens are not encrypted, just encoded (can be read/modified by 3rd parties).
- 3rd parties cannot sign the token without the public/private key pair.
- Inside the payload of a JWT the following can be added (safely):
    * user identifier
    * token expiration date
    * token issue date
- What should be excluded (unsafe):
    * user personal data (email, etc...)
    * credit card numbers
    * user passwords

- Structure (Anatomy of a JWT):
```
JWT Token
    |------->   Header
    |           {
    |            "alg": "H256",
    |            "typ": "JWT         
    |           }
    |
    |------->   Payload
                {
                  "sub":"1234567890",
                  "name":"Karl Doe",
                  "iat": 1516239022
                }
```

- The signature is done on the Header object as a Public/Private Key pair.

```
|-----------|               
| Signature | ==========> |---------|
|-----------|             | Header  |
Public/Private            |---------|
  Key pair                | Payload |
                          |---------|
```

<table style="border-style: solid; width: fit-content">
    <thead>
        <th>Base64Url(Header)</th>
        <th>Base64Url(Payload)</th>
    </thead>
    <tbody>
        <tr>
            <td>Base64Url(Header)</td>
            <td>Base64Url(Payload)</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">Signature</td>
        </tr>
        <tr>
            <td>Example:</td>
            <td><a href="https://jwt.io/introduction">See the section "Putting all together"</a></td>
        </tr>
    </tbody>
</table>

- Installation of lexik (library for JWT generation):
```
composer require lexik/jwt-authentication-bundle # might require check after initial installation
```
- If not installed, OpenSSL can be installed by following the instructions specified in
<a href="https://medium.com/swlh/installing-openssl-on-windows-10-and-updating-path-80992e26f6a1">this installation guide.</a> 
- Once installed, OpenSSL can be used to generate a private key:
```
openssl genrsa -out config/jwt/private.pem -aes256 4096 
```
- The output (private key) will be found in `config/jwt/private.pem`, the encryption uses the <a href="https://www.n-able.com/blog/aes-256-encryption-algorithm">AES-256 encryption algorithm.</a>
- From the private key, using the <a href="https://www.educative.io/edpresso/what-is-the-rsa-algorithm">RSA algorithm</a>, the public key is generated using
`openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem` (the output, public key will be found in config/jwt/public.pem).
