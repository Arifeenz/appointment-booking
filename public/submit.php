<?php
require_once '../config/db.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];

// ตรวจสอบว่ามีการจองช่วงเวลานี้แล้วหรือยัง
$stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE date = ? AND time = ?");
$stmt->execute([$date, $time]);
$exists = $stmt->fetchColumn();

if ($exists) {
    echo "❌ มีการจองช่วงเวลานี้แล้ว กรุณาเลือกเวลาอื่น<br><br>";
    echo "<a href='index.php' style='
        display: inline-block;
        padding: 10px 20px;
        background-color: #f44336;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    '>📅 จองเวลาใหม่</a>";
    exit;
}

// บันทึกลงฐานข้อมูล
$stmt = $pdo->prepare("INSERT INTO appointments (name, phone, date, time) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $phone, $date, $time]);

echo "✅ จองนัดสำเร็จแล้ว!<br><br>";
echo "<a href='index.php' style='
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
'>🔙 กลับไปหน้าจอง</a>";
