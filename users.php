<?php 

  include('db.php');

?>

  <!DOCTYPE html>
<html>
<head>
  <!-- MOBILE RESPONSIVE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- TITLE -->
  <title>PARAGRAF</title>
  <link rel="stylesheet" type="text/css" href="css/users.css">
  <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/darkly/bootstrap.min.css">
</head>
<body>


  <div class="col-md-8 offset-md-2 col-xs-12 table-div">

    <h1 style="margin-bottom: 3rem;">PARAGRAF TASK</h1>

    <!-- IF THERE ARE USERS CREATE TABLE AND DISPLAY ALL INFO -->

    <?php   
      $stmt = $pdo->query("SELECT * FROM users");
      $users = $stmt->fetchAll();
      if(!empty($users)){
    ?>

      <table class="container">
        <thead>
          <tr>
            <th><h1>FULL NAME</h1></th>
            <th><h1>EMAIL</h1></th>
            <th><h1>PHONE</h1></th>
            <th><h1>INSURANCE TYPE</h1></th>
            <th><h1>PERIOD</h1></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $user){ ?>
            <tr>
              <td><?php echo $user['full_name']; ?></td>
              <td><?php echo $user['email']; ?></td>
              <td><?php echo $user['phone']; ?></td>
              <td>      
                <?php               
                  if($user['insurance_type'] == "Group-Insurance"){
                    $id = $user['id'];
                    $stmt2 = $pdo->query("SELECT * FROM group_insurance_users WHERE user_id = $id");
                    $groupUsers = $stmt2->fetchAll();
                ?>
                    <a role="button" data-toggle="collapse" href="#groupInsurance<?php echo $user['id']; ?>" aria-expanded="false"><?php echo $user['insurance_type']; ?></a>
                    <div id="groupInsurance<?php echo $user['id']; ?>" class="collapse">
                      <?php foreach($groupUsers as $groupUser){ ?>
                        <?php echo $groupUser['firstname'] . " " . $groupUser['lastname']; ?><br>
                      <?php } ?>
                    </div>          
                <?php 
                  }else{
                    echo $user['insurance_type'];
                  }
                ?>                
              </td>
              <?php 
                $earlier = new DateTime($user['date_from']);
                $later = new DateTime($user['date_to']);              
                $numOfDays = $later->diff($earlier)->format("%a");
              ?>
              <td><?php echo $user['date_from'] . " - " . $user['date_to'] . " ( " . $numOfDays . " days )"; ?></td>
            </tr>
          <?php } ?>   
        </tbody>
      </table>

    <!-- IF THERE ARE NO USERS AVAILABLE DISPLAY MESSAGE -->

    <?php }else{ ?>
      <h3 class='noshifts'>No clients found.</h3>
    <?php } ?>

  </div>


  <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
    <a href="index.php" style="color: #fff;">Home.</a>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>