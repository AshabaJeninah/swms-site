<?php
include('connect.php');
if(isset($_GET['bin_id']) && isset($_GET['level'])) {
    $id = mysqli_real_escape_string($conn, $_GET['bin_id']);
    $level = (int)$_GET['level']; 
    
    $status = 'OK';
    if ($level >= 90) {
        $status = 'Critical';
    } elseif ($level >= 70) {
        $status = 'Warning';
    }

    $sql = "UPDATE bins SET 
            current_fill_level = '$level', 
            status = '$status', 
            last_updated = NOW() 
            WHERE bin_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Success: Bin #$id updated to $level%";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

} else {
    echo "Error: Missing parameters. Usage: update_bin.php?bin_id=1&level=50";
}
?>