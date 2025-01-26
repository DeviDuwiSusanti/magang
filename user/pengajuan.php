<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="../assets/libraries/swiper-bundle.min.css" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/lowongan.css" />
    <style>
        .transparent-img {
            filter: grayscale(100%);
            opacity: 0.5;
        }

        .popular__card {
            position: relative;
        }

        .sold-out-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            font-style: italic;
            font-weight: bold;
            border-radius: 100px;
            z-index: 10;
        }
    </style>

    <title>Home</title>
</head>

<body>
    <?php include "../assets/layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section>
            <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                    <section class="islands swiper-slide">
                        <img src="./assets/img/bromo1.jpg" alt="" class="islands__bg" />

                        <div class="islands__container container">
                            <div class="islands__data">
                                <h1 class="islands__title">Learn More About Our Internship Website</h1>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <!--==================== POPULAR ====================-->
        <section class="section" id="popular">
            <div class="container">
                <h2 class="section__title" style="text-align: center">
                    With Our Experience </br> We Will Serve You
                </h2></br>

                <!---========== Text and image layout=======-->
                <div class="custom-container">
                    <!-- Center Text -->
                    <div class="center-text">
                        <div class="text-block">
                            <p class="large-text">6</p>
                            <p class="small-text">Year Experience</p>
                        </div>
                        <div class="text-block">
                            <p class="large-text">+950</p>
                            <p class="small-text">Complete Tours</p>
                        </div>
                        <div class="text-block">
                            <p class="large-text">6</p>
                            <p class="small-text">Destination</p>
                        </div>
                    </div>
                    <!-- Image Row -->
                    <div class="image-row">
                        <!-- Left Portrait Image -->
                        <div class="left-column">
                            <img src="../assets/img/pw2.jpg" alt="Left Portrait Image" class="custom-image">
                        </div>
                        <!-- Right Portrait Image -->
                        <div class="right-column">
                            <img src="../assets/img/pw1.jpg" alt="Right Portrait Image" class="custom-image">
                            <img src="../assets/img/pw3.jpg" alt="Bottom Portrait Image" class="custom-image image-spacing">
                        </div>
                    </div>
                </div>

                <!--================ ABOUT INTERNSHIP WEBSITE =======================-->
                <h2 class="section__title" style="text-align: center">Learn More About Our Internship Website</h2>
                <div class="popular__all">
                    <article class="popular__card">
                        <img src="assets/img/internship.png" alt="" class="popular__img" />
                        <div class="popular__data">
                            <h2 class="popular__price">Why Join Us?</h2>
                            <h3 class="popular__title">Enhance Your Skills</h3>
                            <p class="popular__description">
                                Explore opportunities to grow your technical and professional skills through real-world projects in our internship program.
                            </p><br>
                        </div>
                        <a href="about-us.php">
                            <button type="button" class="btn btn-outline-primary">Learn More</button>
                        </a>
                    </article>

                    <article class="popular__card">
                        <img src="assets/img/community.png" alt="" class="popular__img" />
                        <div class="popular__data">
                            <h2 class="popular__price">Join Our Community</h2>
                            <h3 class="popular__title">Collaborate & Network</h3>
                            <p class="popular__description">
                                Work alongside professionals and like-minded individuals while contributing to impactful projects.
                            </p><br>
                        </div>
                        <a href="community.php">
                            <button type="button" class="btn btn-outline-primary">Get Involved</button>
                        </a>
                    </article>
                </div>

                <!--================ PACKAGE =======================-->
                <h2 class="section__title" style="text-align: center">Explore Our Internship Opportunities</h2>
<div class="popular__all">
  <!-- Program Magang 1 -->
  <article class="popular__card">
    <img src="assets/img/web_development.png" alt="" class="popular__img" />
    <div class="popular__data">
      <h2 class="popular__price">Web Development</h2>
      <h3 class="popular__title">6-Month Internship Program</h3>
      <p class="popular__description">
        Join our team as a Web Developer intern to gain hands-on experience in designing and building responsive websites.
      </p><br>
    </div>
    <a href="detail-internship.php?id_internship=1">
      <button type="button" class="btn btn-outline-primary">Learn More</button>
    </a>
  </article>

  <!-- Program Magang 2 (Tutup) -->
  <article class="popular__card" style="opacity: 0.5;">
    <div class="sold-out-overlay">Closed</div>
    <img src="assets/img/data_science.png" alt="" class="popular__img transparent-img" />
    <div class="popular__data">
      <h2 class="popular__price">Data Science</h2>
      <h3 class="popular__title">3-Month Internship Program</h3>
      <p class="popular__description">
        Dive into the world of data analysis and machine learning as part of our Data Science internship program.
      </p><br>
    </div>
    <button type="button" class="btn btn-outline-primary" disabled>Learn More</button>
  </article>

  <!-- Program Magang 3 -->
  <article class="popular__card">
    <img src="assets/img/ui_ux_design.png" alt="" class="popular__img" />
    <div class="popular__data">
      <h2 class="popular__price">UI/UX Design</h2>
      <h3 class="popular__title">4-Month Internship Program</h3>
      <p class="popular__description">
        Enhance your skills in user interface and user experience design by working on real-world projects.
      </p><br>
    </div>
    <a href="detail-internship.php?id_internship=3">
      <button type="button" class="btn btn-outline-primary">Learn More</button>
    </a>
  </article>
</div>

        </section>

        <?php include "../assets/layout/footerUser.php" ?>
    </main>
</body>

</html>
