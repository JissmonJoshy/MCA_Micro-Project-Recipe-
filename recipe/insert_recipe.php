<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_POST['title']) && isset($_POST['description'])) {
        $user_id = $_SESSION['user_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Include your database connection

        $db_host = 'localhost';
        $db_name = 'recipe';
        $db_user = 'root';
        $db_pass = '';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }



        // Insert data into the recipes table
        try {
            $stmt = $pdo->prepare("INSERT INTO recipes (title, description, user_id) VALUES (:title, :description, :user_id)");

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            header("Location: addRecipe.html?success=true");
            exit();
        } catch (PDOException $e) {
            // Redirect back to addRecipe.html with error parameter
            header("Location: addRecipe.html?success=false");
            exit();
        }

          /*  echo "Recipe added successfully!";

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    } else {
        echo "Incomplete data provided.";
    }*/
}
}
 ?>
