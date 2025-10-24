<?php
session_start();
require_once 'db.php';

// Get filter parameters
$category = $_GET['category'] ?? '';
$date = $_GET['date'] ?? '';

// Build query
$sql = "SELECT * FROM events WHERE 1=1";
$params = [];

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

if (!empty($date)) {
    $sql .= " AND event_date = ?";
    $params[] = $date;
}

$sql .= " ORDER BY event_date ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll();

// Get unique categories for filter
$categories = $pdo->query("SELECT DISTINCT category FROM events")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الفعاليات - دليل فعاليات المدينة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">دليل الفعاليات</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link active" href="events.php">الفعاليات</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">من نحن</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">جميع الفعاليات</h1>
        
        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">التصنيف</label>
                        <select name="category" class="form-select">
                            <option value="">جميع التصنيفات</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['category'] ?>" <?= $category == $cat['category'] ? 'selected' : '' ?>>
                                    <?= $cat['category'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">التاريخ</label>
                        <input type="date" name="date" class="form-control" value="<?= $date ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">تصفية</button>
                        <a href="events.php" class="btn btn-outline-secondary">إعادة تعيين</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row">
            <?php if(count($events) > 0): ?>
                <?php foreach($events as $event): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="assets/img/<?= $event['image'] ?>" class="card-img-top" alt="<?= $event['title'] ?>">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?= $event['category'] ?></span>
                            <h5 class="card-title"><?= $event['title'] ?></h5>
                            <p class="card-text"><?= substr($event['description'], 0, 100) ?>...</p>
                            <p class="text-muted">
                                <strong>التاريخ:</strong> <?= $event['event_date'] ?><br>
                                <strong>المكان:</strong> <?= $event['location'] ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="event.php?id=<?= $event['id'] ?>" class="btn btn-primary">التفاصيل</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">لا توجد فعاليات متاحة</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>جميع الحقوق محفوظة &copy; 2025 دليل فعاليات المدينة</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>