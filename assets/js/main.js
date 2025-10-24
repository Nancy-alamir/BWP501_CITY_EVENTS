// Main JavaScript for City Events Guide

document.addEventListener('DOMContentLoaded', function() {
    // Contact Form Handling
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (this.checkValidity()) {
                const formData = new FormData(this);
                const messageDiv = document.getElementById('formMessage');
                
                // Simulate form submission
                messageDiv.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم إرسال رسالتك بنجاح! سنقوم بالرد عليك في أقرب وقت ممكن.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                this.reset();
                this.classList.remove('was-validated');
            } else {
                this.classList.add('was-validated');
            }
        });
    }

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Event date formatting
    function formatEventDate(dateString) {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            weekday: 'long'
        };
        const date = new Date(dateString);
        return date.toLocaleDateString('ar-SA', options);
    }

    // Update all event dates on the page
    document.querySelectorAll('.event-date').forEach(element => {
        const originalDate = element.textContent;
        element.textContent = formatEventDate(originalDate);
    });

    // Image lazy loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Add to calendar functionality
    window.addToCalendar = function(eventId, eventTitle, eventDate, eventLocation) {
        // This is a simplified version - in a real app, you'd use a proper calendar API
        const eventData = {
            title: eventTitle,
            start: eventDate,
            location: eventLocation
        };
        
        // For demonstration, just show an alert
        alert(`تمت إضافة "${eventTitle}" إلى التقويم الخاص بك`);
        
        // In a real implementation, you might use:
        // - Google Calendar API
        // - Outlook Calendar API
        // - iCal format download
    };

    // Share event functionality
    window.shareEvent = function(eventTitle, eventUrl) {
        if (navigator.share) {
            navigator.share({
                title: eventTitle,
                url: eventUrl
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            prompt('انسخ الرابط لمشاركته:', eventUrl);
        }
    };

    // Search functionality for events page
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const eventCards = document.querySelectorAll('.event-card');
            
            eventCards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const description = card.querySelector('.card-text').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Category filter animation
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.querySelector('h5').textContent;
            window.location.href = `events.php?category=${encodeURIComponent(category)}`;
        });
    });

    // Back to top button
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '↑';
    backToTopButton.className = 'btn btn-primary back-to-top';
    backToTopButton.style.cssText = `
        position: fixed;
        bottom: 20px;
        left: 20px;
        display: none;
        z-index: 1000;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 20px;
    `;
    
    document.body.appendChild(backToTopButton);

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Utility function for date formatting
function formatArabicDate(dateString) {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long'
    };
    return date.toLocaleDateString('ar-SA', options);
}

// Utility function for time remaining
function getTimeRemaining(eventDate) {
    const now = new Date();
    const event = new Date(eventDate);
    const diff = event - now;
    
    if (diff < 0) {
        return 'انتهت الفعالية';
    }
    
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    
    if (days > 0) {
        return `متبقي ${days} يوم و ${hours} ساعة`;
    } else {
        return `متبقي ${hours} ساعة`;
    }
}