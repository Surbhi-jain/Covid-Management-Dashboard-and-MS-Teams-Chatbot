<?php
if(!empty($_FILES)) {
	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
		$sourcePath = $_FILES['userImage']['tmp_name'];
		$targetPath = "data/".$_FILES['userImage']['name'];

		if(basename($targetPath) == "residents.csv")
		{
			if(move_uploaded_file($sourcePath,$targetPath))
				{
				 if (($open = fopen("data/".$_FILES['userImage']['name'], "r")) !== FALSE) 
					  {
					  
					
						while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
						{        
						  $array[] = $data; 
						}
					  
						fclose($open);
						for($i=1;$i<sizeof($array);$i++)
						  {
							  
						   try
								  {
									require 'connect.php';
									
									$query = $conn->prepare("INSERT INTO `residents`(`rollno`, `email`, `name`, `hostel`, `room`, `gender`) VALUES (:rollno, :email, :name, :hostel, :room, :gender)");
									
									$query->bindParam(':rollno', $array[$i][0], PDO::PARAM_STR);
									$query->bindParam(':email', $array[$i][1], PDO::PARAM_STR);
									$query->bindParam(':name', $array[$i][2], PDO::PARAM_STR);
									$query->bindParam(':hostel', $array[$i][3], PDO::PARAM_STR);
									$query->bindParam(':room', $array[$i][4], PDO::PARAM_STR);
									$query->bindParam(':gender', $array[$i][5], PDO::PARAM_STR);
									$query->execute();
									
								  }
								  catch(PDOException $g)
								  {
									die("Error ".$g);
								  }
						  }
					  echo " ";
						
					  }
				  else
					echo "Please Upload Only Template CSV File";
					  //print_r($array);
					  
		        }	
		}
		else
		{
		  echo "Please Upload Only Template CSV File";
		}
	}
}
?>