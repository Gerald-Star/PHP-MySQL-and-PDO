<?php 

require 'db.php';
# Transactions allow you to execute multiple queries as a single unit of work. If any of the queries fail, you can roll back the entire transaction, ensuring that your database remains in a consistent state.
# In this example, we start a transaction, execute three insert statements, and then commit the transaction. If any of the insert statements fail, we catch the exception and roll back the transaction.
# Note: Make sure to handle exceptions properly in a real application, and consider using prepared statements for better security and performance.
# Also, ensure that your database supports transactions (e.g., InnoDB for MySQL).
# For more complex scenarios, you might want to use savepoints to allow partial rollbacks within a transaction.
# Transactions are particularly useful in scenarios where you need to maintain data integrity across multiple related operations, such as transferring funds between bank accounts or processing an order with multiple items.
# Always remember to commit your transactions to save the changes, or roll back if something goes wrong to prevent data corruption.
# In this example, we are inserting three blog posts into the 'blogposts' table. If any of the insert operations fail, the transaction will be rolled back, and none of the posts will be added to the database.
# You can test this by intentionally causing an error in one of the insert statements (e.g., by misspelling a column name) and observing that none of the posts are inserted.
# Note: Make sure to replace the database connection details in 'db.php' with your actual database credentials.
# For more information on transactions, you can refer to the official PHP documentation: https://www.php.net/manual/en/pdo.transactions.php
# In a real application, you would typically have error handling and logging in place to manage exceptions effectively.
# Additionally, consider using prepared statements within transactions for better security and performance, especially when dealing with user input.
# Always ensure that you have proper error handling in place when working with transactions to avoid leaving your database in an inconsistent state.
# In summary, transactions are a powerful tool for managing complex database operations and ensuring data integrity. Use them wisely to maintain the consistency of your database.
# Use transactions to group multiple queries together, and remember to commit or roll back as needed to maintain data integrity.
# Use cases for transactions include financial operations, order processing, and any scenario where multiple related database changes need to be treated as a single unit of work.
# Always test your transactions thoroughly to ensure they behave as expected, especially in error scenarios.
# In this example, we are inserting three blog posts into the 'blogposts' table. If any of the insert operations fail, the transaction will be rolled back, and none of the posts will be added to the database.
# Use cases more complex than this might involve multiple tables and more intricate logic, but the principles of transactions remain the same: group related operations together and ensure that they either all succeed or all fail together.   
# Is it mandatory to use transactions for every database operation? No, transactions are not mandatory for every database operation. They are particularly useful when you have multiple related operations that need to be treated as a single unit of work, such as inserting data into multiple tables or performing complex updates. For simple operations that involve a single query, transactions may not be necessary. However, using transactions can help ensure data integrity and consistency, especially in scenarios where there is a possibility of failure or when multiple users are accessing the database concurrently. It's important to evaluate the specific requirements of your application and use transactions where they provide value in maintaining the integrity of your data.
# Is it mandatory to use ATTRIBUTE MODE in transactions? No, it is not mandatory to use ATTRIBUTE MODE in transactions. ATTRIBUTE MODE is a feature of some database systems that allows you to specify how the database should handle certain attributes during a transaction.
# However, it is not a requirement for using transactions. You can use transactions without specifying ATTRIBUTE MODE, and the behavior of the transaction will depend on the default settings of your database system. 
#It's important to consult your database documentation to understand how transactions work and whether ATTRIBUTE MODE is relevant for your specific use case.


$pdo->beginTransaction(); # Start a new transaction

try {

  $pdo->exec("INSERT INTO blogposts(title, body) VALUES('First post', 'This is the body of the first post')");
  $pdo->exec("INSERT INTO blogposts(title, body) VALUES('Second post', 'This is the body of the second post')");
  $pdo->exec("INSERT INTO blogposts(title, body) VALUES('Third post', 'This is the body of the third post')");

  $pdo->commit(); # Commit the transaction if all queries were successful

} catch (Exception $e) {
  $pdo->rollBack(); # Roll back the transaction if any query failed
  echo "Failed: " . $e->getMessage(); # Display the error message
}








?>