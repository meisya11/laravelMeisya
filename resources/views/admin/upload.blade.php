<!DOCTYPE html>
<html>
<head>
    <title>Upload Foto</title>
</head>
<body>

<h2>Pilih Foto</h2>

<form action="/upload" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="photo" accept="image/*">
    <br>
    <button type="submit">Upload Foto</button>
</form>

</body>
</html>
