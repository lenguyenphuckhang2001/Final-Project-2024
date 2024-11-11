<section id="wsus__counter" style="background-image: url({{ asset(@$statistical->background) }});">
    <div class="wsus__counter_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <span class="counter">{{ @$statistical->number_first }}</span>
                        <p>{{ @$statistical->title_first }}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <span class="counter">{{ @$statistical->number_second }}</span>
                        <p>{{ @$statistical->title_second }}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <span class="counter">{{ @$statistical->number_third }}</span>
                        <p>{{ @$statistical->title_third }}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <span class="counter">{{ @$statistical->number_fourth }}</span>
                        <p>{{ @$statistical->title_fourth }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
