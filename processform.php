<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get form values
$firstName = test_input($_POST["firstName"]);
$lastName = test_input($_POST["lastName"]);
$email = test_input($_POST["email"]);
$emailConfirmation = test_input($_POST["emailConfirmation"]);
$acceptTerms = test_input($_POST["acceptTerms"]);

// Validate form data
if (empty($firstName) || empty($lastName) || empty($email) || empty($emailConfirmation) || empty($acceptTerms)) {
    http_response_code(400);
    echo "Please fill in all required fields.";
    exit;
} else {
    //Check Email Format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    } else {
        //Check Emails Match
        if ($email != $emailConfirmation) {
            http_response_code(400);
            echo "Email addresses do not match.";
            exit;
        } else {
            // Upload profile picture
            if (isset($_FILES["profilePicture"])) {
                $file = $_FILES['profilePicture'];
                $fileName = $_FILES["profilePicture"]["name"];
                $fileType = $_FILES["profilePicture"]["type"];
                $fileSize = $_FILES["profilePicture"]["size"];
                $fileTmpName = $_FILES["profilePicture"]["tmp_name"];
                $fileError = $_FILES["profilePicture"]["error"];

                $fileExtension = "";
                $fileExt = explode('.', $fileName);
                $fileExtension = strtolower(end($fileExt));

                // Check file type
                $allowedTypes = array("jpg", "jpeg", "png", "gif");
                if (!in_array($fileExtension, $allowedTypes)) {
                    http_response_code(400);
                    echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
                    exit;
                } else {
                    // Check file size
                    $maxFileSize = 5 * 1024 * 1024; // 5 MB
                    if ($fileSize > $maxFileSize) {
                        http_response_code(400);
                        echo "File size must be less than 5 MB.";
                        exit;
                    } else {
                        //Check for error
                        if($fileError !== 0) {
                            http_response_code(400);
                            echo "There was an error uploading the file";
                            exit;
                        } else {
                            // Save file
                            $filePath = 'images/' . uniqid('', true) . "." . $fileExtension;
                            if (!$fileError === 0) {
                            http_response_code(500);
                            echo "Failed to upload file.";
                            exit;
                            } else {
                            move_uploaded_file($fileTmpName, $filePath);

                            // Database connection
                            $conn = new mysqli('localhost','root','','formData');
                            if($conn->connect_error){
                            echo "$conn->connect_error";
                            die("Connection Failed : ". $conn->connect_error);
                            } else {
                                $stmt = $conn->prepare("insert into Registration(firstName, lastName, email) values(?, ?, ?)");
                                $stmt->bind_param("sss", $firstName, $lastName, $email);
                                $execval = $stmt->execute();
                                $stmt->close();
                                $conn->close();


                                // Send email notification
                                $to = "recipient@example.com";
                                $subject = "New form submission from " . $firstName . " " . $lastName;
                                $message = "A new form submission has been received from " . $firstName . " " . $lastName . ".\n\n" .
                                        "Email: " . $email . "\n";
                                $headers = "From: sender@example.com";

                                if (mail($to, $subject, $message, $headers)) {
                                    // Redirect to success page
                                    header("Location: success.php");
                                } else {
                                    echo "Failed to send email notification.";
                                }


                                
                            }
                            }
                        }
                    }
                }
            }
        }
    }
}
                            