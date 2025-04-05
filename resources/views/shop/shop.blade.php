
@extends('shop.components.layout')

@section('content')


    <!-- Featured Projects-->
    <section class="section section-lg bg-default text-center">
        <div class="container container-fluid px-0">
            <h2 class="wow fadeIn">Our Featured Courses</h2>
            <div class="row row-30 row-md-50 row-xl-70">
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-1-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <h4 class="post-minimal-title name-product"><a href="#">Financial Analyst Course</a></h4>
                            <ul class="list-inline">
                                <li class="list-inline-itema name-cms"><a href="#">Laravel</a></li>
                                <li class="list-inline-item price">20$</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-2-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Maria Howard</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Digital Marketing Course</a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-3-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Steven Carter</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Graphic Design Course</a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-6-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Walter Myers</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Mathematics and Statistics</a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-4-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Julie Weaver</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Computer Science </a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-5-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Kathy Gibson</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Political Economy</a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-6-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Walter Myers</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Mathematics and Statistics</a></h4>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn">
                    <!-- Post Minimal-->
                    <div class="post-minimal">
                        <figure class="post-minimal-media"><a href="#"><img class="post-minimal-image" src="{{ asset('shop/images/grid-gallery-6-370x260.jpg')  }}" alt="" width="370" height="260"/></a></figure>
                        <div class="post-minimal-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item">Teacher: </li>
                                <li class="list-inline-itema"><a href="#">Walter Myers</a></li>
                            </ul>
                        </div>
                        <h4 class="post-minimal-title"><a href="#">Mathematics and Statistics</a></h4>
                    </div>
                </div>
            </div><a class="button button-lg button-primary-gradient wow fadeIn" data-wow-delay=".2s" href="#"><span>view all courses</span></a>
        </div>
    </section>
    <!-- Latest Blog Posts-->
    <section class="section section-lg bg-default text-center">
        <div class="container container-fluid px-0">
            <h2 class="wow fadeIn">Latest Blog Posts</h2>
            <div class="row row-30 justify-content-center">
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-1-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Campus Opening Convocation</h4>
                            </div>
                        </div></a>
                </div>
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-2-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Freshman Matriculation Ceremony at Bradston College</h4>
                            </div>
                        </div></a>
                </div>
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-3-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Bradston College Leadership Academy</h4>
                            </div>
                        </div></a>
                </div>
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-4-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Incoming Freshmen Gather for Blueprints: Photo Gallery</h4>
                            </div>
                        </div></a>
                </div>
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-4-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Incoming Freshmen Gather for Blueprints: Photo Gallery</h4>
                            </div>
                        </div></a>
                </div>
                <div class="col-sm-10 col-md-4 wow fadeIn">
                    <!-- Post Light--><a class="post-light context-dark" href="#" style="background-image: url({{ asset('shop/images/grid-blog-4-570x350.jpg') }});">
                        <div class="post-light-inner">
                            <div class="badge">News</div>
                            <div class="post-light-main">
                                <time class="post-light-time" datetime="2019">July 5, 2019, at 12:07 pm</time>
                                <h4 class="post-light-title">Incoming Freshmen Gather for Blueprints: Photo Gallery</h4>
                            </div>
                        </div></a>
                </div>
            </div><a class="button button-lg button-primary-gradient wow fadeIn" href="#" data-wow-delay=".2s"><span>View all blog posts</span></a>
        </div>
    </section>

@endsection
