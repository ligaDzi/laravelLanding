


@if(isset($pages) && is_Object($pages))

  @foreach($pages as $page)

    @if($page->name == 'home')

      <!--Hero_Section-->
      <section id="{{ $page->alias }}" class="top_cont_outer">
        <div class="hero_wrapper">
          <div class="container">
            <div class="hero_section">
              <div class="row">
                <div class="col-lg-5 col-sm-7">
                  <div class="top_left_cont zoomIn wow animated"> 
                    {!! $page->text !!}
                    <a href="{{ route('page', ['alias'=>$page->alias]) }}" class="read_more2">Read more</a> 
                  </div>
                </div>
                <div class="col-lg-7 col-sm-5">
                  {!! Html::image('img/'.$page->images, '', ['class' => 'zoomIn wow animated']) !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--Hero_Section-->

    @else
  
      <!--Aboutus-->
      <section id="{{ $page->alias }}">
      <div class="inner_wrapper">
        <div class="container">
          <h2>{{ $page->name }}</h2>
          <div class="inner_section">
            <div class="row">
              <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                {!! Html::image('img/'.$page->images, '', ['class' => 'img-circle delay-03s animated wow zoomIn']) !!}
              </div>
              <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left">
                <div class=" delay-01s animated fadeInDown wow animated">
                  {!! $page->text !!}
                </div>
                <div class="work_bottom"> 
                  <span>Want to know more..</span> 
                  <a href="{{ route('page', ['alias'=>$page->alias]) }}" class="contact_btn">Contact Us</a> 
                </div>       
              </div>          
            </div>
          </div>
        </div> 
      </div>
      </section>
      <!--Aboutus--> 

    @endif

  @endforeach

@endif

@if(isset($services) && is_object($services))

  <!--Service-->
  <section  id="service">
    <div class="container">
      <h2>Services</h2>
      <div class="service_wrapper">

        @foreach($services as $k=>$service)

          @if($k == 0 || $k%3 == 0)
            <div class="row {{ ($k != 0) ? 'borderTop' : ''}}">
          @endif

              <div class="col-lg-4 {{ ($k%3 > 0) ? 'borderLeft' : ''}} {{ ($k > 2) ? 'mrgTop' : ''}}">
                <div class="service_block">
                  <div class="service_icon delay-03s animated wow  zoomIn"> <span><i class="fa {{ $service->icon }}"></i></span> </div>
                  <h3 class="animated fadeInUp wow"> {{ $service->name }}</h3>
                  <p class="animated fadeInDown wow">
                    {!! $service->text !!}
                  </p>
                </div>
              </div>
          
          @if( ($k+1)%3 == 0 )
            </div>
          @endif

        @endforeach
        
      </div>
    </div>
  </section>
  <!--Service-->

@endif



@if(isset($portfolios) && is_object($portfolios))

  <!-- Portfolio -->
  <section id="Portfolio" class="content"> 
    
    <!-- Container -->
    <div class="container portfolio_title"> 
      
      <!-- Title -->
      <div class="section-title">
        <h2>Portfolio</h2>
      </div>
      <!--/Title --> 
      
    </div>
    <!-- Container -->
    
    <div class="portfolio-top"></div>
    
    <!-- Portfolio Filters -->
    <div class="portfolio"> 

      @if(isset($tags))
      
        <div id="filters" class="sixteen columns">
          <ul class="clearfix">
            <li>
              <a id="all" href="#" data-filter="*" class="active">
                <h5>All</h5>
              </a>
            </li>

            @foreach($tags as $tag)

              <li>
                <a href="#" data-filter=".{{$tag->filter}}" class="">
                  <h5>{{ $tag->filter }}</h5>
                </a>
              </li>

            @endforeach
          
          </ul>
        </div>
        <!--/Portfolio Filters --> 

      @endif
      
      <!-- Portfolio Wrapper -->
      <div class="isotope fadeInLeft animated wow" style="position: relative; overflow: hidden; height: 480px;" id="portfolio_wrapper"> 
        
        @foreach($portfolios as $portfolio)

          <!-- Portfolio Item -->
          <div style="position: absolute; left: 0px; top: 0px; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); width: 337px;  opacity: 1;" class="portfolio-item one-four {{ $portfolio->filter }} isotope-item">
            <div class="portfolio_img">
              {!! Html::image('img/'.$portfolio->images, $portfolio->name) !!}
            </div>        
            <div class="item_overlay">
              <div class="item_info"> 
                <h4 class="project_name">{{ $portfolio->name }}</h4>
              </div>
            </div>
            </div>
          <!--/Portfolio Item --> 

        @endforeach
        
      </div>
      <!--/Portfolio Wrapper --> 
      
    </div>
    <!--/Portfolio Filters -->
    
    <div class="portfolio_btm"></div>
    
    
    <div id="project_container">
      <div class="clear"></div>
      <div id="project_data"></div>
    </div>
  
    
  </section>
  <!--/Portfolio --> 

@endif

<!--page_section-->
<section class="page_section" id="clients">
  <h2>Clients</h2>
<!--page_section-->
<!--client_logos-->
<div class="client_logos">
  <div class="container">
    <ul class="fadeInRight animated wow">
      <li><a href="javascript:void(0)"><img src="{{asset('img/client_logo1.png')}}" alt=""></a></li>
      <li><a href="javascript:void(0)"><img src="{{asset('img/client_logo2.png')}}" alt=""></a></li>
      <li><a href="javascript:void(0)"><img src="{{asset('img/client_logo3.png')}}" alt=""></a></li>
      <li><a href="javascript:void(0)"><img src="{{asset('img/client_logo4.png')}}" alt=""></a></li>
    </ul>
  </div>
</div>
</section>
<!--client_logos-->

@if(isset($peoples) && is_object($peoples))

  <!--Team-->
  <section class="page_section team" id="team">
    <div class="container">
      <h2>Team</h2>
      <h6>our leadership team</h6>
      <div class="team_section clearfix">

        @foreach($peoples as $k=>$human)

          <div class="team_area">
            <div class="team_box wow fadeInDown delay-0{{ ($k*3 + 3) }}s">
              <div class="team_box_shadow"><a href="javascript:void(0)"></a></div>

              {!! Html::image('img/'.$human->images, $human->name) !!}
              <ul>
                <li><a href="javascript:void(0)" class="fa fa-twitter"></a></li>
                <li><a href="javascript:void(0)" class="fa fa-facebook"></a></li>
                <li><a href="javascript:void(0)" class="fa fa-pinterest"></a></li>
                <li><a href="javascript:void(0)" class="fa fa-google-plus"></a></li>
              </ul>
            </div>
            <h3 class="wow fadeInDown delay-0{{ ($k*3 + 3) }}s">{{ $human->name }}</h3>
            <span class="wow fadeInDown delay-0{{ ($k*3 + 3) }}s">{{ $human->position }}</span>
            <p class="wow fadeInDown delay-0{{ ($k*3 + 3) }}s">{{ $human->text }}</p>
          </div>
        
        @endforeach


      </div>
    </div>
  </section>
  <!--/Team-->

@endif

<!--Footer-->
<footer class="footer_wrapper" id="contact">
  <div class="container">
    <section class="page_section contact" id="contact">
      <div class="contact_section">
        <h2>Contact Us</h2>
        <div class="row">
          <div class="col-lg-4">
            
          </div>
          <div class="col-lg-4">
           
          </div>
          <div class="col-lg-4">
          
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 wow fadeInLeft">	
		      <div class="contact_info">
            <div class="detail">
                <h4>UNIQUE Infoway</h4>
                <p>104, Some street, NewYork, USA</p>
            </div>
            <div class="detail">
                <h4>call us</h4>
                <p>+1 234 567890</p>
            </div>
            <div class="detail">
                <h4>Email us</h4>
                <p>support@sitename.com</p>
            </div> 
          </div>
          <ul class="social_links">
            <li class="twitter animated bounceIn wow delay-02s"><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
            <li class="facebook animated bounceIn wow delay-03s"><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
            <li class="pinterest animated bounceIn wow delay-04s"><a href="javascript:void(0)"><i class="fa fa-pinterest"></i></a></li>
            <li class="gplus animated bounceIn wow delay-05s"><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li> 
          </ul>
        </div>
        <div class="col-lg-8 wow fadeInLeft delay-06s">
          <div class="form">

            <form action=" {{ route('home') }} " method="post">

              <input class="input-text" type="text" name="name" value="Your Name *" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
              <input class="input-text" type="text" name="email" value="Your E-mail *" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
              <textarea class="input-text text-area" name="text" cols="0" rows="0" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">Your Message *</textarea>
              <input class="input-btn" type="submit" value="send message">

              {{ csrf_field() }}

            </form>

          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="container">
    <div class="footer_bottom"><span>Copyright © 2018.</span> </div>
  </div>
</footer>