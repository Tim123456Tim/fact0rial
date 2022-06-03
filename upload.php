<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		switch ($_FILES['userfile']['error']) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				throw new RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new RuntimeException('Exceeded filesize limit.');
			default:
				throw new RuntimeException('Unknown errors.');
		}

		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$ext = array_search(
			$finfo->file($_FILES['userfile']['tmp_name']),
			array(
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
			), true
		);
		if ($ext == Null) {
			throw new RuntimeException('Invalid file format.');
		}

		// You should name it uniquely.
		// DO NOT USE $_FILES['userfile']['name'] WITHOUT ANY VALIDATION !!
		// On this example, obtain safe unique name from its binary data.
		if (!move_uploaded_file(
			$_FILES['userfile']['tmp_name'],
			sprintf('/var/www/html/data/images/%s.%s',
				sha1_file($_FILES['userfile']['tmp_name']),
				$ext
			)
		)) {
			throw new RuntimeException('Failed to move uploaded file.');
		}

		echo 'File is uploaded successfully.';

	} catch (RuntimeException $e) {
		echo $e->getMessage();
	}
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h3>Hello</h3>

	<form enctype="multipart/form-data" action="/upload.php" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		Отправить этот файл: <input name="userfile" type="file" />
		<input type="submit" value="Отправить файл" />
	</form>
</body>
</html>