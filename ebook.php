<?php
if (isset($_POST['name']) && isset($_POST['email'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];

  // Generate PDF file with name and email
  $pdf = new TCPDF("./bat/e-book.pdf");
  $pdf->AddPage("./bat/e-book.pdf");
  $pdf->SetFont('times', './bat/e-book.pdf', 12);
  $pdf->Cell(0, 10, "Name: $name\nEmail: $email", 0, 1);
  $pdfData = $pdf->Output('document.pdf', 'S');

  // Send email with user info and PDF attachment
  $to = 'noam@nsmprime.com';
  $subject = 'User Info';
  $message = "Name: $name\nEmail: $email";
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n\r\n";
  $body = "--boundary\r\n";
  $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
  $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
  $body .= "$message\r\n\r\n";
  $body .= "--boundary\r\n";
  $body .= "Content-Type: application/pdf; name=\"document.pdf\"\r\n";
  $body .= "Content-Disposition: attachment; filename=\"e-book.pdf\"\r\n";
  $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
  $body .= chunk_split(base64_encode($pdfData)) . "\r\n\r\n";
  $body .= "--boundary--";
  mail($to, $subject, $body, $headers);

  // Display thank you message
  echo "Thank you for submitting the form!";

  // Return PDF file to user
  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename="e-book.pdf"');
  header('Content-Length: ' . strlen($pdfData));
  echo $pdfData;

  // Stop executing the script to prevent the form from being displayed again
  exit;
}
?>
