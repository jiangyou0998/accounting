@extends('layouts.app')

@section('content')
<!-- Banner Intro -->
@include('layouts._banner')
<!-- Banner Intro -->


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

@endsection
