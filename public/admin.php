<?php
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM appointments ORDER BY date, time");
$appointments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin - รายการนัดหมาย</title></head>
<body>
  <h1>รายการนัดหมายทั้งหมด</h1>
  <table border="1">
    <tr>
      <th>ชื่อ</th><th>เบอร์</th><th>วันที่</th><th>เวลา</th>
    </tr>
    <?php foreach ($appointments as $a): ?>
    <tr>
      <td><?= htmlspecialchars($a['name']) ?></td>
      <td><?= htmlspecialchars($a['phone']) ?></td>
      <td><?= $a['date'] ?></td>
      <td><?= $a['time'] ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
