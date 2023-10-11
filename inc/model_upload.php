<?php  

function printArray($arrayInput) /// Print the unsorted array that was extracted from the user uploaded CSV file
{
    if (count($arrayInput) > 0): ?>
    <form action="?page=sort" method="post" >
        <div class="panel-heading">
            <h4 class="panel-title">Quick Sort</h4>
        </div>
        <div class="panel-body">
            <table>
              <thead>
                <tr>
                  <th>Data</th><th>Urgency</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach ($arrayInput as $row): array_map('htmlentities', $row); ?>
                <tr>
                  <td><?php echo $row[0]; ?> </td>
                </tr>
            <?php endforeach; ?>
              </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <input class="btn btn-md btn-success" type="submit" value="Start Sorting">
        </div>
    </form>
    <?php endif;    
}

if (isset($_FILES["myfile"])) { /// Get the uploaded file
    if ($_FILES["myfile"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } 
    else {
        $filename = $_FILES["myfile"]["name"];
        $xlsFilename = $upload_dir.$user_id."_".$filename;
        if(file_exists($xlsFilename)) unlink($xlsFilename);
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $xlsFilename);

        $file = fopen($xlsFilename,"r");

        $hdrArray = fgetcsv($file);
        $highestColumnIndex = count($hdrArray);
        if($highestColumnIndex != 2) { /// Check for the correct number of columns in the CSV file 
            fclose($file);
            unlink($xlsFilename);
            die("Incorrect number of columns in the CSV file uploaded.");
        }

        $strSQL = "INSERT INTO file_details (user_id, filename, variable_i, variable_j, variable_total, variable_option, var_stage, prev_stage_pivot, pivot_value, pivot_index1, ".
                "pivot_index2, pivot_index3) VALUES ($user_id, '$filename', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
        $res = queryMysql($strSQL);
        $_SESSION['fileid'] = $file_id = lastInsertID();
        $resArray = array(); $skipped = 0;
        $insertValues = "";
        $first = true;
        $count = 0;
        while (($data = fgetcsv($file, 2048)) !== FALSE) { /// Read the CSV file one line at a time
            $highestColumnIndex = count($data);
            if($highestColumnIndex <> 2)
                $skipped++;
            else {
                if($first) $first = false;
                else $insertValues .= ",";
                $resArray[] = $data;
                $insertValues .= "($user_id, $file_id, '".escapeString($data[0])."',".$count.")"; 
                $count++;
            }
        }

        fclose($file);
        unlink($xlsFilename);
        printArray($resArray);
        /// Store the data retrieved from the CSV file into the database for the current user
        $insertValues = "INSERT INTO sort_data (user_id, file_id, data_value, data_index) VALUES ".$insertValues;
        $res = queryMysql($insertValues);
    }
    
}
else { /// Display the file upload form to the user 
?>
    <div class='alert alert-info'>Download sample CSV header format here <strong><a href="upload/sampledata.csv"><i class="fa fa-download"></i>&nbsp;Click Here</a></strong></div>
    <div class="panel panel-info">
    <form action="?page=upload" method="post" enctype="multipart/form-data">
        <div class="panel-heading">
            <h4 class="panel-title">Select CSV File for Quick Sort</h4>
        </div>
        <div class="panel-body">
            <div class="form-group input-group">
            File:<input type="file" class="form-control" accept="text/csv" name="myfile">
            </div>
        </div>
        <div class="panel-footer">
            <input class="btn btn-md btn-success" type="submit" value="Upload">
            <a class="btn btn-md btn-primary" href="?page=list">Finish a Sort</a>
        </div>
    </form>
    </div>

<?php  
}
?>
