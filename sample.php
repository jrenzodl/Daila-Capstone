<?php

include 'includes/sections/header.php';



/*
 *    T E S T I N G
 *
 *    A R E A
 *
 *    B E L O W
 *
 */
    // secondsdatetime -> time diff of two times turned into seconds
// echo seconds_datetime(60*check_time_diff_mins("10:28:00","12:23:00"));

// print_p(get_productprocess($conn,10));
// $m = get_machine($conn,1);
// $random_keys=array_rand($m,2);
// echo $m[$random_keys]."<br>";
//
// $dates = array
// (
//     '0'=> "2013-02-18 05:14:54",
//     '1'=> "2013-02-12 01:44:03",
//     '2'=> "2013-02-05 16:25:07",
//     '3'=> "2013-01-29 02:00:15",
//     '4'=> "2013-01-27 18:33:45"
// );
// //
// echo find_closest_today($dates,date('Y-m-d'));
//
// $cont = get_productprocess($conn,3);
// // checker for counter ng mga may used machines sa production
// $checker = 0;
// // per product process iteration
// for ($i=0; $i < count($cont); $i++) {
//   // if process has no available machine increment checker
//     if (count(get_machine($conn,$cont[$i]))==0) {
//       $checker++;
//     }
// }
// echo $checker;


// get due dates ng mga may same process id at machine ids
$sql = mysqli_query($conn,"SELECT JobOrder.dueDate
                            FROM JobOrder
                            JOIN ProductionProcess ON JobOrder.orderID = ProductionProcess.orderID
                            WHERE ProductionProcess.processTypeID = 1 AND ProductionProcess.machineID = 4");
// store sa array
$deadlines = array();
while ($row = mysqli_fetch_array($sql)) {
  array_push($deadlines,$row[0]);
}

// print_p($deadlines);
// dummy data
$arr = array('2018-11-21', '2018-11-25', '2018-12-01', '2018-11-22', '2018-11-24');

// sortsort
function date_sort($a, $b) {
    return strtotime($a) - strtotime($b);
}
usort($arr, "date_sort");
// print_p($arr);
// finding the closest date sa array ng deadlines
// echo find_closest_today($arr,date('Y-m-d'));
// lumabas 2018-11-22
// next gagawin mo dito is lahat ng mga may deadline na starting sa returned deadline sa taas imomove mo ung queue nila


// get the cuurent queue muna nung nag result ng query from the closest deadline tapos from there don kana mag increment
$sql = mysqli_query($conn,"SELECT machineQueue
                            From ProductionProcess
                            WHERE ProductionProcess.processTypeID = 1 AND ProductionProcess.machineID = 4
                            ORDER BY machineQueue DESC LIMIT 1");

  $row = mysqli_fetch_array($sql);

  $curqueue = $row[0];

// if (check_complete_proc($conn,151,10)) {
//   echo "false";
// }else {
//   echo "true";
// }
// print_p(get_need_inventory($conn,171));
print_p(check_for_inventory_match($conn,171));
// echo check_for_out($conn,159);
// $query = "SELECT * FROM JobOrder WHERE orderID = 159";
//
// $sql = mysqli_query($conn,$query);
//
// $row = mysqli_fetch_array($sql);
//
// if (check_for_out($conn,159)) {
//   if($row['type'] == 'Made to Order'){
//     $query = "UPDATE JobOrder SET status = 'For Out' WHERE orderID = 159";
//
//     mysqli_query($conn,$query);
//   }else {
//     $query = "UPDATE ProductionProcess SET status = 'Added' WHERE orderID = 159 AND productID = 3";
//
//     mysqli_query($conn,$query);
//   }
// }else {
//   $query = "UPDATE ProductionProcess SET status = 'Added' WHERE orderID = 159 AND productID = 3";
//
//   mysqli_query($conn,$query);
// }

//
// $sql = mysqli_query($conn,"");

// if( strtotime("2018-11-20") > strtotime('now') ) {
//   echo ">";
// }else {
//   echo "<";
// }

// echo get_curr_queue($conn,1,4)+1;
?>
