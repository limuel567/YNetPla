    <footer id="footer" class="footer">
        @if(Request::segment(1) == '')
        <div class="container" style="background-image: url('{{$footer->section_first[1]->content}}');">
            <img src="{{$footer->section_first[0]->content}}" alt="">
        @elseif(Request::segment(2) != '')
        <div class="container" style="background-image: url('../{{$footer->section_first[1]->content}}');">
            <img src="../{{$footer->section_first[0]->content}}" alt="">
        @else
        <div class="container" style="background-image: url('{{$footer->section_first[1]->content}}');">
            <img src="{{$footer->section_first[0]->content}}" alt=""> 
        @endif
            <div class="row footer-nav">
                <ul>
                    <li><a href="#">PRIVACY POLICY</a></li>
                    <li><a href="#">TERMS AND CONDITION</a></li>
                    <li><a href="#">ABOUT US</a></li>
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>
            <div class="row form">
                <form>
                    <input type="text" placeholder="Enter your Email Address..">
                    <button>SEND</button>
                </form>
            </div>
            <div class="row social">
                <ul>
                    <li><a href="{{'https://facebook.com/'.unserialize($configuration->social_media_links)['facebook']}}"><i class="fa fa-2x fa-facebook"></i></a></li>
                    <li><a href="{{'https://twitter.com/'.unserialize($configuration->social_media_links)['twitter']}}"><i class="fa fa-2x fa-twitter"></i></a></li>
                    <li><a href="{{'https://plus.google.com/'.unserialize($configuration->social_media_links)['google']}}"><i class="fa fa-2x fa-google-plus"></i></a></li>
                    <li><a href="{{'https://pinterest.com/'.unserialize($configuration->social_media_links)['pinterest']}}"><i class="fa fa-2x fa-pinterest-p"></i></a></li>
                    <li><a href="{{'https://linkedin.com/'.unserialize($configuration->social_media_links)['linkedin']}}"><i class="fa fa-2x fa-linkedin"></i></a></li>
                    <li><a href="{{'https://instagram.com/'.unserialize($configuration->social_media_links)['instagram']}}"><i class="fa fa-2x fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>