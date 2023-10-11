<?php  
include "inc/functions.php";

$bool_sort_complete = false;
$prev_stag_array = array(
                    array(1, 2, 3),
                    array(11,12,13,21,22,23,31,32,33),
                    array(111,112,113,121,122,123,131,132,133,211,212,213,221,222,223,231,232,233,311,312,313,321,322,323,331,332,333)
                    );
$names_of_stages = array(1=> "more urgent", 2=> "more important", 3=> "less difficult", 4=> "less time consuming");

if(isset($_POST["saveforlater"])) { /// If user decides to continue later, save the current data into the database to be retrieved later
        $variable_i = sanitizeString($_POST["variable_i"]);
        $variable_j = sanitizeString($_POST["variable_j"]);
        $var_stage = sanitizeString($_POST["var_stage"]);
        $variable_total = sanitizeString($_POST["variable_total"]);
        $var_option = isset($_POST["option"]) ? sanitizeString($_POST["option"]) : 0;
        $prev_stage_pivot = sanitizeString($_POST["prev_stage_pivot"]);
        $pivot_value = sanitizeString($_POST["pivot_value"]);
        $pivot_index1 = sanitizeString($_POST["pivot_index1"]);
        $pivot_index2 = sanitizeString($_POST["pivot_index2"]);
        $pivot_index3 = sanitizeString($_POST["pivot_index3"]);

    $strSQL = "UPDATE file_details SET variable_i=$variable_i, variable_j=$variable_j, var_stage=$var_stage, variable_total=$variable_total, variable_option=$var_option, ".
            " prev_stage_pivot=$prev_stage_pivot, pivot_value=$pivot_value, pivot_index1=$pivot_index1, pivot_index2=$pivot_index2, pivot_index3=$pivot_index3, saved=1 WHERE user_id=$user_id AND id=".$file_id;
    $res = queryMysql($strSQL);
    require_once "inc/model_list.php";
    destroySession();
}
else {
    if(isset($_POST["sortinginprogress"]) or isset($_POST["option"])) {  /// Get the current values of sorting variables from the POST data
        $variable_i = sanitizeString($_POST["variable_i"]);
        $variable_j = sanitizeString($_POST["variable_j"]);
        $var_stage = sanitizeString($_POST["var_stage"]);
        $variable_total = sanitizeString($_POST["variable_total"]);
        $var_option = sanitizeString($_POST["option"]);
        $prev_stage_pivot = sanitizeString($_POST["prev_stage_pivot"]);
        $pivot_value = sanitizeString($_POST["pivot_value"]);
        $pivot_index1 = sanitizeString($_POST["pivot_index1"]);
        $pivot_index2 = sanitizeString($_POST["pivot_index2"]);
        $pivot_index3 = sanitizeString($_POST["pivot_index3"]);
        $bool_next_stage = false;
        
        $psp_tmp = $var_stage > 1 ? ($prev_stag_array[$var_stage-2][$prev_stage_pivot]) : 0;
        
        //echo "I = $variable_i; J = $variable_j; X = $variable_x, $var_option <br>";
        $variable_total++;
        switch ($var_stage) {
            case 1: case 2: case 3: case 4: // 1: urgency_rank, 2: importance_rank, 3: difficulty_rank
                if($pivot_value == 0) {
                    $count = CheckStageCount($var_stage, $psp_tmp); 
                    $total_0_count = TotalStageCount($var_stage, $psp_tmp);
                    if($count == 0) {
                        if($var_option == 1) {
                            /// Value of i is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 1);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 2);
                            if($total_0_count > 2) {
                                $variable_i = $variable_j;
                                $getArrayValues = GetArrayValuesFromDB($var_stage, $psp_tmp);
                                $t_count = count($getArrayValues);
                                $variable_j = $getArrayValues[$t_count-1];
                            }
                            else $bool_next_stage = true;
                        }
                        else {
                            /// Value of j is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 2);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 1);
                            if($total_0_count > 2) {
                                $getArrayValues = GetArrayValuesFromDB($var_stage, $psp_tmp);
                                $t_count = count($getArrayValues);
                                $variable_j = $getArrayValues[$t_count-1];
                            }
                            else $bool_next_stage = true;
                        }
                    }
                    elseif ($count == 2) { // Part 2 of stage 0, preparing the 3 pivot values for the remaining stages.
                        if($var_option == 1) {
                            /// Value of i is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 2);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 3);
                            $bool_next_stage = true;
                        }
                        else {
                            /// Value of j is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 3);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 2);
                            $variable_i = GetiLocValueFromDB($var_stage, 1, $psp_tmp);
                        }
                    }
                    else {
                        if($var_option == 1) {
                            /// Value of i is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 1);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 2);
                        }
                        else {
                            /// Value of j is more important
                            ReplaceArrayValueFromDB($variable_i, $var_stage, 2);
                            ReplaceArrayValueFromDB($variable_j, $var_stage, 1);
                        }
                        $bool_next_stage = true;
                    }
                }
                elseif($pivot_value == 3) {
                    if($var_option == 1) {
                        ReplaceArrayValueFromDB($variable_j, $var_stage, 3);
                        $variable_j = GetiLocValueFromDB($var_stage, 0, $psp_tmp);
                        if($variable_j < 0)  $bool_next_stage = true;
                    }
                    else {
                        $pivot_value = 2;
                        $variable_i = $pivot_index2;
                    }
                }
                elseif($pivot_value == 2) {
                    if($var_option == 1) {
                        ReplaceArrayValueFromDB($variable_j, $var_stage, 2);
                    }
                    else {
                        ReplaceArrayValueFromDB($variable_j, $var_stage, 1);
                    }
                    $variable_j = GetiLocValueFromDB($var_stage, 0, $psp_tmp);
                    if($variable_j < 0)  $bool_next_stage = true;
                    $pivot_value = 3;
                    $variable_i = $pivot_index3;
                }
                break;
            //case 4: // time_sort
            default:
                break;
        }
        while($bool_next_stage) {
            $bool_next_stage = false;
            if($pivot_value == 0) {
                $pivot_index1 = GetiLocValueFromDB($var_stage, 1, $psp_tmp);
                $pivot_index2 = GetiLocValueFromDB($var_stage, 2, $psp_tmp); //$variable_i;
                $pivot_index3 = GetiLocValueFromDB($var_stage, 3, $psp_tmp); //$variable_j;
                
                $pivot_value = 3;
                $variable_i = $pivot_index3;
                $variable_j = GetiLocValueFromDB($var_stage, 0, $psp_tmp);
                if($variable_j < 0) $bool_next_stage = true;
            }
            else {
                if($var_stage > 1) {
                    $lim_count = count($prev_stag_array[$var_stage-2]);
                    do {
                        $total_0_count = TotalStageCount($var_stage, $prev_stag_array[$var_stage-2][$prev_stage_pivot]);
                        if($total_0_count < 2)
                            $prev_stage_pivot = $prev_stage_pivot + 1;
                    }
                    while($prev_stage_pivot < $lim_count and $total_0_count < 2);

                    if($prev_stage_pivot == $lim_count) {
                        if($var_stage < 4) {
                            $var_stage = $var_stage + 1;
                            $prev_stage_pivot = 0;
                            $bool_next_stage = true;
                        }
                        else 
                            $bool_sort_complete = true;
                    }
                }
                else {
                    $var_stage = $var_stage + 1; // preparing for next stage of sorting
                    $prev_stage_pivot = 0;
                    $bool_next_stage = true;
                }
                if(!$bool_next_stage and !$bool_sort_complete) {
                    $psp_tmp = $var_stage > 1 ? ($prev_stag_array[$var_stage-2][$prev_stage_pivot]) : 0;

                    $getArrayValues = GetArrayValuesFromDB($var_stage, $psp_tmp);
                    $pivot_value = 0;
                    $variable_i = $getArrayValues[0];
                    $variable_j = $getArrayValues[1];
                    //$count = count($getArrayValues);
                }
            }
        }

        //$arrayVal = ReadIntoArray();
        //printArray($arrayVal, "Intermediate List:");

    }
    else { /// If the sorting is continued from a previously saved instance, then retrieve tha variable values from the database
        $strSQL = "SELECT variable_i, variable_j, variable_option, variable_total, var_stage, prev_stage_pivot, pivot_value, pivot_index1, pivot_index2, pivot_index3 FROM file_details WHERE user_id=$user_id AND id=".$file_id;
        $res = queryMysql($strSQL);
        if($Results = mysqli_fetch_array($res)) {
            $variable_i = $Results["variable_i"];
            $variable_j = $Results["variable_j"];
            $var_option = $Results["variable_option"];
            $variable_total = $Results["variable_total"];
            $var_stage = $Results["var_stage"];

            $prev_stage_pivot = $Results["prev_stage_pivot"];
            $pivot_value = $Results["pivot_value"];
            $pivot_index1 = $Results["pivot_index1"];
            $pivot_index2 = $Results["pivot_index2"];
            $pivot_index3 = $Results["pivot_index3"];
        }
        else
            die("2.Database error: abort operation");

        if($var_stage == 0) { /// Initialize variables to their respective values to start the sort operation if it is a fresh sort.
            $variable_i = 0;
            $var_option = 0;
            $var_stage = 1;

            $strSQL  = "SELECT count(*) As total FROM sort_data WHERE user_id = $user_id AND file_id = $file_id";
            $res = queryMysql($strSQL);
            if($Results = mysqli_fetch_array($res)) 
                $variable_total = $Results["total"];
            else
                die("3.Database error: abort operation");
            if($variable_total > 3)
                $variable_j = intval($variable_total / 2);
            else
                $variable_j = 1;
            $variable_total = 0;
        }

    }

    if($bool_sort_complete == false) { /// Continue sorting until all elements are sorted in the correct order
        $variable_x = GetArrayValueFromDB($variable_i);
        $variable_xs = GetArrayValueFromDB($variable_j);

    ?>
    <form action="?page=sort" method="post" >
        <input type="hidden" name="variable_i" value="<?php echo $variable_i; ?>" > 
        <input type="hidden" name="variable_j" value="<?php echo $variable_j; ?>" > 
        <input type="hidden" name="variable_total" value="<?php echo $variable_total; ?>" > 
        <input type="hidden" name="var_stage" value="<?php echo $var_stage; ?>" > 
        <input type="hidden" name="prev_stage_pivot" value="<?php echo $prev_stage_pivot; ?>" > 
        <input type="hidden" name="pivot_value" value="<?php echo $pivot_value; ?>" > 
        <input type="hidden" name="pivot_index1" value="<?php echo $pivot_index1; ?>" > 
        <input type="hidden" name="pivot_index2" value="<?php echo $pivot_index2; ?>" > 
        <input type="hidden" name="pivot_index3" value="<?php echo $pivot_index3; ?>" > 
        <div class="panel-heading">
            <h4 class="panel-title">You have done <b><i><?php echo $variable_total; ?> steps </i></b> for sorting this list</h4>
        </div>
        <div class="panel-body">
            <b>Which of the two listed tasks is <?php echo $names_of_stages[$var_stage]; ?>? </b><br>
            <div class="radio">
              <label><input type="radio" name="option" value = "1" onchange="this.form.submit();"><?php echo $variable_x; ?></label>
            </div>
             OR  <br>
            <div class="radio">
              <label><input type="radio" name="option" value = "2" onchange="this.form.submit();"><?php echo $variable_xs; ?></label>
            </div>
        </div>
        <div class="panel-footer">
            <input class="btn btn-md btn-success" type="submit" name="sortinginprogress" value="OK">
            <input class="btn btn-md btn-primary" type="submit" name="saveforlater" value="Save & finish Later">
        </div>
    </form>
    <?php 
    }
    else { /// Sorting is completed. You can print the output and also save the result in a CSV file ready for download by the user.
        $arrayVal = ReadIntoArray();
        $filename = WriteArraytoCSV($arrayVal);

        echo "<div class='alert alert-info'>Download generated CSV file <strong><a href='$filename'><i class='fa fa-download'></i>&nbsp;Click Here</a></strong></div>";

        printArray($arrayVal);
        $strSQL = "DELETE FROM sort_data WHERE file_id=".$file_id;
        $res = queryMysql($strSQL);
        $strSQL = "DELETE FROM file_details WHERE id=".$file_id;
        $res = queryMysql($strSQL);
        destroySession();
    }
}
?>
