<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row">

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_FILES['user_image'])) {
		$file_name = $_FILES['user_image']['name'];
      	$file_size = $_FILES['user_image']['size'];
      	$file_tmp = $_FILES['user_image']['tmp_name'];
      	$file_type = $_FILES['user_image']['type'];
        $error = $_FILES['image']['error'];
      	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      	if (($file_ext == 'jpg' || $file_ext == 'png') && $file_size < 500000) {
      		$file_new_name = generate_file_name(30) . '.' . $file_ext;
      		$upload_path = 'uploads/' . $file_new_name;
      		// move_uploaded_file($file_tmp, $upload_path);
      		compress($_FILES['user_image'], $upload_path);

      		if (file_exists($upload_path)) {
	      		echo '<div class="col-12">
					<div class="alert alert-success">Uploaded</div>
				</div>';	
      		} else {
	      		echo '<div class="col-12">
					<div class="alert alert-danger">Failed</div>
				</div>';	
      		}
      	} else {
      		$file_new_name = generate_file_name(30) . '.' . $file_ext;
      		$upload_path = 'uploads/' . $file_new_name;
      		move_uploaded_file($file_tmp, $upload_path);

      		if (file_exists($upload_path)) {
	      		echo '<div class="col-12">
					<div class="alert alert-success">Uploaded</div>
				</div>';	
      		} else {
	      		echo '<div class="col-12">
					<div class="alert alert-danger">Failed</div>
				</div>';	
      		}	
      	}
	}
}


function generate_file_name ($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}


function compress($source_image, $compress_image_path) {

    $image_info = getimagesize($source_image['tmp_name']);
    $width = $image_info[0];
    $height = $image_info[1];
    if ($image_info['mime'] == 'image/jpeg') {
        $source = imagecreatefromjpeg($source_image['tmp_name']);
        imagejpeg($source, $compress_image_path, 75);
    } else if ($image_info['mime'] == 'image/gif') {
        $source = imagecreatefromgif($source_image['tmp_name']);
        imagegif($source, $compress_image_path, 75);
    } else if ($image_info['mime'] == 'image/png') {
        $source = imagecreatefrompng($source_image['tmp_name']);
        if(!check_transparent($source)){
            imagejpeg($source, $compress_image_path, 75);
        } else {
            move_uploaded_file($source_image['tmp_name'], $compress_image_path);
        }
    }
}


function check_transparent($im) {

    $width = imagesx($im); // Get the width of the image
    $height = imagesy($im); // Get the height of the image

    // We run the image pixel by pixel and as soon as we find a transparent pixel we stop and return true.
    for($i = 0; $i < $width; $i++) {
        for($j = 0; $j < $height; $j++) {
            $rgba = imagecolorat($im, $i, $j);
            if(($rgba & 0x7F000000) >> 24) {
                return true;
            }
        }
    }

    // If we dont find any pixel the function will return false.
    return false;
}
?>

			<div class="col-12">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="user-image">User Image</label>
						<input type="file" name="user_image" class="form-control" id="user-image">
					</div>

					<button type="submit" class="btn btn-primary">Upload</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>