<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    header('Location: events.php');
    exit();
}

$event_id = $_GET['id'];

// Get event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: events.php');
    exit();
}

// Get related events
$related_events = $pdo->prepare("SELECT * FROM events WHERE category = ? AND id != ? LIMIT 3");
$related_events->execute([$event['category'], $event_id]);
$related = $related_events->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $event['title'] ?> - دليل فعاليات المدينة</title>
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
                    <li class="nav-item"><a class="nav-link" href="events.php">الفعاليات</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">من نحن</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <img src="assets/img/<?= $event['image'] ?>" class="card-img-top" alt="<?= $event['title'] ?>">
                    <div class="card-body">
                        <span class="badge bg-primary mb-3"><?= $event['category'] ?></span>
                        <h1 class="card-title"><?= $event['title'] ?></h1>
                        <div class="event-meta mb-4">
                            <p><strong>📅 التاريخ:</strong> <?= $event['event_date'] ?></p>
                            <p><strong>📍 المكان:</strong> <?= $event['location'] ?></p>
                        </div>
                        <div class="event-description">
                            <p><?= nl2br($event['description']) ?></p>
                        </div>
                        <div class="event-actions mt-4">
                            <button class="btn btn-success" onclick="addToCalendar()">أضف للتقويم</button>
                            <button class="btn btn-info" onclick="shareEvent()">شارك الفعالية</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Events -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>فعاليات ذات صلة</h5>
                    </div>
                    <div class="card-body">
                        <?php if(count($related) > 0): ?>
                            <?php foreach($related as $related_event): ?>
                            <div class="mb-3">
                                <h6><?= $related_event['title'] ?></h6>
                                <p class="small text-muted"><?= $related_event['event_date'] ?></p>
                                <a href="event.php?id=<?= $related_event['id'] ?>" class="btn btn-sm btn-outline-primary">التفاصيل</a>
                            </div>
                            <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">لا توجد فعاليات ذات صلة</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>جميع الحقوق محفوظة &copy; 2025 دليل فعاليات المدينة</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
    function addToCalendar() {
        alert('تم إضافة الفعالية إلى التقويم');
    }
    
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '<?= $event['title'] ?>',
                text: '<?= substr($event['description'], 0, 100) ?>',
                url: window.location.href
            });
        } else {
            alert('شارك الرابط: ' + window.location.href);
        }
    }
    </script>
</body>
</html>