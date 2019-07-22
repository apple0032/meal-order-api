<style>
  @import url(//fonts.googleapis.com/earlyaccess/notosanstc.css);

  #footer_text{
    font-family: 'Raleway';
    text-align: center;
    margin-bottom: 30px;
    font-size:16px;
  }

  #footer_text i{
    font-size: 19px;
  }

  @media (min-width: 1300px){
    .container {
      width: 1300px !important;
    }
  }

  @font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyCMIT5lu.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
  }
  /* latin */
  @font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyC0ITw.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }

  /* latin */
  @font-face {
    font-family: 'Abel';
    font-style: normal;
    font-weight: 400;
    src: local('Abel Regular'), local('Abel-Regular'), url(https://fonts.gstatic.com/s/abel/v9/MwQ5bhbm2POE2V9BPQ.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }

  .container-fluid{
    font-size: 17px;
  }

  .navbar {
    font-family: 'Noto Sans TC', sans-serif !important;
  }
  .navbar-default {
    background-color: #2d6098 !important;
    border: 0px !important;
    border-bottom: 1px solid black !important;
    border-radius: 0px !important;
    margin-bottom: 50px !important;
  }

  .navbar-brand{
    margin-left: 0px !important;
    margin-right: 30px;
  }

  .navbar-default .navbar-brand {
    color: white !important;
    font-size: 22px;
  }

  .cool-link a {
    color: white !important;
  }

  .cool-link a:hover{
    color: #555 !important;
  }

  .cool-link{
    transition: all 0.2s;
  }

  .cool-link:hover{
    background-color: white;
  }

  .activated{
    background-color: white;
  }

  .activated a{
    color: #555 !important;
  }

  .nav_user_box{
    color: white !important;
  }

  .dropdown-menu{
    font-size: 16px;
  }
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{URL::to('/')}}"><i class="fab fa-battle-net"></i> Station Management System</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('/') ? "activated" : "" }} cool-link home_btn"><a href="{{URL::to('/')}}">Home</a></li>
        <li class="cool-link create_new_station"><a href="">Create</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="cool-link convert_navbtn"><a href="{{URL::to('/')}}/convert-page">Convert</a></li>
        <li class="cool-link convert_navbtn"><a href="{{URL::to('/')}}/swagger.html">Documentation</a></li>

        @if (Auth::check())

          <li class="dropdown">
            <a href="/" class="dropdown-toggle nav_user_box" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false"><i class="fas fa-user-circle"></i> &nbsp; {{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{URL::to('/')}}/auth/logout"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout</a></li>
            </ul>
          </li>
        
        @else

          <li class="cool-link login_btn"><a href="{{URL::to('/')}}/auth/login">Login</a></li>
          <li class="cool-link"><a href="{{URL::to('/')}}/auth/register">Register</a></li>

        @endif

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>