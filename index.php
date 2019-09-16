<!DOCTYPE html>
<html>
<head>
  <title>Heroku Test</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  
   <script>
    $(document).ready(function() {
    $('#mytable').DataTable();
} );
  </script>
  
</head>
  
  <?php include ('config/db.php')?>
<?php include ('config/config.php')?>

<?php
  $status='';
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['New_record'])){
  $insql = "insert into salesforce.Contact(firstname,lastname,email) VALUES('$_POST[firstname]','$_POST[lastname]','$_POST[email]') ";
  $instmt = $pdo->prepare($insql);
  if($instmt->execute()){
   $status='<div class="alert alert-success  alert-dismissible fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Record saved successfully now!
          </div>';
  }else{
   $status='<div class="alert alert-danger  alert-dismissible fade in">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Danger!</strong> Update issue, ask to admin!
</div>';
  }
}
?>

<?php
  $status='';
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['Edit_record'])){
  $insql = "update salesforce.Contact set firstname='$_POST[firstname]', lastname='$_POST[lastname]', email='$_POST[email]' where sfid='$_POST[sfid]' ";
  $instmt = $pdo->prepare($insql);
  if($instmt->execute()){
   $status='<div class="alert alert-success  alert-dismissible fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Record updated successfully now!
          </div>';
  }else{
   $status='<div class="alert alert-danger  alert-dismissible fade in">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Danger!</strong> Update issue, ask to admin!
</div>';
  }
}
?>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="<?php echo ROOT_URL; ?>">Heroku Test</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>">Home</a>
      </li>
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>about">About</a>
      </li>
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>contact">Contact Us</a>
      </li>
    </ul>
      </div>
</nav>

<?php
  $sql = 'SELECT * FROM salesforce.Contact';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  //$insql = 'INSERT INTO salesforce.Contact(lastname) VALUES(\'HEROKUINSERT913\')';
  //$instmt = $pdo->prepare($insql);
  //$instmt->execute();
  
  $rowCount = $stmt->rowCount();
  ?>
  <section>
    <?php if(isset($status) and !empty($status)){?>
      <div class="row">
        <div class="col-md-12">
        <?php echo $status;?>
        </div>
      </div>
   <?php } ?>
    <div class="row">
      <div class="col-md-12">
        <h1>Contact List from Sales Force</h1><hr/>
        <a href="javascript:void()"  data-toggle="modal" data-target="#myModal" class="btn btn-primary">NEW Contact</a><hr/>
          <table class="table" id="mytable">
          <thead>
          <th>ID</th><th>Fisrt Name</th><th>Last Name</th><th>Email</th><th>Created Date</th><th>Options</th>
            </thead>
            <tbody>
          <?php
          if(isset($rowCount) and $rowCount>0){
             $details = $stmt->fetchAll();
              foreach($details as $row){
          ?>
              <tr>
                <td><?php echo $row->sfid;?></td>
                <td><?php echo $row->firstname;?></td>
                <td><?php echo $row->lastname;?></td>
                <td><?php echo $row->email;?></td>
                <td><?php echo $row->createddate;?></td>
                <td><a href="javascript:void()"  data-toggle="modal" data-target="#myModal-<?php echo $row->sfid;?>" class="btn btn-primary">Edit</a>
              </tr>
              
              <!-- Modal -->
            <div id="myModal-<?php echo $row->sfid;?>" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Contact</h4>
                  </div>
                  <form method="post" action="https://dmdelhi.herokuapp.com/">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $row->firstname;?>">
                          </div>
                          <div class="form-group">
                            <label>Last Name:</label>
                             <input type="text" name="lastname" class="form-control" value="<?php echo $row->lastname;?>" required="required">
                          </div>
                          <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row->email;?>">
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="sfid" value="<?php echo $row->sfid;?>">
                      <input type="submit" name="Edit_record" value="Update" class="btn btn-success">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          <?php
              }

          }
          ?>
            </thead>
          </table>
    </div>
    </div>
  </section>


  <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Contact</h4>
                  </div>
                  <form method="post" action="https://dmdelhi.herokuapp.com/">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="firstname" class="form-control" value="">
                          </div>
                          <div class="form-group">
                            <label>Last Name:</label>
                             <input type="text" name="lastname" class="form-control" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="">
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" name="New_record" value="Save" class="btn btn-success">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
  
 
</body>
</html>
