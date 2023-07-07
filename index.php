<?php
$insert = false;
if(isset($_POST['name'])){
    $server = "localhost";
    $username ="root";
    $password = "";
    $database = "trip";
    
    $con = mysqli_connect($server , $username, $password, $database);
    
    if(!$con){
        die("Connection to the database failed due to" . mysqli_connect_error());
    }
    
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];
    
    $sql = "INSERT INTO trip.trip (`name`, `age`, `gender`, `email`, `phone`, `other`, `dt`)
            VALUES ('$name', '$age', '$gender', '$email', '$phone', '$desc', current_timestamp());";
    
    if($con->query($sql) == true){
        $insert = true;
        echo "success";
    }
    else{
        echo "ERROR: $sql <br> $con->error ";
    }
    
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to travel form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bacasime+Antique&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <img class="bg" src="bg.jpg" alt="scenery">
    <div class="container">
        <h1>Welcome to Nashik trip</h1>
        <p>Please enter your details below</p>
        <?php 
        if ($insert == true) {
            echo "<p class='SubmitMsg'>Thank you for showing interest, we will contact you as soon as possible regarding further details </p>";
        }
        ?>
        <form id="travelForm" action="index.php" method="post" onsubmit="return validateForm()">
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <input type="text" name="gender" id="gender" placeholder="Enter your age">
            <input type="text" name="age" id="age" placeholder="Enter your gender">
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <input type="tel" name="phone" id="phone" placeholder="Enter your phone">
            <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Enter any other info here"></textarea>
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>

    <script>
  function validateForm() {
    var name = document.getElementById('name').value;
    var gender = document.getElementById('gender').value;
    var age = document.getElementById('age').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;

    if (name === '' || gender === '' || age === '' || email === '' || phone === '') {
      alert('Please fill in all the fields.');
      return false;
    }

    if (!emailIsValid(email)) {
      alert('Please enter a valid email address.');
      return false;
    }

    if (!phoneIsValid(phone)) {
      alert('Please enter a valid phone number.');
      return false;
    }

    return true;
  }

  function emailIsValid(email) {
    // Use regular expression to validate email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function phoneIsValid(phone) {
    // Remove non-digit characters from phone number
    var cleanedPhone = phone.replace(/\D/g, '');

    // Check if the cleaned phone number is 10 digits long
    return cleanedPhone.length === 10;
  }
</script>


<script>
  function submitForm() {
    var form = document.getElementById('travelForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText;
        // Handle the response from the server
        if (response === 'success') {
          form.reset();
          alert('Form submitted successfully!');
        } else {
          alert('thanks for submitting the form.');
        }
      }
    };
    xhr.send(formData);
  }

  document.getElementById('travelForm').addEventListener('submit', function (e) {
    e.preventDefault();
    if (validateForm()) {
      submitForm();
    }
  });
</script>

</body>
</html>
