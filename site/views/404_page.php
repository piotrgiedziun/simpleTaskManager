<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>404 page</title>
  <style>
    .error {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center; 
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('<?=base_url();?>assets/images/error.png');
    }
  </style>
</head>

<body>
    <p class="error"><?=isset($message)?$message:'Page you entered does not exists'; ?></p>
</body>

</html>