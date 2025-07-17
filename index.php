<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookVoyage - Online Book Review & Recommendation System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: lightgray;" >
    <!-- Colorful Navbar with Hover Effects -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-book-open me-2"></i> Book Review and Recommendation System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html"><i class="fas fa-home me-1"></i> Home</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="about.html"><i class="fas fa-info-circle me-1"></i> About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html"><i class="fas fa-envelope me-1"></i> Contact</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-lg-2" href="admin-login.php"><i class="fas fa-user-plus me-1"></i>Admin Login</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-light" href="user-login.php"><i class="fas fa-sign-in-alt me-1"></i>User Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Discover Your Next Favorite Book</h1>
                    <p class="lead mb-4">Join thousands of readers in exploring, reviewing, and getting personalized book recommendations based on your reading preferences.</p>
                    <div class="d-flex gap-3">
                        <a href="user-register.php" class="btn btn-primary btn-lg px-4"> Register With Us</a>
                        
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Books" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>
    <BR><br>
<section>
   <!-- Feature Section -->
<div class="container section text-center">
  <div class="row g-4">
    <div class="col-md-4">
      <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
      <h4>User Registration</h4>
      <p>Sign up to share your book experiences with others.</p>
    </div>
    <div class="col-md-4">
      <i class="fas fa-star fa-3x text-warning mb-3"></i>
      <h4>Rate & Review</h4>
      <p>Give ratings and write reviews for books you've read.</p>
    </div>
    <div class="col-md-4">
      <i class="fas fa-thumbs-up fa-3x text-success mb-3"></i>
      <h4>Get Recommendations</h4>
      <p>Get book suggestions tailored to your taste.</p>
    </div>
  </div>
</div>
</section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Start Your Reading Journey?</h2>
            <p class="lead mb-4">Join our community of book lovers today and discover your next favorite read.</p>
            <a href="user-register.php" class="btn btn-light btn-lg px-4 me-2"><i class="fas fa-user-plus me-2"></i> Sign Up Free</a>
            <a href="user/book-catalog.php" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-book-open me-2"></i> Browse Books</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h3 class="h5 fw-bold mb-3"><i class="fas fa-book-open me-2"></i>BookVoyage</h3>
                    <p>Your ultimate destination for book reviews, recommendations, and literary discussions. Join our community of passionate readers.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-goodreads"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h4 class="h6 fw-bold mb-3">Quick Links</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white-50">Home</a></li>
                        <li class="mb-2"><a href="#features" class="text-white-50">Features</a></li>
                        <li class="mb-2"><a href="#trending" class="text-white-50">Trending</a></li>
                        <li class="mb-2"><a href="about.html" class="text-white-50">About</a></li>
                        <li class="mb-2"><a href="contact.html" class="text-white-50">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h4 class="h6 fw-bold mb-3">Categories</h4>
                    <ul class="list-unstyled">

                        <li class="mb-2"><a href="#" class="text-white-50">Fiction</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Non-Fiction</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Mystery</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Science Fiction</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Biography</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h4 class="h6 fw-bold mb-3">Newsletter</h4>
                    <p>Subscribe to get updates on new releases and recommendations.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">&copy; 2023 BookVoyage. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">
                        <a href="#" class="text-white-50 me-2">Privacy Policy</a>
                        <a href="#" class="text-white-50">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
