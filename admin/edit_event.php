<?php
session_start();
require_once '../db.php';
requireAdminAuth();

session_start();
require_once '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$event_id = $_GET['id'];

// Get event data
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    
    $image = $event['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/img/';
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
    }
    
    $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, category = ?, location = ?, event_date = ?, image = ? WHERE id = ?");
    if ($stmt->execute([$title, $description, $category, $location, $event_date, $image, $event_id])) {
        header('Location: dashboard.php?success=1');
        exit();
    } else {
        $error = "حدث خطأ أثناء تعديل الفعالية";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل فعالية - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">لوحة التحكم</a>
            <div class="navbar-nav ms-auto">
                <a href="dashboard.php" class="btn btn-outline-light btn-sm">العودة للرئيسية</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">تعديل الفعالية</h1>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الفعالية</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $event['title'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الفعالية</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?= $event['description'] ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">التصنيف</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="ثقافة" <?= $event['category'] == 'ثقافة' ? 'selected' : '' ?>>ثقافة</option>
                            <option value="رياضة" <?= $event['category'] == 'رياضة' ? 'selected' : '' ?>>رياضة</option>
                            <option value="موسيقى" <?= $event['category'] == 'موسيقى' ? 'selected' : '' ?>>موسيقى</option>
                            <option value="عائلية" <?= $event['category'] == 'عائلية' ? 'selected' : '' ?>>عائلية</option>
                            <option value="تعليمية" <?= $event['category'] == 'تعليمية' ? 'selected' : '' ?>>تعليمية</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="location" class="form-label">المكان</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?= $event['location'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="event_date" class="form-label">تاريخ الفعالية</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" value="<?= $event['event_date'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الفعالية</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <?php if($event['image']): ?>
                            <div class="mt-2">
                                <img src="../assets/img/<?= $event['image'] ?>" alt="Current image" width="100">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">تحديث الفعالية</button>
                    <a href="dashboard.php" class="btn btn-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>