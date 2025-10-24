<?php
session_start();
require_once 'db.php';

// Get featured events for the slider
$featured_events = $pdo->query("SELECT * FROM events ORDER BY event_date LIMIT 5")->fetchAll();

// Get latest events
$latest_events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 6")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل فعاليات المدينة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">دليل الفعاليات</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">الفعاليات</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">من نحن</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/login.php">تسجيل الدخول</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white text-center py-5 position-relative">
    <!-- Background Image with Overlay -->
    <div class="hero-background position-absolute top-0 start-0 w-100 h-100">
        <img src="assets/img/hero-bg.jpg" alt="خلفية الفعاليات" class="w-100 h-100" style="object-fit: cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-60"></div>
    </div>
    
    <!-- Content -->
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">دليل فعاليات المدينة</h1>
                <p class="lead fs-3 mb-5 animate__animated animate__fadeInUp animate__delay-1s">اكتشف أفضل الفعاليات والأنشطة في مدينتك</p>
                
                <!-- Call to Action Buttons -->
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="events.php" class="btn btn-primary btn-lg me-3 px-4 py-2">
                        <i class="fas fa-calendar-alt me-2"></i>استعرض الفعاليات
                    </a>
                    <a href="#featured-events" class="btn btn-outline-light btn-lg px-4 py-2">
                        <i class="fas fa-star me-2"></i>الفعاليات البارزة
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-3">
        <a href="#featured-events" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="mb-2">اكتشف المزيد</span>
                <i class="fas fa-chevron-down animate__animated animate__bounce animate__infinite"></i>
            </div>
        </a>
    </div>
</section>

    <!-- Featured Events Slider -->
    <section class="py-5" id="featured-events">
        <div class="container">
            <h2 class="text-center mb-4">فعاليات بارزة هذا الأسبوع</h2>
            <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($featured_events as $index => $event): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card">
                            <img src="assets/img/<?= $event['image'] ?>" class="card-img-top" alt="<?= $event['title'] ?>">
                            <?php
                            ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= $event['title'] ?></h5>
                                <p class="card-text"><?= substr($event['description'], 0, 100) ?>...</p>
                                <a href="event.php?id=<?= $event['id'] ?>" class="btn btn-primary">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Quick Categories -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">التصنيفات</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 bg-white rounded shadow">
                        <h5>ثقافة</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 bg-white rounded shadow">
                        <h5>رياضة</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 bg-white rounded shadow">
                        <h5>موسيقى</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 bg-white rounded shadow">
                        <h5>عائلية</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Events -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">أحدث الفعاليات</h2>
            <div class="row">
                <?php foreach($latest_events as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets/img/<?= $event['image'] ?>" class="card-img-top" alt="<?= $event['title'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $event['title'] ?></h5>
                            <p class="card-text"><?= substr($event['description'], 0, 80) ?>...</p>
                            <p class="text-muted"><?= $event['event_date'] ?> - <?= $event['location'] ?></p>
                            <a href="event.php?id=<?= $event['id'] ?>" class="btn btn-outline-primary">التفاصيل</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
	
    <!-- Footer -->
    <!--
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>دليل فعاليات المدينة</h5>
                    <p>اكتشف أفضل الفعاليات في مدينتك</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>تواصل معنا: info@cityevents.com</p>
                    <p>جميع الحقوق محفوظة &copy; 2025</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>فريق العمل: أحمد، محمد، فاطمة، سارة، خالد</p>
            </div>
        </div>
    </footer>
	-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>