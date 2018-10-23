<div class="homepage">
    <header id="header">
        <div class="navbar-holder">
        <!-- if you want to customize the nav, just add class and call it on css -->
            <nav role="navigation" class="navbar navbar-default navi-holder">
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header logo-holder">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{!!URL('/')!!}" class="navbar-brand"><img src="{{'https://'.substr($settings->cover, 7)}}" alt=""></a>
                </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
                <div id="navbarCollapse" class="collapse navbar-collapse right-bar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">ABOUT US</a></li>
                        <li><a href="#">TRENDING CLUBS</a></li>
                        <li><a href="#">HOT TOPICS</a></li>
                        <li><a href="#">DISCUSSIONS</a></li>
                        <li><a href="#" class="btn-login">LOG IN</a></li>
                        <li><a href="#" class="btn-signup">SIGN UP</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>