Top:
// Logo upload
if (isset($_FILES['logo']['name']) 
    && $_FILES['logo']['error'] === UPLOAD_ERR_OK
    && getimagesize($_FILES['logo']['tmp_name']) !== false
    && in_array($_FILES['logo']['type'], ["image/jpeg", "image/gif", "image/png"])
) {
    $filedata = pathinfo(basename($_FILES["logo"]["name"]));
    $filename = time() . '_' . createSlug($filedata['filename']) . '.' . strtolower($filedata['extension']);
    $filepath = $GLOBALS['anwendungsverzeichnis'].'files/' . $filename;
    if (move_uploaded_file($_FILES['logo']["tmp_name"], $filepath)) {
        $file = new files();
        $file->mimetype = $_FILES['logo']['type'];
        $file->name = $filename;
        $file->size = $_FILES['logo']['size'];
        $file->save();
        $file_id = $file->get_id(); // Logo ID
    }
}


<strong>Bild</strong><br>
<?php 
$file = new files(123);
if ($file->get_id() > 0 && $file->fileExists()) {
    echo '<img src="'.$GLOBALS['ROOT_DIR'].'/'.$file->getURL().'" alt=""><br>';
    echo '<input type="submit" name="delete_image" value="Bild löschen" onclick="return confirm(\'Bitte bestätigen Sie die Löschung!\');" />';
}
else {
    echo '<img id="fileinput_preview" src="#" alt="" />';
    echo '<input id="fileinput" type="file" name="logo" accept="image/*">';
?>

<script>
// Input-type-file Vorschau
$("#fileinput").change(function readURL() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#fileinput_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
