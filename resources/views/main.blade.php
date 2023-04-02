<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>shoppyJapan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('main/img/logoshoppyJapan.png')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    {{-- <link href="{{ asset('main/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('main/css/animate.css')}}"/>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('main/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('main/css/customstyle.css')}}">
    <script src="{{ asset('main/js/jquery.js')}}"></script>

</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        {{-- <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="row align-items-center px-xl-5">
            <div class="col-lg-3 d-none d-lg-block pt-2">
                <a href="{{route('admin.login')}}" class="text-decoration-none">
				    <img class="img-fluid" src="{{ asset('main/img/logoshoppyJapan.png') }}"  data-src="{{ asset('main/img/logoshoppyJapan.png') }}"alt="Image" loading="lazy">
                    <div class="text-right mb-2 font-italic font-weight-semi-bold">EST 2023</div>
                </a>
            </div>
            {{-- <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div> --}}
            {{-- <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">Login</span>
                </a>
                <a href="" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">Register</span>
                </a>
            </div> --}}
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5" id="top">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="{{route('admin.login')}}" class="text-decoration-none d-block d-lg-none">
<!--                        <h2 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border ">Shoppy</span>Japan</h2>-->
						<img class="img-fluid" src="{{ asset('main/img/logoshoppyJapan.png') }}" alt="Image" data-src="{{ asset('main/img/logoshoppyJapan.png') }}">
                        <div class="text-right mb-2 font-italic font-weight-semi-bold">EST 2023</div>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="#" class="nav-item nav-link active">Home</a>
                            {{-- <a href="shop.html" class="nav-item nav-link">Shop</a>
                            <a href="detail.html" class="nav-item nav-link">Shop Detail</a> --}}
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div> --}}
                            <a href="#contact" class="nav-item nav-link">Contact Us</a>
                            @if(Session::get('type') == 'user')
                            <a href="{{ route('user.dashboard')}}" class="nav-item nav-link">My Dashboard</a>
                            @endif
                        </div>
                        @if(!Session::get('type'))
                        <div class="navbar-nav ml-auto py-0">
                            {{-- <a href="{{ route('user.login')}}" class="nav-item nav-link">Login</a> --}}
                            <a href="{{ route('user.register')}}" class="nav-item nav-link">Register</a>
                        </div>
                        @endif
                    </div>
                    <div>
                        @if(Session::get('type') == 'user')
                            <span>Welcome, {{Session::get('name')}}</span>
                        @elseif(Session::get('type') == 'admin')
                            <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <a class="btn btn-shpyj btn-block"  href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            Log Out</a>
                            </form>
                        @else 
                            
                            <a href="{{ route('user.login')}}" class="btn btn-shpyj btn-block">Login</a>
                            
                        @endif
                    </div>
                    
                    
                    
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active carousel-h">
                            <img class="img-fluid" src="{{ asset('main/img/bannershoppyJapan-1.jpg') }}" alt="Image" data-src="{{ asset('main/img/bannershoppyJapan-1.jpg') }}">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    {{-- <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4> --}}
                                  
                                    {{-- <a href="" class="btn btn-light py-2 px-3">Shop Now</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item carousel-h">
                            <img class="img-fluid" src="{{ asset('main/img/bannershoppyJapan-2.jpg')}}" alt="Image" data-src="{{ asset('main/img/bannershoppyJapan-2.jpg')}}">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    {{-- <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4> --}}
                                   
                                    {{-- <a href="" class="btn btn-light py-2 px-3">Shop Now</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

   

    <!-- Featured Start -->

    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Annoucement</span></h2>
        </div>
        <div class="row px-xl-5">
            @foreach($annocue as $an)
            <div class="col-md-12 mb-3">
                <div class="card border-left rounded-lg {{$an->announce_color}}">
                    <div class="card-title text-center mt-3 font-weight-bolder"><h4>{{strtoupper($an->announce_title)}}</h4></div>
                    <div class="card-body">
                        <p class="text-justify text-center p-cs">{{$an->announce_description}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if(Session::get('type') == 'user')
    <div class="container pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Insert Item Url And Price</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-md-12 mb-5 px-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form name="sentmessage"  action="{{ route('user.neworder2')}}" method="POST">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control font-weight-bolder" id="name" placeholder="Your Item URL Address"
                                required autocomplete="off" name="url" data-validation-required-message="Please enter your name"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control font-weight-bolder" id="price" placeholder="Price (YEN)"
                                required oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="price"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-success py-2 px-4" type="submit" id="sendMessageButton">Add Order</button>
                            <button type="button" class="btn btn-blue py-2 px-4" data-toggle="modal" data-target="#modal"> Courier Fee (EMS)</button>
                            <button type="button" class="btn btn-blue py-2 px-4" data-toggle="modal" data-target="#modal2"> Courier Fee (Airmail)</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- modal --}}
    <div id="modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Courier Fee (EMS)</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                
                <div class="row px-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Weight (g/Kg)</th>
                                        <th>Price (YEN)</th>
                                        <th>Price (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emsFee as $key=>$fee)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($fee->cf_weight > 1000)
                                            {{$fee->cf_weight /1000}}kg
                                            @else
                                            {{$fee->cf_weight}}g
                                            @endif
                                        </td>
                                        <td>{{number_format($fee->cf_price_yen, 0,".",",")}}</td>
                                        <td>
                                            @php $rm_price = ($fee->cf_price_yen * $config->currency_yentomyr) ; @endphp
                                            {{number_format($rm_price,2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                </div>
          
            </div>
        </div>
    </div>

    <div id="modal2" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Courier Fee (Airmail)</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                
                <div class="row px-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Weight (g/Kg)</th>
                                        <th>Price (YEN)</th>
                                        <th>Price (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($airmailFee as $key=>$fee)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>Up to
                                            @if($fee->cf_weight > 1000)
                                            {{$fee->cf_weight /1000}}kg
                                            @else
                                            {{$fee->cf_weight}}g
                                            @endif
                                        </td>
                                        <td class="text-right">{{number_format($fee->cf_price_yen, 0,".",",")}}</td>
                                        <td class="text-right">
                                            @php $rm_price = ($fee->cf_price_yen * $config->currency_yentomyr) ; @endphp
                                            {{number_format($rm_price,2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                </div>
          
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row px-xl-5 py-5">
            <div class="col-md-12 text-center">
                <h2 class="mb-4">shoppy Japanese items at local price</h2>
                <h2 class="animate__animated animate__pulse animate__infinite infinite">Buy limited edition items <span class="text-danger">NOW !!!</span></h2>
                <h2 class="my-4">NAK BARANG JEPUN ??</h2>
                <h2 class="mb-4">TAK PERLU KE JEPUN !!</h2>
                <h3>Kini anda boleh membeli pelbagai barangan</h3> 
                <h3 class="ping text-danger font-weight-bolder">menarik, rare dan limited </h3> 
                <h3>dari Jepun dengan hanya menggunakan telefon anda di Malaysia sahaja.</h3>
                
            </div>
        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="text-center pb-5">
            <h2 class="section-title px-5"><span class="px-2">Why ShoppyJapan ?</span></h2>
        </div>
        <div class="row px-xl-5 pb-3" data-aos="fade-right" data-aos-duration="1900" ata-aos-delay="600">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shield-alt text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">100% Authentic</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Guarantee Refundable </h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
        <div class="row px-xl-5 pb-3" data-aos="fade-left" data-aos-duration="1900" ata-aos-delay="600">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px; height:134px">
                    <h1 class="fa fa-box-open text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Easy To Buy</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;height:134px">
                    <h1 class="fa fa-award text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Trusted Personal Shopper</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px; height:133px">
                    <h1 class="fa text-primary m-0 mr-3">RM</h1>
                    <h5 class="font-weight-semi-bold m-0">Get Local Price</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-cubes text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">More Recommended Item</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

   <div class="text-center py-4">
            <h2 class="section-title px-5"><span class="px-2">How to buy?</span></h2>
        </div> 
    <div class="container-fluid pt-5">
        
        <div class="px-xl-5pb-3 row justify-content-center">
            <div class="col-md-8">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{asset('main/video/tutorial_shpyjpn.mp4')}}" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div> 

    <!-- Categories Start -->
     <div class="text-center py-4">
        <h2 class="section-title px-5"><span class="px-2">Shop Now</span></h2>
    </div>
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach($shops as $site)
            <div class="col-lg-4 col-md-6 pb-1">
                 {{--<div class="cat-item d-flex flex-column  mb-4" style="padding: 30px;">
                    <p class="text-right"></p>
                    <a href="" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="text-center topStore_logo" src="{{ asset('storage/upload/brand_images/'.$shop->site_img) }}" alt="shop-img" style="height:60px">
                    </a>
                    <h5 class="font-weight-semi-bold m-0 text-center">{{ $shop->site_name }}</h5>
                </div>
            </div> --}}
              <div class="card product-item  mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border py-1 text-center">
                            <a target="_blank" href="{{  $site->site_url }}" class="btn btn-sm text-dark p-0"> <img class="img-fluid w-100" src="{{ asset('storage/upload/brand_images/'.$site->site_img) }}" alt="productimg" style="height:60px" data-src="{{ asset('storage/upload/brand_images/'.$site->site_img) }}"></a>
                        </div>
                        <div class="card-body border-left border-right text-center px-3 py-3">
                            <h6 class="text-truncate mb-3">{{ Str::ucfirst($site->site_name) }}</h6>
                          

                            <div class="d-flex justify-content-center">
                                {{-- <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6> --}}
                            </div>
                        </div>
                       
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    {{-- <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="{{ asset('main/img/offer-1.png')}}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="{{ asset('main/img/offer-2.png')}}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Offer End -->




    {{-- {{ dd($brands)}} --}}
   
    {{-- @foreach($sites as $key => $site)
 
    <div class="container-fluid">
        <div class="row px-xl-5 pb-3">
            <div class="col-md-12 border-3">
                <div class="row my-3 px-3">
                    <img class="topStore_logo" src="{{ asset('storage/upload/brand_images/'.$site->site_img) }}" alt="shop_yahoo_shopping">
                    <p class="px-3 text-uppercase">{{ $brand['title']}}</p>
                </div>
                <div class="row">
                    @foreach($site->product as $product)
                    <div class="col-lg-2 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                               
                                 <a target="_blank" href="{{ $product->product_url }}" class="btn btn-sm text-dark p-0"> <img class="img-fluid w-100" src="{{ asset('storage/upload/product_images/'.$product->product_img) }}" alt="productimg" style="height:200px"></a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ Str::ucfirst($product->product_name) }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center bg-light border">
                                <a target="_blank" href="{{ $product->product_url }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-right">
                    <a target="_blank" href="{{ $site->site_url }}">Check the {{ $site->site_name }} </a>
                </div>
            </div>

        </div>
    </div>
    
    @endforeach --}}
    
     
    @if(count($sites)> 0)
        <div class="text-center py-4">
            <h2 class="section-title px-5"><span class="px-2">Products</span></h2>
        </div>
        @foreach($sites as $key => $site)
        
        <div class="container-fluid">
            <div class="row px-xl-5 pb-3">
                <div class="col-md-12 border-3">
                    <div class="row my-3 px-3">
                        <img class="topStore_logo" src="{{ asset('storage/upload/brand_images/'.$site->site_img) }}" alt="shop_yahoo_shopping" data-src="{{ asset('storage/upload/brand_images/'.$site->site_img) }}">
                        {{-- <p class="px-3 text-uppercase">{{ $brand['title']}}</p> --}}
                    
                    </div>
                <div class="row my-1 px-3">
                        
                        <h4 class="text-uppercase">Recommended Item</h4>
                    
                    </div>
                    <div class="owl-carousel owl-theme">
                        @foreach($site->product as $product)
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border py-1 text-center">
                                <a target="_blank" href="{{ $product->product_url }}" class="btn btn-sm text-dark p-0"> <img class="img-fluid w-100" src="{{ asset('storage/upload/product_images/'.$product->product_img) }}"  data-src="{{ asset('storage/upload/product_images/'.$product->product_img) }}"alt="productimg" style="height:200px" ></a>
                            </div>
                            <div class="card-body border-left border-right text-center px-3 py-3">
                                <h6 class="text-truncate mb-3">{{ Str::ucfirst($product->product_name) }}</h6>
                                <h6 class="text-truncate mb-1">&#165; {{ number_format($product->product_price, 0, ".", ",") }}</h6>
                                <h6 class="text-truncate">
                                    @php
                                    $var = $product->product_price * $config->currency_yentomyr;
                                    @endphp
                                    
                                    RM {{number_format($var, 2)}}
                                </h6>

                                <div class="d-flex justify-content-center">
                                    {{-- <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6> --}}
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center bg-light border">
                                {{-- <a  target="_blank" href="{{ $product->product_url }}" class="btn btn-primary text-white mr-1" type="submit"><i class="fas fa-eye mr-1"></i>View Detail</a> --}}

                                @if(Session::get('type') == 'user')
                                <form action="{{ route('user.neworder2')}}" method="POST">
                                @else
                                <form action="{{ route('user.login.order')}}" method="POST">
                                @endif
                                    @csrf
                                    <input type="hidden" name="url" value="{{ $product->product_url}}" readonly>
                                    <input type="hidden" name="price" value="{{ (!empty($product->product_price) ? $product->product_price:'0')}}" readonly>
                                    <button  class="btn btn-info text-white" type="submit"><i class="fa fa-shopping-bag mr-1"></i>
                                        Add Order</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-right">
                        <a target="_blank" href="{{ $site->site_url }}">Check the {{ $site->site_name }} </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
    <!-- Vendor Start -->
    {{-- <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Vendor</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach($sites as $key => $img)
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('storage/upload/brand_images/'.$img->site_img) }}" alt="">
                    </div>
                    @endforeach --}}
                    {{-- <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-2.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-3.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-4.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-5.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-6.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-7.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('main/img/vendor-8.jpg') }}" alt="">
                    </div> --}}
                {{-- </div> --}}

            {{-- </div> --}}

        {{-- </div> --}}
         {{-- <div class="col-md-12 px-xl-5 text-right my-3">
                <a href="" >All</a>

            </div> --}}
    {{-- </div> --}}
    <!-- Vendor End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-3 pt-3" id="contact">
        <div class="row px-xl-5 pt-4">
            <div class="col-lg-6 col-md-12 mb-5 pr-3 pr-xl-5">

             
                <a href="" class="text-decoration-none">
<!--                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white ">Shoppy</span>Japan</h1>-->
				<img class="img-fluid1" src="{{ asset('main/img/logoshoppyJapan.png') }}" alt="Image" data-src="{{ asset('main/img/logoshoppyJapan.png') }}">

                </a>
                {{-- <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p> --}}
                <p class="text-uppercase mt-3 mb-0 font-weight-bolder">Japan Office :</p>
                <p class="text-uppercase mb-0">shoppyJapan Global (Japan) :</p>
                <div class="row">
                    <div class="col-md-1 col-1 pr-0">
                        <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                    </div>
                    <div class="col-md-11 col-11 px-0">
                        <p class="mb-0 font-italic">736-0088 Hiroshimaken, Hiroshimashi, Akiku Hataka, 2-24-2-202</p>
                    </div>
                    <div class="col-md-1 col-1 pr-0">
                        <i class="fab fa-whatsapp text-primary mr-3"></i>
                    </div>
                    <div class="col-md-11 col-11 px-0">
                        <a href="https://wa.me/+819064372903" target="_blank"><p class=" font-italic">+8190-6437-2903</p></a>
                    </div>
                </div> 
                
                {{-- <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p> --}}
                <p class="text-uppercase mb-0 font-weight-bolder">Malaysia Office :</p>
                <p class="text-uppercase mb-0">shoppyJapan Global (Malaysia) :</p>
                <div class="row">
                    <div class="col-md-1 col-1 pr-0">
                        <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                    </div>
                    <div class="col-md-11 col-11 px-0">
                        <p class="mb-0 font-italic">No 3A & 3B, Jln Pendidikan 8, Taman Universiti, 81300 Skudai, Johor, Malaysia</p>
                    </div>
                    <div class="col-md-1 col-1 pr-0">
                        <i class="fab fa-whatsapp text-primary mr-3"></i>
                    </div>
                    <div class="col-md-11 col-11 px-0">
                        <a href="https://wa.me/+60135987486" target="_blank"><p class=" font-italic">+60135987486</p></a>

                    </div>
                </div>
                {{-- <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p> --}}
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            {{-- <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a> --}}
                            <a class="text-dark mb-2" href="https://shoppyjapan.blogspot.com/?m=1" target="_blank"><i class="fa fa-angle-right mr-2"></i>Blog</a>

                            <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Terms & Condition</a>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div> --}}
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Follow Us</h5>
						<a class="text-dark px-2" href="https://www.facebook.com/shoppyjapan" target="_blank">
                            <i  class="fab fa-facebook-f"></i>
                        </a>
						 
                        <a class="text-dark px-2" href="https://twitter.com/shoppyjapan?t=70MwaxDgGzgSfqPhlCDNxg&s=09" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a> 
                        <a class="text-dark px-2" href="https://www.tiktok.com/@shoppyjapan?_t=8UNgxaaOycU&_r=1" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a> 
                        <a class="text-dark px-2" href="https://www.instagram.com/shoppyjapan_official/?igshid=YmMyMTA2M2Y%3D" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a> 
                        <a href="https://shoppyjapan.blogspot.com/?m=1" class="text-dark px-2" target="_blank">
                            <i class="fas fa-blog"></i>
                        </a>
                    {{-- <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy;  {{ date('Y')}}. <a class="text-dark font-weight-semi-bold" href="">shoppyJapan</a>. All Rights Reserved.

                </p>
            </div>
            {{-- <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div> --}}
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#top" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('main/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('main/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('main/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{ asset('main/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('main/js/main.js')}}"></script>
    <script>
        $(document).ready(function(){
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    // lazyLoad:true,
    autoplayTimeout:3000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})});
    </script>
<script>
AOS.init();


</script>
<script>

    const images = document.querySelectorAll("img");

    // images.foreach((image) => {
    //     const newURL = image.getAttribute('data-src');
    //     image.src = newURL;
    // });

    let imageOptions = {};

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if(!entry.isIntersecting) return;
            const image = entry.target;
            const newURL = image.getAttribute('data-src');
            image.src = newURL;
            // console.log(image);
        })
    }, imageOptions);

    images.forEach((image) => {
        // const newURL = image.getAttribute('data-src');
        // image.src = newURL;
        observer.observe(image);
    });

</script>
</body>

</html>
