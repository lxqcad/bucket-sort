<?php

/// This module is where the primary sorting operation is carried out. It asks the user the minimum number of questions in order to sort the array */
function printArray($arrayInput, $title="Congratulations! You have sorted the whole list!") /// Print the initial unsorted array into an HTML table and output the same
{
    if (count($arrayInput) > 0): ?>
    <form action="?page=home" method="post" >
        <div class="panel-heading">
            <h4 class="panel-title"><?php echo $title; ?></h4>
        </div>
        <div class="panel-body">
            <table>
              <thead>
                <tr>
                  <th>&nbsp;&nbsp;Index&nbsp;&nbsp;</th><th>&nbsp;&nbsp;Data&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;Urgency &nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;Importance &nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;Difficulty &nbsp;&nbsp;</th><th>&nbsp;&nbsp;Time Sort</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach ($arrayInput as $row): array_map('htmlentities', $row); ?>
                <tr>
                  <td><?php echo implode("</td><td style='text-align:right'>", $row); ?></td>
                </tr>
            <?php endforeach; ?>
              </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <input class="btn btn-md btn-success" type="submit" value="Home">
        </div>
    </form>
    <?php endif;    
}


function ReplaceArrayValueFromDB($iloc, $stage, $dataVal) /// Replace the value at specified stage and location in the database with the new value. The data is not exchanged
{
    global $user_id, $file_id;
    $stages = array("data_index", "urgency_rank", "importance_rank", "difficulty_rank", "time_sort");

    $dataVal = escapeString($dataVal);
    $strSQL = "UPDATE sort_data SET {$stages[$stage]} = $dataVal WHERE user_id = $user_id AND file_id = $file_id AND data_index=$iloc";
    $res = queryMysql($strSQL);
}

function GetiLocValueFromDB($stage, $dataVal, $pivot_value) /// Get the value of data at the specified location in the database 
{
    global $user_id, $file_id;
    $stages = array("data_index", "urgency_rank", "importance_rank", "difficulty_rank", "time_sort");
    $retVal = -1;
    if($stage > 1) {
        if($pivot_value > 100) {
            $t = intval($pivot_value / 100);
            $subQuery = " AND {$stages[1]} = $t";
            $t = intval($pivot_value / 10) % 10;
            $subQuery .= " AND {$stages[2]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[3]} = $t";
        }
        elseif($pivot_value > 10) {
            $t = intval($pivot_value / 10);
            $subQuery = " AND {$stages[1]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[2]} = $t";
        }
        else 
            $subQuery = " AND {$stages[1]} = $pivot_value";
    }
    else $subQuery = "";
    //echo $subQuery . "<br>";

    $strSQL = "SELECT data_index FROM sort_data WHERE user_id = $user_id AND file_id = $file_id $subQuery AND {$stages[$stage]} = $dataVal";
    $res = queryMysql($strSQL);
    if($Results = mysqli_fetch_array($res)) {
        $retVal = $Results["data_index"];
    }

    return $retVal;
}

function GetArrayValueFromDB($iloc) /// Get the value of data at the specified location in the database 
{
    global $user_id, $file_id;
    $retVal = 0;
    $strSQL = "SELECT data_value FROM sort_data WHERE user_id = $user_id AND file_id = $file_id AND data_index=$iloc";
    $res = queryMysql($strSQL);
    if($Results = mysqli_fetch_array($res)) {
        $retVal = $Results["data_value"];
    }
    else
        die("1.Database error: abort operation");
    return $retVal;
}

function GetArrayValuesFromDB($stage, $pivot_value) /// Get the value of data at the specified location in the database 
{
    global $user_id, $file_id;
    $stages = array("data_index", "urgency_rank", "importance_rank", "difficulty_rank", "time_sort");
    $retVal = array();

    if($stage > 1) {
        if($pivot_value > 100) {
            $t = intval($pivot_value / 100);
            $subQuery = " AND {$stages[1]} = $t";
            $t = intval($pivot_value / 10) % 10;
            $subQuery .= " AND {$stages[2]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[3]} = $t";
        }
        elseif($pivot_value > 10) {
            $t = intval($pivot_value / 10);
            $subQuery = " AND {$stages[1]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[2]} = $t";
        }
        else 
            $subQuery = " AND {$stages[1]} = $pivot_value";
    }
    else $subQuery = "";

    $i = 0;

    $strSQL = "SELECT data_index FROM sort_data WHERE user_id = $user_id AND file_id = $file_id $subQuery AND {$stages[$stage]}=0 order by data_index";
    $res = queryMysql($strSQL);
    while($Results = mysqli_fetch_array($res)) {
        $retVal[$i] = $Results["data_index"];
        //$retVal[$i][1] = $Results["data_value"];
        //$retVal[$i][2] = $Results[$stages[$stage]];
        $i++;
    }

    return $retVal;
}

function CheckStageCount($stage, $pivot_value)
{
    global $user_id, $file_id;
    $stages = array("data_index", "urgency_rank", "importance_rank", "difficulty_rank", "time_sort");
    $retVal = 0;
    
    if($stage > 1) {
        if($pivot_value > 100) {
            $t = intval($pivot_value / 100);
            $subQuery = " AND {$stages[1]} = $t";
            $t = intval($pivot_value / 10) % 10;
            $subQuery .= " AND {$stages[2]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[3]} = $t";
        }
        elseif($pivot_value > 10) {
            $t = intval($pivot_value / 10);
            $subQuery = " AND {$stages[1]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[2]} = $t";
        }
        else 
            $subQuery = " AND {$stages[1]} = $pivot_value";
    }
    else $subQuery = "";
    
    $strSQL = "SELECT count(data_index) as dc FROM sort_data WHERE user_id = $user_id AND file_id = $file_id $subQuery AND {$stages[$stage]} > 0";

    $res = queryMysql($strSQL);
    if($Results = mysqli_fetch_array($res)) {
        $retVal = $Results["dc"];
    }
    return $retVal;
}

function TotalStageCount($stage, $pivot_value)
{
    global $user_id, $file_id;
    $stages = array("data_index", "urgency_rank", "importance_rank", "difficulty_rank", "time_sort");
    $retVal = 0;
    if($stage > 1) {
        if($pivot_value > 100) {
            $t = intval($pivot_value / 100);
            $subQuery = " AND {$stages[1]} = $t";
            $t = intval($pivot_value / 10) % 10;
            $subQuery .= " AND {$stages[2]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[3]} = $t";
        }
        elseif($pivot_value > 10) {
            $t = intval($pivot_value / 10);
            $subQuery = " AND {$stages[1]} = $t";
            $t = $pivot_value % 10;
            $subQuery .= " AND {$stages[2]} = $t";
        }
        else 
            $subQuery = " AND {$stages[1]} = $pivot_value";
    }
    else $subQuery = "";

    $strSQL = "SELECT count(data_index) as dc FROM sort_data WHERE user_id = $user_id AND file_id = $file_id $subQuery AND {$stages[$stage]} = 0";

    $res = queryMysql($strSQL);
    if($Results = mysqli_fetch_array($res)) {
        $retVal = $Results["dc"];
    }
    return $retVal;
}

function ReadIntoArray() /// Read the final sorted data into an array ready to be displayed on screen
{
    global $user_id, $file_id;
    $resArray = array();
    $strSQL = "SELECT data_index, data_value, urgency_rank, importance_rank, difficulty_rank, time_sort FROM sort_data WHERE user_id = $user_id AND file_id = $file_id ORDER BY urgency_rank, importance_rank, difficulty_rank, time_sort, data_index";
    $res = queryMysql($strSQL);
    $i = 0;
    while($Results = mysqli_fetch_array($res)) {
        $resArray[$i][0] = $Results["data_index"]+1;
        $resArray[$i][1] = $Results["data_value"];
        $resArray[$i][2] = $Results["urgency_rank"];
        $resArray[$i][3] = $Results["importance_rank"];
        $resArray[$i][4] = $Results["difficulty_rank"];
        $resArray[$i][5] = $Results["time_sort"];
        $i++;
    }
    return $resArray;
}

function WriteArraytoCSV($arrayInput) /// Write the final sorted array into a CSV file ready for user download
{
    global $user_id, $file_id, $upload_dir;
    $header = array("Original Index", "Tasks", "Urgency", "Importance", "Difficulty", "Time Sort");
    $strSQL = "SELECT filename FROM file_details WHERE user_id=$user_id AND id=".$file_id;
    $res = queryMysql($strSQL);
    if($Results = mysqli_fetch_array($res)) {
        $filename = $Results["filename"];
        $filename = str_replace(".csv", "", $filename);
        $filename = $upload_dir.$filename.date("_m_d_Y")."_sorted.csv";

        $fp = fopen($filename, 'w');

        fputcsv($fp, $header);
        foreach ($arrayInput as $field_data) {
            fputcsv($fp, $field_data);
        }

        fclose($fp);
        return($filename);
    }
    else
        return "";
}
  
?>