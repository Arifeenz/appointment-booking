<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Booking</title>
  <link rel="stylesheet" href="../css/style.css">
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
  <h1>จองนัดหมาย</h1>

  <form action="submit.php" method="post">
    <input type="text" name="name" placeholder="ชื่อของคุณ" required><br>
    <input type="tel" name="phone" placeholder="เบอร์โทร" required><br>
    <input type="email" name="email" placeholder="อีเมล" required><br>

    <label for="date">เลือกวันที่:</label><br>
    <input type="text" id="date" name="date" required><br>

    <label for="time">เลือกเวลา:</label><br>
    <input type="time" id="time" name="time" required><br>

    <button type="submit">จองนัด</button>
  </form>

  <!-- Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#date", {
      dateFormat: "d/m/Y"
    });
  </script>
</body>
</html>
