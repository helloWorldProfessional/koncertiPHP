<?php
	//session_start();
	$db = mysqli_connect('localhost', 'root', '', 'concerts');

	// initialize variables
    $id = 0;
    $image = "";
    $band = "";
    $place = "";
    $event_date ="";
    $tickets ="";
	$edit_state = false;

	$search_message = " ";
	$insert_message=" ";
	$insert_warning = 0;

	//edit data
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];
		$edit_state=true;
		$rec=mysqli_query($db, "select * from events where id=$id");
		$record=mysqli_fetch_array($rec);
		
		$id=$record['id'];
		$image = $record['image'];
		$band = $record['band'];
		$place = $record['place'];
		$event_date =$record['event_date'];
		$tickets =$record['tickets'];
		
		
	}

	// insert data into db
	if (isset($_POST['save'])) {
		$image = $_POST['image'];

		if (!empty($_POST['band']) || !empty($_POST['place']) || !empty($_POST['tickets']) || !empty($_POST['event_date'])) {
			$band = $_POST['band'];
			$place = $_POST['place'];
        	$event_date = date('YYYY-MM-DD', strtotime($_POST["event_date"])); 
        	$tickets =$_POST['tickets'];
			
		}
		else
			$insert_warning=1;

		if ($insert_warning>0){
			//$insert_message="Popunite polja prije unosa!";
		}
		else{
			mysqli_query($db, "INSERT INTO events (image, band, place, event_date, tickets) VALUES ('$image','$band','$place','$event_date','$tickets')"); 
			
		}
		header('location: main.php');
	
		//$_SESSION['message'] = "Podaci su uspješno sačuvani!"; 
		
		
	}
	
	//delete data
	if(isset($_GET['del'])){
		$id=$_GET['del'];		
		mysqli_query($db, "delete from events where id='$id'");
		//$_SESSION['msg'] = "Podaci su uspješno obrisani!"; 
		header('location: main.php');

	}
	
	
	//retrieve data from database
	$results=mysqli_query($db, "Select * from events");
	
	//update data
	if(isset($_POST['update'])){
		$image = $_POST['image'];
        $band = $_POST['band'];
        $place = $_POST['place'];
        $event_date =$_POST['event_date'];
        $tickets =$_POST['tickets'];
		$id=$_POST['id'];
		if(empty($image)){
			mysqli_query($db, "update events set band='$band', place='$place', event_date='$event_date', tickets='$tickets' where id='$id'");
		}
		else
			mysqli_query($db, "update events set image='$image', band='$band', place='$place', event_date='$event_date', tickets='$tickets' where id='$id'");
		//$_SESSION['msg'] = "Podaci su uspješno ažurirani!"; 
		header('location: main.php');
	}
	
	//search data
	if(isset($_POST['search'])){
        $band = $_POST['search-band'];
		$results=mysqli_query($db, "select*from events where band='$band'");
		if(mysqli_num_rows($results)==0){
			$search_message="Ne postoji u bazi podataka!";
		}
		$band = "";

	}

?>