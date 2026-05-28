# What is PDO

# what is PDO?
# PDO stands for PHP Data Objects. It is a database access layer that provides a uniform method of access
# to multiple databases. PDO provides a data-access abstraction layer, which means that, regardless of which database
you're using, you use the same functions to issue queries and fetch data. This makes it easier to write
database-agnostic code and switch between different databases without having to rewrite your code.
# PDO provides a consistent interface for accessing databases, and it supports a wide range of databases, including
MySQL, PostgreSQL, SQLite, and more. It also provides features such as prepared statements, which can help prevent SQL
injection attacks and improve performance.

# Why use PDO?
# There are several reasons why you might want to use PDO in your PHP applications:
# 1. Database Abstraction: PDO provides a consistent interface for accessing different databases, which makes it easier
to switch between databases without having to rewrite your code.
# 2. Prepared Statements: PDO supports prepared statements, which can help prevent SQL injection attacks and improve
performance by allowing the database to optimize the query execution plan.
# 3. Error Handling: PDO provides a robust error handling mechanism that allows you to catch and handle database errors
gracefully.
# 4. Object-Oriented Interface: PDO provides an object-oriented interface for working with databases, which can make
your code more organized and easier to read.
# 5. Support for Multiple Databases: PDO supports a wide range of databases, including MySQL, PostgreSQL, SQLite, and
more, which makes it a versatile choice for database access in PHP applications.

# PDO Main Classes and Methods
# The main class in PDO is the PDO class itself, which represents a connection to a database
# The PDO class provides several methods for working with databases, including:
# - query(): Executes an SQL statement and returns a result set as a PDOStatement object.
# - prepare(): Prepares an SQL statement for execution and returns a PDOStatement object.
# - execute(): Executes a prepared statement.
# - fetch(): Fetches the next row from a result set.
# - fetchAll(): Fetches all rows from a result set.


# How to use PDO?
# To use PDO, you need to create a new PDO instance and provide the necessary connection parameters,
# such as the database type, host, database name, username, and password.
# Here's an example of how to create a PDO instance and connect to a MySQL database:




# In this example, we create a new PDO instance by providing the DSN (Data Source Name), username, and password.
# We also set the error mode to exception to handle any connection errors gracefully.
#If the connection is successful, we print a success message; otherwise,
# we catch the exception and print an error message.
# Once you have a PDO instance, you can use it to execute SQL queries and fetch data from the database.
# For example, to fetch all rows from a table called "users",
#you can do the following:

# In this example, we execute a SQL query to select all rows from the "users" table. We then use a while loop to fetch each row as an associative array and print the username field.


<?php 
$host = "localhost";
$db = "db_blogpost";
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
  $pdo = new PDO ($dsn, $username, $password);
  //set the PDO error mode to exception

}catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
  
}

?>


## Exercise

Explicit column selection

Instead of:

SELECT *

You now use:

SELECT id, title

This:

improves performance
avoids undefined column issues
makes debugging easier

### Option A: store results in array (MVC-style)

$blogposts = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $blogposts[] = $row;
}

### Option B: use fetchAll (still valid)

$stmt = $pdo->prepare("SELECT id, title FROM blogposts");
$stmt->execute();
$blogposts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($blogposts as $post) {
    echo $post['id'] . " - " . $post['title'] . "<br>";
}


### Separate data access layer (Repository pattern)


### 1 Professional Best Practice (important)

In real production code, the most professional version is actually neither raw form, but:

1. Avoid SELECT *

Use explicit columns:

Instead of calling PDO directly in business logic.

SELECT id, title, created_at FROM blogposts


##  1. Choose fetch strategy based on use-case:
API → fetchAll()
Large processing → fetch() loop


| Situation                        | Best choice    |
| -------------------------------- | -------------- |
| API response / small dataset     | `fetchAll()`   |
| Large table / streaming          | `fetch()` loop |
| Unknown size but potentially big | `fetch()` loop |



### 2. Domain Model (Optional but professional)

This represents a blog post as an object instead of raw arrays.

class BlogPost
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public string $createdAt
    ) {}
}



## Best practice (what real projects do)

They move this into a config file:

<?php
return [
    'host' => 'localhost',
    'db'   => 'testdb',
    'user' => 'root',
    'pass' => ''
];

## 

$config = require 'config.php';

$pdo = new PDO(
    "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4",
    $config['user'],
    $config['pass']
);


1. First: confirm you actually got data

Right after fetching, add this:

var_dump($blogposts);


You must loop through it:
foreach ($blogposts as $post) {
    echo $post['id'] . " - " . $post['title'] . "<br>";
}



# 4. Enable PHP error reporting (very important)

## Put this at the top of your file:
### Force error visibility (very important)

Put this at the VERY TOP of the file:

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


## 6. Safe debugging version (recommended)

Use this to pinpoint the issue:

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=testdb;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM blogposts");
    $blogposts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    var_dump($blogposts);
    echo "</pre>";

    foreach ($blogposts as $post) {
        echo $post['id'] . " - " . $post['title'] . "<br>";
    }

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>

###

<?php

#prepared.php
# INSERT using prepared statements
# This file demonstrates how to use PDO to prepare and execute an SQL statement with parameters.
# It also shows how to separate configuration into a separate file for better maintainability and security.

require 'db.php';

$title = 'My First Post';
$body  = 'This is the blog content.';

$sql = "INSERT INTO blogposts (title, body) 
        VALUES (:title, :body)";
        #$sql = "INSERT INTO blogposts VALUES ('$title', '$body')"; never do this because it is vulnerable to SQL injection.


# You can also use positional placeholders:
#$sql = "INSERT INTO blogposts (title, body)
       # VALUES (?, ?)"; using positional operator

#$stmt = $pdo->prepare($sql);
#$stmt->execute([$title, $body]);


$stmt = $pdo->prepare($sql);

$result =$stmt->execute([
    ':title' => $title,   ($title,)
    ':body'  => $body     ($body)  these both are PO
]);

var_dump($result);

echo '<br>';

echo $pdo->lastInsertId();

echo "Post created successfully.";#



### db.php

<?php

$config = require 'config.php';

$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";

try {

    $pdo = new PDO(
        $dsn,
        $config['user'],
        $config['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    die('Database connection failed: ' . $e->getMessage());
}