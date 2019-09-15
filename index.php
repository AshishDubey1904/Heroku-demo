<?php include ('config/db.php')?>
<?php include ('config/config.php')?>

<html>
<head>
  <title>Heroku Test</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
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
  //echo 'This is Index Page';

  $sql = 'SELECT * FROM salesforce.Contact';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  //$insql = 'INSERT INTO salesforce.Contact(lastname) VALUES(\'HEROKUINSERT913\')';
  //$instmt = $pdo->prepare($insql);
  //$instmt->execute();
  
  $rowCount = $stmt->rowCount();
  if(isset($rowCount) and $rowCount>0){
     $details = $stmt->fetch();
    print_r ($details);
    
  }
 
  //$indetails = $instmt->fetch();

  //
  //print_r ($rowCount);
  //print_r ($insql);
  //print_r ($indetails);
?>

</body>
</html>
