<?php
require_once '../config/db.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// รับข้อมูลจากฟอร์ม
$name  = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$dateInput = $_POST['date']; // วันที่แบบ d/m/Y เช่น 15/05/2025
$time = $_POST['time'];

// ✅ แปลงวันที่จาก d/m/Y → Y-m-d (เพื่อบันทึกในฐานข้อมูล)
$dateParts = explode('/', $dateInput);
$date = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"; // 2025-05-15

// ตรวจสอบเวลาซ้ำ
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
$stmt = $pdo->prepare("INSERT INTO appointments (name, phone, email, date, time) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$name, $phone, $email, $date, $time]);

// เริ่มการส่งอีเมลยืนยัน
$mail = new PHPMailer(true);

try {
    // ✅ เปิด Debug ได้ถ้าต้องการ (0 = ปิด, 2 = แสดง log)
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';

    // ตั้งค่า SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'youremail@gmail.com';        // ✅ อีเมลของคุณ
    $mail->Password   = 'your_app_password';          // ✅ App Password จาก Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('youremail@gmail.com', 'ระบบจองนัดหมาย');  // ต้องตรงกับ Username
    $mail->addAddress($email, $name);
    $mail->CharSet = 'UTF-8'; // ✅ เพื่อให้หัวข้อเป็นภาษาไทยไม่เพี้ยน

    // เนื้อหาอีเมล
    $mail->isHTML(false);
    $mail->Subject = '📅 ยืนยันการจองนัดหมาย';
    $mail->Body    = "เรียนคุณ $name,\n\nคุณได้จองนัดหมายสำเร็จ:\n📅 วันที่: $dateInput\n⏰ เวลา: $time\n📞 เบอร์โทร: $phone\n\nหากมีข้อสงสัยติดต่อทีมงาน\n\nขอบคุณที่ใช้บริการ";

    $mail->send();
    echo "✅ จองนัดสำเร็จแล้ว! ระบบได้ส่งอีเมลยืนยันไปยัง $email<br><br>";
} catch (Exception $e) {
    echo "✅ จองนัดสำเร็จแล้ว! ❗ แต่ไม่สามารถส่งอีเมลยืนยันได้<br>";
    echo "Error: {$mail->ErrorInfo}<br><br>";
}

// ปุ่มย้อนกลับ
echo "<a href='index.php' style='
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
'>🔙 กลับไปหน้าจอง</a>";
