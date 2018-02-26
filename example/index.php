<?php
ignore_user_abort(1);
set_time_limit(0);
require '../src/CsvImport.php';
if ($_FILES && $_FILES['csvfile']):
    $csvImport = new CsvImport($_FILES['csvfile']);
    $csvImport->setOutput('tmp.csv');
    $row = array('','','','');
    $i=0;
    while ( ($data = $csvImport->getRow()) !== FALSE ) :
        
        if(empty($data[0])) :
            $csvImport->output($row);
            $row = array('','','','');
        else:
            if (preg_match('/(?<=PREFEITO|VICE PREFEITO|PREFEITA|VICE PREFEITA|PREFEITURA) - ((.*)(?= End)|(.*))/', $data[0], $matches)):
                if(empty($row[0])) :
                    $row[0] = $matches[1];
                else:
                    $row = array('','','','');
                    $row[0] = $matches[1];
                endif;
            endif;
            if (preg_match('/(End. Comercial:)( *)?(.*)/', $data[0], $matches)):
                $row[1] = $matches[3];
            endif;
            if (preg_match('/\([0-9]{2}\)[ ]?[0-9]{4}[-|.| ]?[0-9]{4}/', $data[0], $matches)):
                $row[2] = implode(', ',$matches);
            endif;
            if (preg_match('/(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))/', $data[0], $matches)):
                $row[3] = implode(', ',$matches);
            endif;
        endif;
        $i++;
    endwhile;
endif;
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvfile">
    <button type="submit">ENVIAR</button>
</form>