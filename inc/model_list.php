<?php
/// This module reads data from the final sorted table and outputs the result into an HTML table */
function printArrayList($arrayInput) /// Print the generated array on to the html output as a table
{
    ?>
    <form action="?page=upload" method="post" >
        <div class="panel-heading">
            <h4 class="panel-title">Select a file to continue sorting where you left off</h4>
        </div>
        <div class="panel-body">
        <?php if (count($arrayInput) > 0) { ?>
            <table>
              <tbody>
            <?php foreach ($arrayInput as $row): array_map('htmlentities', $row); ?>
                <tr>
                  <td><?php echo $row[0]; ?> </td>
                </tr>
            <?php endforeach; ?>
              </tbody>
            </table>
        <?php } else {
            $notice = "There are no previously saved files!";
            include_once "inc/messages.php";
        } ?>
        </div>
        <div class="panel-footer">
            <input class="btn btn-md btn-success" type="submit" value="Upload New">
        </div>
    </form>
<?php
}

function ReadIntoArrayList() /// Read data from the database table into an array
{
    global $user_id, $file_id;
    $resArray = array();
    $strSQL = "SELECT id, filename, var_time FROM file_details WHERE user_id = $user_id AND saved=1 ORDER BY var_time desc";
    $res = queryMysql($strSQL);
    $i = 0;
    while($Results = mysqli_fetch_array($res)) {
        $id = $Results["id"];
        $resArray[$i][0] = "<a href='?page=sort&fileid=$id'>". $Results["filename"]. date("_m_d_Y_H_i", strtotime($Results["var_time"]))."_unfinished</a>" ;
        $resArray[$i][1] = $Results["var_time"];
        $i++;
    }
    return $resArray;
}

$arrayVal = ReadIntoArrayList();
printArrayList($arrayVal);

?>