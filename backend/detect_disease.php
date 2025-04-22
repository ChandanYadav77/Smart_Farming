<?php
if ($_FILES['crop_image']) {
    $file_name = $_FILES['crop_image']['tmp_name'];
    $output = shell_exec("python python/detect_disease.py $file_name");
    echo json_encode(["disease" => $output]);
}
?>
