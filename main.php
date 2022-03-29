<?php include ('server.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koncerti</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<script type='text/javascript'>

function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}

</script>
<body>

<h1 align="center">KONCERTI</h1>
<form method="post" action="">
	<h2 align="center">PRETRAGA</h2>
	<div class="input-group">
		<input type="text" name="search-band">
		<?php 
			if(!empty($search_message)){
				echo '<p style="color:red;">' .$search_message. '</p>';
			}        
        ?>
		
		<button class="btn" type="submit" name="search" align="center">Pretraži</button>
	</div>
</form>
<form method="post" action="server.php">
	<!--h2 align="center">UNOS</h2-->
	<?php if ($edit_state==false):?>
				<h2 align="center">UNOS</h2>
			<?php else :?>
				<h2 align="center">UREĐIVANJE</h2>
			<?php endif ?>
	<input type="hidden" name="id" value="<?php echo $id;?>">
		<div class="input-group">
			<img id="output_image" alt="" height="auto" width="60%" style="margin-left: 20%; margin-right:20%" src="<?php echo $image;?>"/>
			<input type="file" name="image" accept="image/*" onchange="preview_image(event)" >
			
		</div>
        <div class="input-group">
			<label>Izvođač</label>
			<input type="text" name="band" value="<?php echo $band;?>">
		</div>
		<div class="input-group">
			<label>Mjesto</label>
			<input type="text" name="place" value="<?php echo $place;?>">
		</div>
        <div class="input-group">
			<label>Datum</label>
			<input type="date" name="event_date" value="<?php echo $event_date;?>">

		</div>
        <div class="input-group">
			<label>Br. prodatih karata</label>
			<input type="text" name="tickets" value="<?php echo $tickets;?>">

			<?php 
			if(!empty($insert_message)){
				echo '<p style="color:red;">' .$insert_message. '</p>';
			}        
			?>
		</div>
		
		
		<div class="input-group">
			<?php if ($edit_state==false):?>
				<button class="btn" type="submit" name="save" >Unesi</button>
			<?php else :?>
				<button class="btn" type="submit" name="update">Ažuriraj</button>
			<?php endif ?>
			
		</div>
	</form>
	

<table>
    <thead>
        <tr class="header-row">
            <th>Slika</th>
            <th>Izvođač</th>
            <th>Mjesto</th>
            <th>Datum</th>
            <th>Br. prodatih karata</th>
        </tr>
    </thead>
	<tbody>
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><img src="<?php echo $row['image'];?>" alt="" height="auto" width="200"></td>
			<td><?php echo $row['band']; ?></td>
			<td><?php echo $row['place']; ?></td>
			<td><?php echo $row['event_date']; ?></td>
			<td><?php echo $row['tickets']; ?></td>
			<td>
				<a class="edit_btn" href="main.php?edit=<?php echo $row['id'];?>">Uredi</a>
			</td>
			<td>
				<a class="del_btn" href="server.php?del=<?php echo $row['id'];?>">Obriši</a>
			</td>
		</tr>
	<?php } ?>
    </tbody>
</table>


</body>

</html>