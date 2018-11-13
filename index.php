<?php 

  include("db.php");

  if(isset($_POST['submit-contact'])){
    
  /* ============================ SECURE ============================== */

    $error = false;
    $invalidEmail = false;

    $fullname = htmlentities($_POST['nameC']);
    $email = htmlentities($_POST['emailC']);
    $phone = htmlentities($_POST['phoneC']);
    $insurance = htmlentities($_POST['insuranceC']);
    $dateFrom = htmlentities($_POST['dateFrom']);
    $dateTo = htmlentities($_POST['dateTo']);

    if($email && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $invalidEmail = true;
      $messageEmail = "Please use correct email.";
    }

  /* ============================ CHECK IF USER ALREADY EXISTS ============================== */

    $sql = "SELECT full_name, email FROM users WHERE full_name = :full_name AND email = :email AND phone = :phone";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      'full_name' => $fullname,
      'email' => $email,
      'phone' => $phone
    ]);
    
    if($stmt->rowCount() > 0){
      $error = true;
      $message = "Client is already insured.";
    }

  /* ============================ INSERT USER ============================== */

    if(!$error && !$invalidEmail){

      $sql = "INSERT INTO users(full_name, insurance_type, email, phone, date_from, date_to) VALUES(:full_name, :insurance_type, :email, :phone, :date_from, :date_to)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        'full_name' => $fullname,
        'insurance_type' => $insurance,
        'email' => $email,
        'phone' => $phone,
        'date_from' => $dateFrom,
        'date_to' => $dateTo
      ]);

      $last_id = $pdo->lastInsertId();

      /* ============================ IF USER SELECTED GROUP INSURANCE ============================== */

      if($insurance == "Group-Insurance"){

        $brojac = 0;
        $id1 = false;
        $id2 = false;
        $id3 = false;
        $id4 = false;

        /* ============================ COUNT HOW MANY INSURANTS ============================== */

        if(isset($_POST['insurantfirstname1'])){
          $groupInsurantFirstname1 = $_POST['insurantfirstname1'];
          $groupInsurantLastname1 = $_POST['insurantlastname1'];
          $groupInsurantEmail1 = $_POST['insurantemail1'];
          $groupInsurantDateOfBirth1 = $_POST['insurantdate1'];
          $id1 = true;
          $brojac++;
        }

        if(isset($_POST['insurantfirstname2'])){
          $groupInsurantFirstname2 = $_POST['insurantfirstname2'];
          $groupInsurantLastname2 = $_POST['insurantlastname2'];
          $groupInsurantEmail2 = $_POST['insurantemail2'];
          $groupInsurantDateOfBirth2 = $_POST['insurantdate2'];
          $id2 = true;
          $brojac++;
        }

        if(isset($_POST['insurantfirstname3'])){
          $groupInsurantFirstname3 = $_POST['insurantfirstname3'];
          $groupInsurantLastname3 = $_POST['insurantlastname3'];
          $groupInsurantEmail3 = $_POST['insurantemail3'];
          $groupInsurantDateOfBirth3 = $_POST['insurantdate3'];
          $id3 = true;
          $brojac++;
        }

        if(isset($_POST['insurantfirstname4'])){
          $groupInsurantFirstname4 = $_POST['insurantfirstname4'];
          $groupInsurantLastname4 = $_POST['insurantlastname4'];
          $groupInsurantEmail4 = $_POST['insurantemail4'];
          $groupInsurantDateOfBirth4 = $_POST['insurantdate4'];
          $id4 = true;
          $brojac++;
        }

        /* ============================ ADD EVERY INSURANT TO DB ============================== */

        for($i = 1; $i <= $brojac; $i++){
          if($id1){
            // ubaci keca i stavi ga da vise ne postoji
            $sql = "INSERT INTO group_insurance_users(user_id, firstname, lastname, email, date_of_birth) VALUES (:user_id, :firstname, :lastname, :email, :date_of_birth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              'user_id' => $last_id,
              'firstname' => $groupInsurantFirstname1,
              'lastname' => $groupInsurantLastname1,
              'email' => $groupInsurantEmail1,
              'date_of_birth' => $groupInsurantDateOfBirth1
            ]);
            $id1 = false;
          }else if($id2){
            $sql = "INSERT INTO group_insurance_users(user_id, firstname, lastname, email, date_of_birth) VALUES (:user_id, :firstname, :lastname, :email, :date_of_birth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              'user_id' => $last_id,
              'firstname' => $groupInsurantFirstname2,
              'lastname' => $groupInsurantLastname2,
              'email' => $groupInsurantEmail2,
              'date_of_birth' => $groupInsurantDateOfBirth2
            ]);
            $id2 = false;
          }else if($id3){
            $sql = "INSERT INTO group_insurance_users(user_id, firstname, lastname, email, date_of_birth) VALUES (:user_id, :firstname, :lastname, :email, :date_of_birth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              'user_id' => $last_id,
              'firstname' => $groupInsurantFirstname3,
              'lastname' => $groupInsurantLastname3,
              'email' => $groupInsurantEmail3,
              'date_of_birth' => $groupInsurantDateOfBirth3
            ]);
            $id3 = false;
          }else{
            $sql = "INSERT INTO group_insurance_users(user_id, firstname, lastname, email, date_of_birth) VALUES (:user_id, :firstname, :lastname, :email, :date_of_birth)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              'user_id' => $last_id,
              'firstname' => $groupInsurantFirstname4,
              'lastname' => $groupInsurantLastname4,
              'email' => $groupInsurantEmail4,
              'date_of_birth' => $groupInsurantDateOfBirth4
            ]);
            $id4 = false;
          }     
        }     
      }


        /* ============================ PDF ============================== */
        
        include("FPDF/fpdf.php");

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 16);
    
        $pdf->Cell(0, 10, "Welcome ''{$fullname}''", 1, 1, 'C');
    
        $pdf->Cell(50, 10, "Email", 1, 0);
        $pdf->Cell(0, 10, $email, 1, 1);
    
        $pdf->Cell(50, 10, "Phone", 1, 0);
        $pdf->Cell(0, 10, $phone, 1, 1);
    
        $pdf->Cell(50, 10, "Insurance", 1, 0);
        $pdf->Cell(0, 10, $insurance, 1, 1);
    
        $pdf->Cell(50, 10, "Date", 1, 0);
        $pdf->Cell(0, 10, "FROM " . $dateFrom . " TO " . $dateTo, 1, 1);
    
        $date = date('dmYHis');
        $filename = $fullname . $date . ".pdf";
        $fileout = 'PDFs/' . $filename;
    
        $pdf->Output('F', $fileout);
    
        // Settings
        $name        = $fullname;
        $fromEmail   = "dragoslav.gagi8@yahoo.com";
        $to          = $email;
        $from        = "Dragoslav";
        $subject     = "Here is your attachment";
        $mainMessage = "Hi, here's the file.";
        $fileatt     = "PDFs/" . $filename;
        $fileatttype = "application/pdf";
        $fileattname = "newname.pdf";
        $headers = "From: " . $fromEmail;
    
        // File
        $file = fopen($fileatt, 'rb');
        $data = fread($file, filesize($fileatt));
        fclose($file);
    
        // This attaches the file
        $semi_rand     = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        $headers      .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";
        $message = "This is a multi-part message in MIME format.\n\n" .
        "-{$mime_boundary}\n" .
        "Content-Type: text/plain; charset=\"iso-8859-1\n" .
        "Content-Transfer-Encoding: 7bit\n\n" .
        $mainMessage  . "\n\n";
    
        $data = chunk_split(base64_encode($data));
        $message .= "--{$mime_boundary}\n" .
        "Content-Type: {$fileatttype};\n" .
        " name=\"{$fileattname}\"\n" .
        "Content-Disposition: attachment;\n" .
        " filename=\"{$fileattname}\"\n" .
        "Content-Transfer-Encoding: base64\n\n" .
        $data . "\n\n" .
        "-{$mime_boundary}-\n";
    
        // Send the email
        mail($to, $subject, $message, $headers);

        header("Location: users.php");

        /* ============================ PDF ============================== */
    }
  }

  /* ============================ EMPTY TABLES ============================== */

  // $sql = 'TRUNCATE TABLE group_insurance_users';
  // $stmt = $pdo->prepare($sql);
  // $stmt->execute();

  // $sql = 'TRUNCATE TABLE users';
  // $stmt = $pdo->prepare($sql);
  // $stmt->execute();

?>




<!DOCTYPE html>
<html lang="en">
<head>
	<title>PARAGRAF</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="POST">
				<span class="contact100-form-title">
					Contact Us
          <br><span class="label-input100"><?php if(isset($error) && $error) echo $message; ?></span>
          <br><span class="label-input100"><?php if(isset($invalidEmail) && $invalidEmail) echo $messageEmail; ?></span>
				</span>
        
				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">FULL NAME *</span>
					<input class="input100" type="text" name="nameC" id="nameC" placeholder="Enter Your Name" value="<?php if(isset($_POST['nameC'])) echo $_POST['nameC']; ?>" required>
        </div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
					<span class="label-input100">Email *</span>
					<input class="input100" type="email" name="emailC" id="emailC" placeholder="Enter Your Email" value="<?php if(isset($_POST['emailC'])) echo $_POST['emailC']; ?>" required>
				</div>

				<div class="wrap-input100 bg1 rs1-wrap-input100">
					<span class="label-input100">Phone *</span>
          <input type="tel" name="phoneC" class="input100" id="phoneC" placeholder="Format: 381-XXXXXXX" value="<?php if(isset($_POST['phoneC'])) echo $_POST['phoneC']; ?>" pattern="[0-9]{3}-[0-9]{8,9}" required>
				</div>

				<div class="wrap-input100 input100-select bg1">
					<span class="label-input100">Insurance *</span>
					<div>
						<select class="js-select2" name="insuranceC" id="insuranceC" required>
							<option value="">Please choose</option>
							<option value="Individual-Insurance">Individual Insurance</option>
							<option value="Group-Insurance">Group Insurance</option>
						</select>
						<div class="dropDownSelect2"></div>
					</div>
				</div>

				<div class="w-full dis-none js-show-service">
					<div class="wrap-contact100-form-radio">
						<span class="label-input100 insurant-message">Insurants</span>
						<div class="contact100-form-radio m-t-15">
              <button type="button" class="contact100-form-btn assurance-btn" data-toggle="modal" data-target="#exampleModal">
                Add Insurant
              </button>
						</div>
					</div>
        </div>
        
        <div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Date From *</span>
					<input class="input100" type="date" name="dateFrom" id="dateFrom" placeholder="Choose Date" value="<?php if(isset($_POST['dateFrom'])) echo $_POST['dateFrom']; ?>" required>
        </div>
        
        <div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Date To *</span>
					<input class="input100" type="date" name="dateTo" id="dateTo" placeholder="Choose Date" value="<?php if(isset($_POST['dateTo'])) echo $_POST['dateTo']; ?>" required>
        </div>

        <div>
          <span class="label-input100 numberofdays">Number of days: 0</span>
          <br>
          <span class="label-input100 error-message"></span>
        </div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" name="submit-contact" type="submit">
						<span>
							Submit
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
        </div>
        
        <div class="hidden-inputs">

        </div>

			</form>


      <div style="text-align: center; margin-top: 1.5rem;">
        <a href="users.php">Users.</a>
      </div>
		</div>
  </div>
  

<!-- MODAL FOR GROUP INSURANTS -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Insurant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="insurant-form">
          <div class="form-group">
            <label for="fullname-insurant">First Name</label>
            <input type="text" class="form-control" id="firstname-insurant" name="first-name" placeholder="First Name" required>
          </div>
          <div class="form-group">
            <label for="fullname-insurant">Last Name</label>
            <input type="text" class="form-control" id="lastname-insurant" name="last-name" placeholder="Last Name" required>
          </div>
          <div class="form-group">
            <label for="email-insurant">Email</label>
            <input type="email" class="form-control" id="email-insurant" placeholder="Email" required>
          </div>
          <div class="form-group">
            <label for="date-insurant">Date Of Birth</label>
            <input type="text" class="form-control" pattern="(?:19)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" id="date-insurant" placeholder="Format: YYYY-MM-DD (must be older than 18)">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
          <span class="insurant-added-message"></span>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "" || $(this).val() == "Individual-Insurance") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>

<!--===============================================================================================-->
  <script src="js/main.js"></script>

</body>
</html>
