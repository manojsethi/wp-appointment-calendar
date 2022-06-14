<?php
/*
 Author: Boffincoders
*/
 
require('../../../../wp-load.php');
 
if($_POST['radiovalue']!=""){
 
	$to = $_POST['email'];
	$subject = 'Apointment';
	$message = 'Appointment Message';

	$headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 // More headers
	$headers .= 'From: <webmaster@example.com>' . "\r\n";
	$headers .= 'Cc: boffinteam@boffincoders.com' . "\r\n";
  
 	$name = $_POST['name'];
 	$email = $_POST['email'];
 	$radiovalue = $_POST['radiovalue'];
 	$phone = $_POST['phone'];
   	$address = $_POST['address'];
 	$city = $_POST['city'];
 	$state = $_POST['state'];
 	$zip_code = $_POST['zip_code'];
 	$note = $_POST['note'];
	
	if($_POST['date_slected'])
	{
		$date_slected = $_POST['date_slected'];
	}
	
     $table_name = $wpdb->prefix."appointment_booked";
     $table_name2 = $wpdb->prefix."appointment_data";
     $default_row2 = $wpdb->get_row( "SELECT * FROM $table_name2 WHERE appointment_id='1'");
	 
     $allbook = array();
	 $table_namebooked = $wpdb->prefix."appointment_booked";
     $default_rowbooked = $wpdb->get_results("SELECT * FROM $table_namebooked");
	 foreach($default_rowbooked as $bookedvalues)
	 {
		 $allbook[] = $bookedvalues->date;
		 $allbook[] = $bookedvalues->time;
	 }
	 
	 
	 $tablemessages = $wpdb->prefix."appointment_data";
	 $default_rowbooked = $wpdb->get_row("SELECT * FROM $tablemessages where id = '1'");
	  
   
   if (in_array( $radiovalue, $allbook) && in_array( $date_slected, $allbook))   
   {
	 echo "<span style='color:green; font-weight:bold;'>".$default_rowbooked->success_message."</span>";
   }
   
   else {
     $wpdb->insert($table_name, array(
					'name' => $name,	 
					'email' => $email,	 
					'phone' => $phone,	 
					'address' => $address,	 
					'city' => $city,	 
					'state' => $state,	 
					'zip_code' => $zip_code,	 
					'notes' => $note,	  
					'date' => $radiovalue,	 
					'time' => $date_slected,	 
			));
    
	
	$time = explode("slot",$radiovalue);
	
	$message = "<html>
					<head>
					<title>Appointment</title>
					</head>
					<body>
					<p>".$default_row2->booked_apointment_email_customer."</p>
					 <div>
					 <p><b>Name</b>".$name."</p> 
					 <p> <b>Email</b>".$email." </p> 
					 <p> <b>Appointment Time </b>".$date_slected.", ".$time[1]." </p> 
					 </div>
					</body>
					</html>
					";
 
	
	// $message = $default_row2->booked_apointment_email_admin."<br/> ";
     $sent_message = wp_mail( $to, $subject, $message, $headers );
	
	
	
	echo "<span style='color:green; font-weight:bold;'>".$default_rowbooked->success_message."</span><br/>";
	echo $date_slected.", ".$time[1];
	echo "<br/>";
	echo "<b>Name:</b> ".$name;
	echo "<br/>";
	echo "<b>Email:</b> ".$email;
	 
	   if ($sent_message) {
        //    echo 'Check Your Email';
        }
   }
}

else {
	  echo "<span style='color:red; font-weight:bold;'>".$default_rowbooked->failed_message."/<span>";
	}	
?>
<script>
  document.getElementById("<?php echo str_replace(':',"", $radiovalue); ?>").disabled = true;
</script>

<style>
#<?php echo str_replace(':',"", $radiovalue); ?>
{
	    background: #bab6bf !IMPORTANT;
    border: 1px solid #bab6bf !IMPORTANT;
}
</style>