<!DOCTYPE html>
<head>
  <title>COVID-19 questionnaire | Processing</title>
  <link rel = "stylesheet"
    type = "text/css"
    href = "stylesheet.css" />
  <link rel='shortcut icon' href='favicon.ico' />
</head>
<body>
  <header id='header'>
    <div id='logo' itemscope itemtype='https://schema.org/Organization'>
      <img src='logo.svgz' alt='Pullman &amp; Comley LLC' />
    </div>
  </header>
  <h1>Please wait</h1>
  <h2>We're processing your data now</h2>
  <?php
  # Function to prevent XSS attacks
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  # Pull in data from the form
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
  $location = test_input($POST["locationSelect"])
  $timestamp = date("y/m/d");

  if ($location == "Working remotely") {
    $symptoms = $contact = $cluster = $internationalTravel = $risk = $interstateTravel = $tempCert = "Not applicable";
  }
  else {
    $symptoms = $_POST["symptomsCheck"];
    $contact = $_POST["contactCheck"];
    $cluster = $_POST["clusterCheck"];
    $internationalTravel = $_POST["internationalTravelCheck"];
    $risk = $_POST["riskCheck"];
    $interstateTravel = $_POST["interstateTravelCheck"];
    $tempCert = $_POST["tempCertification"];
  }

  # Set up email infomation
  $to = "contacttrace@pullcom.com";
  $subject = "COVID-19 questionnaire from " . $firstName . $lastName;
  $message = 
  "Date: " . $timestamp .
  "\r\nCOVID-19 symptoms: " . $symptoms .
  "\r\nContact with COVID-19 patients: " . $contact .
  "\r\nContact with infection clusters: " . $cluster .
  "\r\nInternational Travel: " . $internationalTravel .
  "\r\nVisit to high-risk area: " . $risk .
  "\r\nInterstate public transit: " . $interstateTravel .
  "\r\nTemperature Certification: " . $tempCert;

  # Check for affirmative answers
  if($symptoms == "Yes" || $contact == "Yes" || $cluster == "Yes" || $internationalTravel == "Yes" || $risk == "Yes" || $interstateTravel == "Yes") {
    $subject .= " High Priority";
  }

  # Attempt to mail (note that your server needs to suport the mail function)
  try{
    mail($to, $subject, $message);
    header("Location: complete.html");
  }
  catch{
    echo "Error. Please try again."
  }
  ?>
</body>
