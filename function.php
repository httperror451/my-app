<?php
function get_total_all_records()
{
    include("database.php");
    $statement = $connection-> prepare ("SELECT * FROM users");
    $statement-> execute();
    return $statement->rowCount();

}

function upload_image()
{
    $extension = explode(".", $_FILES['user_image']['name']);
    $new_name = rand() . "." . $extension[1];
    $destination = './upload/' . $new_name;
    move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
    return $new_name;
}


?>