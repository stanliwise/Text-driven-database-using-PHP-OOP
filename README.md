# Text-driven-database-using-PHP-OOP

This code helps you  to make a simple database using .txt file and provide you will all necessary functionalities to create, modify a database

To make use of this simple PHP Functionalities;
enusre your have "src" folder
simply include 'src/DBFactory.php' into your script;
Also ensure you create a valid folder which would represent your Database Repo,
For example a folder 'StanDatabase' would represent the name of a database
To get the Database instance use the database facade

    ```php
    <?php
        $database = DBFactory::get('StanDatabase'); //Case is insensitive
    ```

**Note:** Set the complete path of directory from Config.php, default value is __DIR__ constant. This means your complete your path for DBFactory::get() will be __DIR__ . 'Passport'.
Alternative you set global path to where your database folder would be found.

Example:

    ```php
        //this set path to find your database folders
        DBFactory::set_gloabal_path($path_to_database_folder); 
    ```

    This means if you refer to your database e.g 'StanDatabase'
    It means your complete path would be 

    ```php
        $path_to_database_folder . '/StanDatabase'
    ```

# METHOD DATABASE OBJECT
1. To create new table in the database, use

    ```php
        $database->new_table('unique_table_name', $columns[], 'unique_column');
    ```

2. To delete a table from your database

    ```php
        $database->delete_table($table_name);
    ```

    The code return true if succesful and returns false if unsuccesful

3. To get a Table instance

    ```php
    $user = $database->get_table($table_name);
    ```

4. To see the current database folder/path
    ```php
        //this is if you know a user id
        $user = $database->getPath(); 
    ```

5. For 3 to 4, if retrieval was succesful the you can get user data from the variable

        ```php
            $user->getId(); //returns a user id
            $user->getPassword(); //returns a user password
            $user->getEmail(); //returns a user email
            $user->getUsername(); //returns a user username;
        ```

        b. To change a user password

        $user->changePassword('new_password'); //changes the user password

For any questions whatApp me @ 08172833073