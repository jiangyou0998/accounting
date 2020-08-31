<!doctype html>
<html lang="en">
<head>
    <title>KingBakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>
<body>
<!-- BEGIN -->
<div class="wrapper-content">
    <!-- Header-top -->
    <div class="menu fixed-top">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-4">
                        <ul class="list-social row">
                            <li><a href=""><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus-official" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 col-4 text-center">
                        <span class="time-open">Opening hours: 9:00am - 10:00pm </span>
                    </div>
                    <div class="col-sm-4 col-4 login-reg">
                        <div class="login-reg-inner">
                            <span><i class="fa fa-user    "></i><a href="MuseExport/đkk.html" class="login">LOGIN</a></span>   |   <span><i class="fa fa-lock   "></i><a href="MuseExport/đkk-copy.html" class="reg">REGISTER</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        @include('layouts._nav')
    </div>
    <!-- Banner Intro -->
    <div id="slide" class="carousel slide" data-ride="carousel" data-interval="false">
        <ol class="carousel-indicators button-click">
            <li data-target="#slide" data-slide-to="0" class="active"></li>
            <li data-target="#slide" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner _1slide" role="listbox">
            <div class="carousel-item active">
                <img src="images/home_bakery_slide_bg2.jpg" alt="First slide" class="img-responsive">
                <div class="carousel-caption caption center">
                    <div class="container">
                        <div class="col-sm-10 mx-auto">
                            <h1 class="text-uppercase">welcome to <span>kingbakery</span></h1>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias accusantium officia nostrum!</p>
                            <a href=""><button class="btn-danger text-uppercase order-button">quick order</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item _1slide">
                <img src="images/home_bakery_slide_bg1.jpg" alt="Second slide" class="img-responsive">
                <div class="carousel-caption caption2">
                    <div class="container">
                        <img class="info" src="images/1-01.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- services -->
    <section id="services">
        <div class="container">
            <div class="col-sm-6 col-md-6 col-12 title1 text-center mx-auto">
                <h3><span>Services</span></h3>

            </div>
            <ul class="row list-services">
                <li class="col-6 col-md-3 col-sm-6">
                    <div class="_1sv text-center">
                        <div class="interface">
                            <span><i class="fa fa-truck" aria-hidden="true"></i></span>
                            <p class="title">Fastest Delivery</p>
                        </div>
                        <div class="hover-content">
                            <span><i class="fa fa-truck" aria-hidden="true"></i></span>
                            <p class="title">Fastest Delivery</p>
                            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, modi</p>
                        </div>
                    </div>
                </li>
                <!-- end 1 service -->
                <li class="col-6 col-md-3 col-sm-6">
                    <div class="_1sv text-center">
                        <div class="interface">
                            <span><i class="fa fa-money" aria-hidden="true"></i></span>
                            <p class="title">Cheap Price</p>
                        </div>
                        <div class="hover-content">
                            <span><i class="fa fa-money" aria-hidden="true"></i></span>
                            <p class="title">Cheap Price</p>
                            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, modi</p>
                        </div>
                    </div>
                </li>
                <!-- end 1 service -->
                <li class="col-6 col-md-3 col-sm-6">
                    <div class="_1sv text-center">
                        <div class="interface">
                            <span><i class="fa fa-heart" aria-hidden="true"></i></span>
                            <p class="title">Good Support</p>
                        </div>
                        <div class="hover-content">
                            <span><i class="fa fa-heart" aria-hidden="true"></i></span>
                            <p class="title">Good Support</p>
                            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, modi</p>
                        </div>
                    </div>
                </li>
                <!-- end 1 service -->
                <li class="col-6 col-md-3 col-sm-6">
                    <div class="_1sv text-center">
                        <div class="interface">
                            <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                            <p class="title">Quick Payment</p>
                        </div>
                        <div class="hover-content">
                            <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                            <p class="title">Quick Payment</p>
                            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, modi</p>
                        </div>
                    </div>
                </li>
                <!-- end 1 service -->
            </ul>
            <!-- end ul -->
        </div>
    </section>

    <!-- Hot Deal -->
    <section id="combo">
        <div class="container">
            <div class="col-sm-6 col-md-6 col-12 title1 text-center mx-auto">
                <h3><span>Hot Deal</span></h3>
            </div>
            <ul class="list-deal row">
                <li class="col-md-6 col-xs-12">
                    <div class="single-sub">
                        <img class="img-sub" src="images/794f60c9cef52bfcd84f98f57db6b1f3.jpg" alt="">
                        <div class="cover">
                            <div class="info">
                                <p class="name">Black Coffee & <br> Dried Bread</p>
                                <p class="sale">Get Extra 30% Off</p>
                                <a class="details" href="MuseExport/blog.html"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>More Details</a>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- end 1 deal -->
                <li class="col-md-6 col-12 right">
                    <div class="up">
                        <div class="single-sub">
                            <img class="img-sub" src="images/b9c97d76c2f8e6eef6d787ba144f57d8.jpg" alt="">
                            <div class="cover">
                                <div class="info">
                                    <p class="name">Donuts</p>
                                    <p class="sale">Flat 20%</p>
                                    <a class="details" href="MuseExport/blog.html"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end up elemt -->
                    <div class="down">
                        <div class="single-sub">
                            <img class="img-sub" src="images/1_banhmivietnamconsotmoicuaamthucduongphotrentoanthegioi.jpg" alt="">
                            <div class="cover">
                                <div class="info">
                                    <p class="sale">Flat 50%</p>
                                    <a class="details" href="MuseExport/blog.html"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </section>

    <!-- Food -->
    <section id="food">
        <div class="container">
            <div class="col-sm-6 col-md-6 col-xs-12 title1 text-center mx-auto">
                <h3><span>Best Seller</span></h3>
            </div>

            <div class="product">
                <div class="container">
                    <ul class="list-prd row">
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/RASPBERRY BRIOCHE BREAD PUDDING.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>
                                    <div class="hot-tag">
                                        <span class="hot">HOT</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">RASPBERRY BRIOCHE BREAD PUDDING</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/Banana Nut Bread Cookies 1.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">ALMOND LOAF CAKE</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/1d5ab10c1870f73713464a446e12d062.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>
                                    <div class="hot-tag">
                                        <span class="hot">HOT</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">RASPBERRY BRIOCHE BREAD PUDDING</a>
                                    <p class="cost">2.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/48969e67ca303b258d405c865a394ec4.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>
                                    <div class="hot-tag">
                                        <span class="hot">HOT</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">CAPUCCINO</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/RASPBERRY BRIOCHE BREAD PUDDING.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>

                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">RASPBERRY BRIOCHE BREAD PUDDING</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/Banana Nut Bread Cookies 1.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="MuseExport/banana-nut.html">Details</a></div>
                                    </div>
                                    <div class="hot-tag">
                                        <span class="hot">HOT</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">ALMOND LOAF CAKE</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/1d5ab10c1870f73713464a446e12d062.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="">Details</a></div>
                                    </div>

                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">RASPBERRY BRIOCHE BREAD PUDDING</a>
                                    <p class="cost">2.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                        <li class="col-sm-6 col-xs-12 col-md-3">
                            <div class="single-prd">
                                <div class="img-des">
                                    <a href="MuseExport/banana-nut.html"><img src="images/48969e67ca303b258d405c865a394ec4.jpg" alt="" class="des img-responsive"></a>
                                    <div class="hover-cart">
                                        <div class="cart-icon"><a href="MuseExport/my-cart.html"><i class="fa fa-shopping-cart    "></i></a></div>
                                        <div class="love-icon"><a href=""><i class="fa fa-heart    "></i></a></div>
                                        <div class="more"><a href="">Details</a></div>
                                    </div>
                                    <div class="hot-tag">
                                        <span class="hot">HOT</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <a href="MuseExport/banana-nut.html" class="name">CAPUCCINO</a>
                                    <p class="cost">5.00$</p>
                                </div>
                            </div>
                            <!-- end single-prd -->
                        </li>
                        <!-- end 1prd -->
                    </ul>
                    <!-- end list-prd -->
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <!-- News and event -->
    <section id="news">
        <div class="container">
            <div class="col-sm-6 col-md-6 col-xs-12 title1 text-center mx-auto">
                <h3><span>Blog And News</span></h3>
            </div>
        </div>
        <div class="container news">
            <div class="news-outer">
                <div class="news-left">
                    <div class="news-left-inner">
                        <div class="news-left-inner-top">
                            <a href="#"><img src="images/cake.jpg" alt=""></a>
                            <div class="news-cover"></div>
                            <div class="time text-center"><span>03<br>JUNE</span></div>
                            <div class="content">
                                <a href="MuseExport/blog-1.html" class="title">Porridge and Parsnips Exeter Food Festival 2018</a>
                            </div>
                        </div>
                        <div class="news-left-inner-bottom">
                            <a href="#"><img src="images/Bakery and chocolate festival.jpg" alt=""></a>
                            <div class="news-cover"></div>
                            <div class="time text-center"><span>25<br>OCT</span></div>
                            <div class="content">
                                <a href="MuseExport/blog-1.html" class="title">Bakery and Chocolate Festival</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end left -->
                <div class="news-center">
                    <div class="news-center-inner">
                        <a href="#"><img src="images/7f20cff4bcb83b7616ce99da867fc922.jpg" alt=""></a>
                        <div class="news-cover"></div>
                        <div class="time text-center"><span>13<br>FEB</span></div>
                        <div class="content">
                            <a href="MuseExport/blog-2.html" class="title">THE FAST FOOD FAIR 2018</a>
                        </div>
                    </div>
                </div>
                <!-- end center -->
                <div class="news-right">
                    <div class="news-right-inner">
                        <div class="news-right-inner-top">
                            <a href="#"><img src="images/P4354W1.jpg" alt=""></a>
                            <div class="news-cover"></div>
                            <div class="time text-center"><span>04<br>DEC</span></div>
                            <div class="content">
                                <a href="MuseExport/blog-1.html" class="title">King Bakery Opens</a>
                            </div>
                        </div>
                        <div class="news-right-inner-bottom">
                            <a href="#"><img src="images/Bakery and chocolate festival.jpg" alt=""></a>
                            <div class="news-cover"></div>
                            <div class="time text-center"><span>25<br>OCT</span></div>
                            <div class="content">
                                <a href="MuseExport/blog-2.html" class="title">Bakery and Chocolate Festival</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end right -->
            </div>
        </div>
    </section>

    <!-- Subscribe -->
    <section id="sub">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-xs-12 newsletter-main-title">
                    <span>Subscribe Email</span>
                </div>
                <div class="col-sm-7 col-xs-12 formlable">
                    <form action="submit.php">
                        <input type="text" id="email" name='email' placeholder="Your Email Address">
                        <input type="submit" class="btn btn-danger"  value="Send">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section id="footer">
        <div class="footer-inner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 address">
                        <div class="main-title">
                            <span>About us</span>
                        </div>
                        <div class="infor">
                            <ul>
                                <li><span><i class="fa fa-phone    "></i></span>(+00) 123456-789</li>
                                <li><span><i class="fa fa-at" aria-hidden="true"></i></span><a href="">kingbakery@thimpress.com</a></li>
                                <li><span><i class="fa fa-map-marker    "></i></span>PO Box 97845 Baker st. 567, <br> Los Angeles, California, US</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 openning">
                        <div class="main-title">
                            <span>Openning Hours</span>
                        </div>
                        <div class="infor">
                            <ul>
                                <li>Monday – Friday <br> 08:00 AM – 12:00 PM</li>
                            </ul>
                            <ul>
                                <li>Saturday – Sunday <br> 08:00 AM – 12:00 PM</li>
                            </ul>
                            <ul>
                                <li>Festival & Holidays <br> 06:00 AM – 12:00 PM</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 useful-link">
                        <div class="main-title">
                            <span>Useful Links</span>
                        </div>
                        <div class="list-link">
                            <div class="row">
                                <div class="col-sm-6 col-6">
                                    <ul>
                                        <li><a href="">About us</a></li>
                                        <li><a href="">FAQ</a></li>
                                        <li><a href="">Contact</a></li>
                                        <li><a href="">Clients</a></li>
                                        <li><a href="">Coming Soon</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <ul>
                                        <li><a href="">Blog</a></li>
                                        <li><a href="">Services</a></li>
                                        <li><a href="">Forums</a></li>
                                        <li><a href="">Shops</a></li>
                                        <li><a href="">Gallery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 keep">
                        <div class="main-title">
                            <span>Keep in touch</span>
                        </div>
                        <div class="infor">
                            Get updates about new tours, travel tips, room prices and more!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Copyright -->
    <section id="copyright">
        <div class="col-sm-6 mx-auto text-center">
            © 2018 - Copyright by KingBakery™
        </div>
    </section>

    <!-- Back-to-top -->
    <div class="back-to-top">
        <span><i class="fa fa-caret-up    "></i></span>
    </div>
</div>
<!-- END  -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>

<script src="js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>


