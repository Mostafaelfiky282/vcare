<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1 class="col text-center bg-success p-2">Upload File Using PHP</h1>
    <div class="container">
        <div class="row">
            <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" class="col-sm-5">
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <hr>
                </div>

                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </form>
            <div class="col-sm-6">

                <?php
                $error = '';
                $success = '';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $file = $_FILES['image'];
                    $f_name = $file['name'];
                    $f_type = $file['type'];
                    $f_temp = $file['tmp_name'];
                    $f_error = $file['error'];
                    $f_size = $file['size'];

                    if ($f_name != '') {
                        $ext = pathinfo($f_name);
                        $originalname = $ext['filename'];
                        $extension = $ext['extension'];
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
                        if (in_array($extension, $allowed)) {
                            if ($f_error === 0) {
                                if ($f_size < 500000) {
                                    $new_name = "image" . rand(0,1000) . "." . $extension;
                                    $destination = 'uploads/' . $new_name;
                                    move_uploaded_file($f_temp, $destination);
                                    $success = "Image Uploaded Successfully";
                                } else {
                                    $error = "Your File is Too Large";
                                }
                            } else {
                                $error = "You Have an Error";
                            }
                        } else {
                            $error = "Invalid File Format";
                        }
                    } else {
                        $error = "Please Choose Image";
                    }
                }

                ?>

                <?php if ($error != ''): ?>
                    <h4 class="alert alert-danger col text-center">
                        <?= $error ?>
                    </h4>
                <?php endif; ?>
                <?php if ($success != ''): ?>
                    <h4 class="alert alert-success col text-center">
                        <?= $success ?>
                    </h4>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>