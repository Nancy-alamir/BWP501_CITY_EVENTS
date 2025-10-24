<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اتصل بنا - دليل فعاليات المدينة</title>
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
                    <li class="nav-item"><a class="nav-link active" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center mb-4">اتصل بنا</h1>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="contactForm" novalidate>
                            <div id="formMessage"></div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">يرجى إدخال الاسم</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صحيح</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                <div class="invalid-feedback">يرجى إدخال الرسالة</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">إرسال الرسالة</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>معلومات التواصل</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>البريد الإلكتروني:</strong> info@cityevents.com</p>
                        <p><strong>وسائل التواصل الاجتماعي:</strong></p>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary me-2">فيسبوك</a>
                            <a href="#" class="btn btn-outline-info me-2">تويتر</a>
                            <a href="#" class="btn btn-outline-danger">انستغرام</a>
                        </div>
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
</body>
</html>