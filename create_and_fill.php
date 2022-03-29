<?php
$link = mysqli_connect('localhost', 'root', '');
 
// Check connection
if($link === false){
    //die("ERROR: Could not connect. " . mysqli_connect_error());
}

//create the main database if it doesn't already exist
$create = mysqli_query($link,'CREATE DATABASE IF NOT EXISTS concerts')
or die(mysqli_connect_error());

//make sure our recently created database is the active one
mysqli_select_db($link,'concerts');

    $events="CREATE TABLE `events` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `image` varchar(30) NOT NULL,
    `band` varchar(50) NOT NULL,
    `place` varchar(100) DEFAULT NULL,
    `event_date` date DEFAULT NULL,
    `tickets` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    $result = mysqli_query($link, $events);
    
    $users="CREATE TABLE `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `pass` varchar(200) DEFAULT NULL,
        `date_created` date DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    
    $result = mysqli_query($link, $users);
    
    
    // insert data into events table
    $insert_events = "INSERT INTO events (id, image, band, " .
                "place, event_date, tickets) " .
                "VALUES (NULL, 'lorde.jpg', 'Lorde', 'Neudorf Vineyards\r\nNelson, New Zealand', '2022-02-27', '100'), ".
                "(NULL, 'lorde.jpg', 'Lorde', 'Days Bay\r\nEastbourne, New Zealand', '2022-03-02', '120'), " .
                "(NULL, 'elton_john.jpg', 'Elton Jonh', 'Tele2 Arena\r\nJohanneshov, Sweden', '2021-09-17', '1000'), ".
                "(NULL, 'elton_john.jpg', 'Elton Jonh', 'HARTWALL ARENA\r\nHelsinki, Finland', '2021-09-21', '1200'), " .
                "(NULL, 'elton_john.jpg', 'Elton John', 'Telenor Arena Shuttlebuss\r\nOslo, Norway', '2021-09-25', '800'),".
                "(NULL, 'elton_john.jpg', 'Elton John', 'Hallenstadion\r\nZürich, Switzerland', '2021-10-05', '350'),".
                "(NULL, 'harry_styles.jpeg', 'Harry Styles', 'Rogers Arena\r\nVancouver, Canada', '2021-08-16', '589'),".
                "(NULL, 'harry_styles.jpeg', 'Harry Styles', 'Scotiabank Arena\r\nToronto, Canada', '2021-09-28', '256'),".
                "(NULL, 'billie_eilish.jpeg', 'Billie Eilish', 'Smoothie King Center\r\nNew Orleans, LA', '2022-02-03', '278'),".
                "(NULL, 'billie_eilish.jpeg', 'Billie Eilish', 'Centre Bell\r\nMontreal, Canada', '2023-02-15', '190')"; 
    $result = mysqli_query($link, $insert_events);
    
    // insert data into users table
    $insert_users = "INSERT INTO users (id, username, pass, date_created) " .
                "VALUES (NULL, 'marko.markovic', 'marko123', current_timestamp()), " .
                "(NULL, 'sanja.cvijetic', 'sanja123', current_timestamp())," .
                "(NULL, 'bosko.nikolic', 'bosko123', current_timestamp())"; 
    $result = mysqli_query($link, $insert_users);    

    header("location: index.php");
?>