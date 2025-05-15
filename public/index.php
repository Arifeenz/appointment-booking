<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Booking</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h1>จองนัดหมาย</h1>
  <form action="submit.php" method="post">
    <input type="text" name="name" placeholder="ชื่อของคุณ" required><br>
    <input type="tel" name="phone" placeholder="เบอร์โทร" required><br>
    <input type="date" name="date" required><br>
    <input type="time" name="time" required><br>
    <button type="submit">จองนัด</button>
  </form>
</body>
</html>
