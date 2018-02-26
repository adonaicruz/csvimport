<?php
ignore_user_abort(1);
set_time_limit(0);
require '../src/CsvImport.php';
if ($_FILES && $_FILES['csvfile']):
    $csvImport = new CsvImport($_FILES['csvfile']);
    $csvImport->setOutput();
    while ( ($data = $csvImport->getRow()) !== FALSE ) :
        print_r($data);exit;
        $csvImport->output($data);
    endwhile;
endif;
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvfile">
    <button type="submit">ENVIAR</button>
</form>