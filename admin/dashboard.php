<?php
session_start();
require_once '../db.php';
requireAdminAuth();

// Get admin stats
$total_events = $pdo->query("SELECT COUNT(*) as total FROM events")->fetch()['total'];
$upcoming_events = $pdo->query("SELECT COUNT(*) as total FROM events WHERE event_date >= CURDATE()")->fetch()['total'];
$past_events = $pdo->query("SELECT COUNT(*) as total FROM events WHERE event_date < CURDATE()")->fetch()['total'];

// Get all events
$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();

// Get success/error messages
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - دليل فعاليات المدينة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: #34495e;
        }
        .stat-card {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3 text-center border-bottom">
                    <h5>لوحة التحكم</h5>
                    <small>دليل الفعاليات</small>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i>الرئيسية
                    </a>
                    <a class="nav-link" href="add_event.php">
                        <i class="fas fa-plus-circle me-2"></i>إضافة فعالية
                    </a>
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>عرض الموقع
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-auto">
                <!-- Top Navbar -->
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            مرحباً، <?= $_SESSION['admin_full_name'] ?> (<?= $_SESSION['admin_username'] ?>)
                        </span>
                        <div class="d-flex">
                            <a href="../index.php" class="btn btn-outline-primary btn-sm me-2" target="_blank">
                                <i class="fas fa-eye"></i> عرض الموقع
                            </a>
                            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card stat-card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4><?= $total_events ?></h4>
                                            <p>إجمالي الفعاليات</p>
                                        </div>
                                        <i class="fas fa-calendar-alt fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4><?= $upcoming_events ?></h4>
                                            <p>فعاليات قادمة</p>
                                        </div>
                                        <i class="fas fa-clock fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4><?= $past_events ?></h4>
                                            <p>فعاليات منتهية</p>
                                        </div>
                                        <i class="fas fa-history fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <?php if($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            تم تنفيذ العملية بنجاح!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            حدث خطأ أثناء تنفيذ العملية!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Events Table -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">إدارة الفعاليات</h5>
                            <a href="add_event.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> إضافة فعالية جديدة
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الصورة</th>
                                            <th>العنوان</th>
                                            <th>التصنيف</th>
                                            <th>التاريخ</th>
                                            <th>المكان</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($events as $event): 
                                            $is_past = strtotime($event['event_date']) < time();
                                            $status_class = $is_past ? 'bg-secondary' : 'bg-success';
                                            $status_text = $is_past ? 'منتهية' : 'قادمة';
                                        ?>
                                        <tr>
                                            <td><?= $event['id'] ?></td>
                                            <td>
                                                <img src="../assets/img/<?= $event['image'] ?>" 
                                                     alt="<?= $event['title'] ?>" 
                                                     width="50" height="50" 
                                                     style="object-fit: cover; border-radius: 5px;">
                                            </td>
                                            <td><?= $event['title'] ?></td>
                                            <td><span class="badge bg-primary"><?= $event['category'] ?></span></td>
                                            <td><?= $event['event_date'] ?></td>
                                            <td><?= $event['location'] ?></td>
                                            <td>
                                                <span class="badge <?= $status_class ?>"><?= $status_text ?></span>
                                            </td>
                                            <td>
                                                <a href="edit_event.php?id=<?= $event['id'] ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete_event.php?id=<?= $event['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('هل أنت متأكد من حذف هذه الفعالية؟')"
                                                   title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>