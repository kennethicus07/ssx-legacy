<div class="section contact lightgreen-bg" id="contactUs">
    <div class="featured">
        <div class="image"><img src="/assets/images/Contact-Form-Home-and-About.jpg" alt=""></div>
    </div>
    <div class="content contact-content mt-5 pb-5">
        <div class="double flex">
            <div class="left">
                <h2>{{ $title }}</h2>
                <h3>{{ $subtitle }}</h3>
                <p>{{ $details }}</p>
                <h4>FOLLOW US ON OUR SOCIAL MEDIA!</h4>
                <p class="ico-holder">
                    <a href="{{ env('APP_SOCIAL_FACEBOOK') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ env('APP_SOCIAL_TWITTER') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="{{ env('APP_SOCIAL_INSTAGRAM') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                </p>
            </div>
            <div class="right">
                <contact-us-form></contact-us-form>
            </div>
        </div>
    </div>
</div>