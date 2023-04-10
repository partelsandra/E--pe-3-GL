<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include_once 'database.php';

if (isset($_POST['save'])) {
    $Haaletaja_Eesnimi = $_POST['Haaletaja_Eesnimi'];
    $Haaletaja_Perenimi = $_POST['Haaletaja_Perenimi'];
    $Otsus = $_POST['Otsus'];

    $query = "SELECT MIN(H_lopu_aeg) AS min_time FROM LOGI";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $min_time = $row['min_time'];
    
    $query = "SELECT COUNT(*) AS count FROM HAALETUS WHERE Haaletaja_Eesnimi='$Haaletaja_Eesnimi' AND Haaletaja_Perenimi='$Haaletaja_Perenimi'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];
    
    if (time() < strtotime($min_time) && $count == 0) {
        $query = "INSERT INTO HAALETUS(Haaletaja_Eesnimi, Haaletaja_Perenimi, Haaletuse_aeg, Otsus) VALUES ('$Haaletaja_Eesnimi','$Haaletaja_Perenimi',NOW(),'$Otsus')";
        if (mysqli_query($conn, $query)) {
            echo "New record created successfully!";
        } else {
            echo "Error: " . $query . " " . mysqli_error($conn);
        }
    } elseif (time() < strtotime($min_time) && $count > 0) {
        $query = "UPDATE HAALETUS SET Haaletuse_aeg=NOW(), Otsus='$Otsus' WHERE Haaletaja_Eesnimi='$Haaletaja_Eesnimi' AND Haaletaja_Perenimi='$Haaletaja_Perenimi'";
        if (mysqli_query($conn, $query)) {
            echo "Record updated successfully!";
        } else {
            echo "Error: " . $query . " " . mysqli_error($conn);
        }
    } else {
        echo "Voting is no longer open!";
    }
}

mysqli_close($conn);
?>
<button onclick="window.location.href='https://steinbergkarina.ikt.khk.ee/veebiarendus/haaletus/'">Tagasi pealehele</button>
</body>
</html>
