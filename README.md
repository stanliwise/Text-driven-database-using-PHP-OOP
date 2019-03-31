# Text-driven-database-using-PHP-OOP

This code helps you  to make a simple database using .txt file and provide you will all necessary functionalities to create, modify a database

To make use of this simple file;
enusre your have .src folder in the same folder as Database.php
simply include 'Database.php' into your script;
Also ensure you create a valid .txt file in your script for data storage e.g 'database.txt';
To make use of this script after doing the above simply call the Database bundle

    $database = new Database('database.txt');

Notice that 'database.txt' was simply my own created text, ensure that it the correct directory for your database is correct.

1. To add new user

    $database->addUser('name', 'password', 'email');

2. To delete a user

    $database->removeUser('username');

    The code return true if succesful and returns false if unsuccesful

3. To check if a user is registered

    $user = $database->login('username', 'password');

4. To find a user (it can be done in three ways)

    $user = $database->getUserById(1); //this is if you know a user id

            or

    $user = $database->getUserByUsername('username'); //just provide the user details
            or

    $user = $database->getUserByEmail('email'); //provide email address

5. For 3 to 4, if retrieval was succesful the you can get user data from the variable

        $user->getId(); //returns a user id
        $user->getPassword(); //returns a user password
        $user->getEmail(); //returns a user email
        $user->getUsername(); //returns a user username;

        b. To change a user password

        $user->changePassword('new_password'); //changes the user password

For any questions whatApp me @ 08172833073