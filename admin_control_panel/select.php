<script>
    $(function() {
        $('select[name="form_subcategory"]').change(function() {
            alert($('select[name="form_subcategory"]').val());
        });
    });
</script>

<?php
if (isset($_POST['id']) && !empty($_POST['id'])) {

    include("../../pages/db_connect.php");

    $query = mysqli_query($link, "SELECT * FROM subcategory WHERE category_id = '{$_POST["id"]}'");
    echo "<select name='form_subcategory'>";
    while ($row =$query->fetch()) {
        echo '<option value="($row->id)">($row->title) <option/>';
    }
    echo '</select>';
} else {
    echo "<select name='form_subcategory' disabled><option value='0'>Выберите подкатегорию товара</option></select>";
}
