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
