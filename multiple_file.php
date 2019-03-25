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
        // var_dump($_FILES['user_image']); die();
		for($i=0 ; $i < count($_FILES['user_image']['name']) ; $i++) {
            $file_name = $_FILES['user_image']['name'][$i];
            $file_size = $_FILES['user_image']['size'][$i];
            $file_tmp = $_FILES['user_image']['tmp_name'][$i];
            $file_type = $_FILES['user_image']['type'][$i];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

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
?>

			<div class="col-12">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="user-image">User Image</label>
						<input type="file" name="user_image[]" class="form-control" id="user-image" multiple>
					</div>

					<button type="submit" class="btn btn-primary">Upload</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>