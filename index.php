<?php
require_once __DIR__ . '/infra/middlewares/middleware-not-authenticated.php';
#require_once __DIR__ . '/setupdatabase.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BuyTime</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
	
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./assets/images/logoF.png" alt="BuyTime">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="Auth">
                <a href="/BuyTime/pages/public/login.php" class="btn btn-color me-2">Login</a>
                <a href="/BuyTime/pages/public/register.php" class="btn btn-color ms-2">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">Welcome to buytime
                    </h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">Transform your tasks. Elevate your
                        efficiency. Unleash success.</h5>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <a href="/BuyTime/pages/public/login.php" class="btn btn-brand me-2">Get Started</a>
                        <a href="#team" class="btn btn-brand ms-2">Our Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="50">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">About us</h1>
                        <div class="line"></div>
                        <p>Welcome to AS, where we redefine personal productivity.
                            Our platform simplifies task management, empowering you to effortlessly
                            achieve your individual goals.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6" data-aos="fade-down" data-aos-delay="50">
                    <img src="./assets/images/about.png" alt="">
                </div>
                <div data-aos="fade-down" data-aos-delay="150" class="col-lg-5">
                    <h1>About BuyTime</h1>
                    <p class="mt-3 mb-4">Introducing BuyTime, our innovative tool designed for your personal success.
                        Invest your time wisely, collaborate effortlessly, and elevate your productivity.</p>
                    <div class="d-flex pt-4 mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-task-line"></i>
                        </div>
                        <div>
                            <h5>Simplify Your Tasks</h5>
                            <p>Our user-friendly platform makes personal task management a breeze.
                                Stay organized and make the most of your day with ease!</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-user-smile-fill"></i>
                        </div>
                        <div>
                            <h5>Boost Your Personal Productivity</h5>
                            <p>Take control of your success journey. Our tools are designed to enhance
                                your personal efficiency and productivity effortlessly!</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="iconbox me-4">
                            <i class="ri-rocket-2-fill"></i>
                        </div>
                        <div>
                            <h5>Time is Your Asset</h5>
                            <p>In your world, time is invaluable. Our platform maximizes your personal
                                productivity with timely reminders and intuitive task tracking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Awesome Services</h1>
                        <div class="line"></div>
                        <p>Discover how our application simplifies task management to make your life easier.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-6 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-organization-chart"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Intuitive Task Management</h5>
                        <p>Organize your tasks in an intuitive and simplified way, ensuring efficient management.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-team-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Collaborative Workspace</h5>
                        <p>Enhance teamwork by collaborating on projects, assigning tasks, and tracking progress in
                            real-time.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-notification-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Smart Notifications</h5>
                        <p>Stay informed with personalized notifications, ensuring you never miss a deadline or
                            important update.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-bar-chart-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">See Your Productivity</h5>
                        <p>Visualize and track your productivity metrics effortlessly, gaining insights for enhanced
                            efficiency.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section id="team" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Team Members</h1>
                    </div>
                </div>
                <div class="row g-4 text-center ">
                    <div class="col-md-4 mx-auto mb-4" data-aos="fade-down" data-aos-delay="150">
                        <div class="team-member image-zoom">
                            <div class="image-zoom-wrapper">
                                <img src="./assets/images/afonso.jpg" alt="">
                            </div>
                            <div class="team-member-content">
                                <h4 class="text-white">Afonso Faria</h4>
                                <p class="mb-0 text-white">Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mx-auto mb-4" data-aos="fade-down" data-aos-delay="250">
                        <div class="team-member image-zoom">
                            <div class="image-zoom-wrapper">
                                <img src="./assets/images/soniahelp.jpg" alt="">
                            </div>
                            <div class="team-member-content">
                                <h4 class="text-white">Sónia Soares</h4>
                                <p class="mb-0 text-white">Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- CONTACT -->
    <section class="section-padding bg-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Get in touch</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">Got a spark of inspiration or a burning question? Don't hesitate to drop
                            us a line! We're all ears and ready to dive into any ideas or queries you might have. Your
                            thoughts matter to us, so fire away and let's get in touch!</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-8">
                    <form action="#" class="row g-3 p-lg-5 p-4 bg-white theme-shadow">
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" placeholder="Enter last name">
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="email" class="form-control" placeholder="Enter Email address">
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="text" class="form-control" placeholder="Enter subject">
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea name="message" rows="5" class="form-control"
                                placeholder="Enter Message"></textarea>
                        </div>
                        <div class="form-group col-lg-12 d-grid">
                            <button class="btn btn-brand">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark">
        <div class="footer">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <a href="#"><img src="./assets/images/logoW.png" alt=""></a>
                        <div class="line"></div>
                        <p>Transform your tasks. Elevate your efficiency. Unleash success!</p>
                        <div class="social-icons">
                            <a href="#"><i class="ri-twitter-x-fill"></i></a>
                            <a href="#"><i class="ri-instagram-fill"></i></a>
                            <a href="#"><i class="ri-github-fill"></i></a>
                            <a href="#"><i class="ri-dribbble-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SERVICES</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">Intuitive Task Management</a></li>
                            <li><a href="#">Collaborative Workspace</a></li>
                            <li><a href="#">Smart Notifications</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">AFONSO</h5>
                        <div class="line"></div>
                        <p>Afonso Faria</p>
                        <div class="social-icons">
                            <a href="https://github.com/IFero04" target="_blank"><i class="ri-github-fill"></i></a>
                            <a href="#" target="_blank"><i class="ri-linkedin-box-fill"></i></a>
                            <a href="https://www.instagram.com/faria_afonso/" target="_blank"><i
                                    class="ri-instagram-fill"></i></a>
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SÓNIA</h5>
                        <div class="line"></div>
                        <p>Sónia Soares</p>
                        <div class="social-icons">
                            <a href="https://github.com/Sonia227" target="_blank"><i class="ri-github-fill"></i></a>
                            <a href="#" target="_blank"><i class="ri-linkedin-box-fill"></i></a>
                            <a href="https://www.instagram.com/sonia.costa227/" target="_blank"><i
                                    class="ri-instagram-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>

