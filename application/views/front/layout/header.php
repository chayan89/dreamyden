<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= SITE_TITLE ?></title>
        <!--css start-->
        <link rel="stylesheet" href="<?= base_url('public/front/css/bootstrap.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/owl.carousel.min.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/owl.theme.default.min.css')?>">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('public/front/css/global.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/flexslider.css')?>" />
        <link rel="stylesheet" href="<?= base_url('public/front/css/menu.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/colorbox.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/animate.css')?>">
        <link rel="stylesheet" href="<?= base_url('public/front/css/media-queries.css')?>">

        <!-- JQUERY -->
        
        <script src="<?= base_url('public/front/js/jquery.min.js')?>"></script>
        <!-- user common resoluces for JS & CSS -->
        <script>
            var base_url = "<?=base_url()?>";
        </script>
    </head>
    <body>
        <a id="button" class="back-to-top show"></a>
        <section class="top-header">
            <div class="container">
                <div class="row">
                <div id="new-arrievel" class="owl-carousel">
                    <div class="item">
                        <a href="">Shop New In Clothing</a>
                    </div>
                    <div class="item">
                        <a href="">Free UK standard delivery when you spend £50</a>
                    </div>
                    <div class="item">
                        <a href="">WE HAVE SAFELY REOPENED OUR STORES</a>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <section class="sub-header">
            <div class="sub-header__container">
                <a  href="https://www.thewhitecompany.com/uk/our-stores" class="link-tag sub-header__item">
                Find a store
                </a> <a  href="/uk/help/contact-us" class="link-tag sub-header__item">
                Contact us
                </a>
                <span  class="js-country-selector-trigger country-selector-trigger country-selector-trigger--sub-header">
                <div  class="flag-icon"></div>
                India (GBP)
                </span>
            </div>
        </section>
        <section class="main-header">
            <div class="main-header__container">
                <div class="flex-container">
                <div class="search">
                    <input type="submit" value="&#xf002;" class="search-btn fa ib-m" ><!--
                        -->
                    <div class="search-slide ib-m">
                        <input type="text" placeholder="Enter your search" class="ib-m"><!--
                            -->
                        <div class="search-close ib-m"><i class="fa fa-times"></i></div>
                    </div>
                </div>
                </div>
                <a href="<?=base_url()?>" class="logo">
                <img src="<?= base_url('public/front/img/Dreamy_Den_logo.jpg')?>" alt="" class="img-fluid">
                </a>
                <div class="flex-container">
                <div >
                    <div class="main popover--my-account">
                        <a  href="https://www.thewhitecompany.com/uk/my-account" class="link-tag" data-v-7a3aebd1="">
                            <div  class="labeled-icon" >
                            <span  class="label">Sign in / Register</span>
                            <div  class="icon">
                                <svg data-v-7e8efb82="" data-v-4d7d8df8="" viewBox="0 0 12 14" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                                    <path data-v-7e8efb82="" data-v-4d7d8df8="" d="M2.851 3.574l.003-.05A3.007 3.007 0 015.849.708c1.657 0 3.004 1.348 3.006 2.98l-.002.029a3.003 3.003 0 01-1.096 2.314l-.132.101c-.03.024-.061.048-.097.074a3.341 3.341 0 01-.21.127l-.04.024c-.06.033-.124.061-.189.091l-.075.036a2.529 2.529 0 01-.131.048l-.092.033c-.018.007-.036.014-.053.019-.035.011-.07.019-.105.027l-.112.029a1.413 1.413 0 01-.068.018c-.037.007-.075.012-.113.017l-.106.016a2.94 2.94 0 01-.361.028h-.028c-.305 0-.605-.046-.892-.135a1.578 1.578 0 01-.073-.028l-.105-.038c-.033-.012-.066-.023-.097-.036a3 3 0 01-1.834-2.768c0-.048.003-.094.006-.14m1.611 3.422a1.8 1.8 0 00.129.048l.09.033c.035.014.07.027.106.038.333.105.681.158 1.034.161l.029.001a2.27 2.27 0 00.479-.036l.087-.013c.049-.007.098-.013.15-.024.035-.007.069-.016.103-.025l.095-.024c.048-.011.095-.023.141-.037l.086-.031.077-.028c.055-.019.11-.038.166-.062l.063-.029.024-.012c.076-.034.151-.069.226-.109l.048-.029c.085-.047.168-.096.252-.154.044-.03.086-.063.128-.096l.142-.111A3.534 3.534 0 009.41 3.743l.002-.029A3.567 3.567 0 005.849.15a3.566 3.566 0 00-3.552 3.339l-.003.046c-.005.06-.008.119-.008.179a3.554 3.554 0 002.175 3.282M.683 13.354a5.175 5.175 0 012.958-4.599l.057-.022.006-.007a5.71 5.71 0 01.428-.173l.046-.016a3.72 3.72 0 01.24-.075c.101-.03.205-.057.31-.08.054-.012.107-.022.163-.033l.132-.024.022-.003c.08-.013.16-.024.24-.033l.182-.016c.24-.018.469-.02.745 0l.177.015.141.018.064.01c.067.009.134.02.2.033l.032.006.111.022a4.986 4.986 0 01.793.243c.082.032.162.066.242.103l.014.006a5.17 5.17 0 013.012 4.625H.683zm7.542-5.129l-.035-.016a3.82 3.82 0 00-.255-.108 4.651 4.651 0 00-.518-.177 5.152 5.152 0 00-.361-.093l-.128-.025-.029-.006a5.043 5.043 0 00-.22-.037l-.021-.003-.002-.001-.021-.003-.186-.025-.217-.017a5.976 5.976 0 00-.803.001l-.078.007-.036.004-.089.007a5.18 5.18 0 00-.246.033l-.024.004a3.067 3.067 0 00-.167.03 5.408 5.408 0 00-.787.207l-.058.02c-.175.063-.35.135-.519.212l-.045.022-.001.001a5.74 5.74 0 00-3.254 5.153c0 .051.004.101.007.15l.014.347h11.388l.016-.343c.003-.051.006-.101.006-.154a5.728 5.728 0 00-3.331-5.19" fill="#333" fill-rule="nonzero"></path>
                                </svg>
                            </div>
                            <!---->
                            </div>
                        </a>
                    </div>
                    <div></div>
                </div>
                <div >
                    <div class="main popover--my-bag">
                        <a  href="https://www.thewhitecompany.com/uk/basket" class="link-tag" >
                            <div class="labeled-icon" >
                            <span class="label">My Bag</span> 
                            <div  class="icon">
                                <svg data-v-c52ef586="" viewBox="0 0 24 25" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                                    <path data-v-c52ef586="" d="M22.865 7.256v16.513H1.121l.068-16.464m7.066-2.339c.135-2.739 2.125-3.763 3.746-3.763s3.746 1.273 3.746 3.763v1.359H8.255V4.966zm8.184 1.359V4.966A4.443 4.443 0 0012.001.528a4.443 4.443 0 00-4.438 4.438v1.359H.212v18.427H23.79V6.325h-7.351z" fill="#333" fill-rule="nonzero"></path>
                                </svg>
                            </div>
                            <!---->
                            </div>
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <?php
            $this->load->view('front/layout/main-menu');
        ?>