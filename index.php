<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>lab1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
    </head>

<body>

    <header class="header-container">
        <div class="header-flex">
            <div class="logo">Brooklyn Public Library</div>
            <div class="nav-container">
                <div class="nav-profile_btn">
                    <!-- <nav> -->
                    <ul class="nav justify-content-end nav-menu">
                        <li class="nav-li"><a href="#About">About</a></li>
                        <li class="nav-li"><a href="#Favorites">Favorites</a></li>
                        <li class="nav-li"><a href="#Coffe">Coffe&nbsp;shop</a></li>
                        <li class="nav-li"><a href="#Contacts">Contacts</a></li>
                        <li class="nav-li"><a href="#Librari">Librari&nbsp;card</a></li>
                    </ul>
                    <!-- </nav> -->
                    <div class="cart-button">
                    <a href="../pages/cart-view.php" class="btn btn-outline-dark position-relative">
                        🛒
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count" style="display: none;">
                            0
                        </span>
                    </a>
                </div>

                    <div class="profile-button">
                        <button class="profile-btn">
                            <img src="icons/icon_profile.svg" alt="profile button" />
                        </button>
                        <div class="dropdown-content">
                            <div class="headline-profile-btn">
                                <h4>Profile</h4>
                                <div class="br-prfl"></div>
                            </div>
                            <div class="prfl-btn-a-pos">
                                <a href="pages/profile.php">My profile</a>
                                <a href="#">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="main-container">
            <div class="welcom-page">
                <img src="/imgs/Welcome.jpg" />
            </div>
        </div>
        <section id="About">
            <div class="about-page">
                <div class="headline-page-flex">
                    <div class="headline-page">About</div>
                    <div class="br"></div>
                </div>
                <div class="description-page">
                    The Brooklyn Library is a free workspace, a large number
                    of books and
                    a cozy coffee shop inside
                </div>
                <div class="boxes-container">
                    <div class="boxes">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner ">
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center">
                                        <img src="/imgs/slider/image_1.jpg" alt="img1" />
                                        <img src="/imgs/slider/image_1.jpg" alt="img1" />
                                        <img src="/imgs/slider/image_1.jpg" alt="img1" />
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center">
                                        <img src="/imgs/slider/image_2.jpg" alt="img2" />
                                        <img src="/imgs/slider/image_2.jpg" alt="img2" />
                                        <img src="/imgs/slider/image_2.jpg" alt="img2" />
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center">
                                        <img src="/imgs/slider/image_3.jpg" alt="img3" />
                                        <img src="/imgs/slider/image_3.jpg" alt="img3" />
                                        <img src="/imgs/slider/image_3.jpg" alt="img3" />
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <section id="Favorites">
        <div class="favorites-page">
            <div class="headline-page-flex">
                <div class="headline-page">Favorites</div>
                <div class="br"></div>
            </div>
            <div class="favorites-form-descr">
                Pick favorites of season
            </div>
        <div class="favorites-content">
            <div class="form-btn-choose">
                <form class="form-seasons">
                    <div class="form-season_input-lable">
                        <input type="radio" id="winter" name="favorites_season" value="WINTER" checked>
                        <label for="winter">Winter</label>
                    </div>
                    <div class="form-season_input-lable">
                        <input type="radio" id="spring" name="favorites_season" value="SPRING">
                        <label for="spring">Spring</label>
                    </div>
                    <div class="form-season_input-lable">
                        <input type="radio" id="summer" name="favorites_season" value="SUMMER">
                        <label for="summer">Summer</label>
                    </div>
                    <div class="form-season_input-lable">
                        <input type="radio" id="autumn" name="favorites_season" value="AUTUMN">
                        <label for="autumn">Autumn</label>
                    </div>
                </form>
            </div>

            <!-- Пустые блоки для подгрузки книг -->
            <div id="block-winter" class="season-block" style="display:block;">
                <div class="card-books-container">
                    <div class="cards-books"></div>
                </div>
            </div>
            <div id="block-spring" class="season-block" style="display:none;">
                <div class="card-books-container">
                    <div class="cards-books"></div>
                </div>
            </div>
            <div id="block-summer" class="season-block" style="display:none;">
                <div class="card-books-container">
                    <div class="cards-books"></div>
                </div>
            </div>
            <div id="block-autumn" class="season-block" style="display:none;">
                <div class="card-books-container">
                    <div class="cards-books"></div>
                </div>
            </div>
        </div>
        </div>
        
        </section>
        <section id="Librari">
            <div class="library-card-page">
                <div class="library-card-container-flex">
                    <div class="librari-card-all">
                        <h3>Find your Library card</h3>
                        <div class="librari-card">
                            <div id="liveAlertPlaceholder"></div>
                          
                            <div class="form-card">
                            
                                <div class="form-input-card">
                                <h4>Brooklyn Public Library</h4>
                                    <div class="form-floating mb-3">
                                        <input type="text" id="card_name" class="form-control" placeholder="Reader's name">
                                        <label for="floatingInput">Reader's name</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" id="card_number" class="form-control" placeholder="Card number">
                                        <label for="floatingInput">Card number</label>
                                    </div>
                                </div>
                                <button type="button" class="card-btn btn btn-primary" id="searchBtn">Check the card</button>
                            </div>
                        </div>
                    </div>
                    <div class="get-a-reader-card-container">
                        <div class="get-a-reader-card">
                            <h3>Get a reader card</h3>
                            <p>You will be able to see a reader card after logging into account or you can register a new account</p>
                            <div class="login-btns">
                                <a href="../auth/login.php" class="btn btn-link">Log In</a>
                                <a href="../auth/register.php" class="btn btn-link">Register</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </section>
        <section id="Contacts">
            <div class="contacts-page">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2717.8784957034154!2d28.865473311665735!3d47.0622337710248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97ce00125f907%3A0xfc2e5ee00a6d3d6a!2z0KLQtdGF0L3QuNGH0LXRgdC60LjQuSDQo9C90LjQstC10YDRgdC40YLQtdGCINCc0L7Qu9C00L7QstGL!5e0!3m2!1sru!2s!4v1744038178474!5m2!1sru!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            

        </section>
    </main>
    <footer>
    </footer>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
  <div id="book-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toast-message">
        Book added to cart!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
    <script src="/scripts/loadbooks.js"></script>
    <script src="/scripts/block_favorites.js"></script>
    <script src="/scripts/dropdown-list.js"></script>
    <script src="/scripts/search_card.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="/scripts/script.js"></script>
</body>

</html>