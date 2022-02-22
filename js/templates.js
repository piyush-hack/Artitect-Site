const swiperSlide = function (param, i) {

    let el = ""
    if (i > 0) {
        el = `<span class="mry-animation-el"></span></h1>`;
    }
    let swiperSlide =

        `<div class="swiper-slide">

        <!-- project -->
        <div class="mry-project-slider-item">
            <div class="mry-project-frame">
                <div class="mry-cover-frame">
                    <img class="mry-project-cover mry-position-right" src="${param[2]}" alt="Project" data-swiper-parallax="500"
                        data-swiper-parallax-scale="1.4">
                    <div class="mry-cover-overlay mry-gradient-overlay"></div>
                    <div class="mry-loading-curtain"></div>
                </div>
                <div class="mry-main-title-frame">
                    <div class="container">
                        <div class="mry-main-title" data-swiper-parallax-x="30%" data-swiper-parallax-scale=".7" data-swiper-parallax-opacity="0"
                            data-swiper-parallax-duration="1000">
                            <div class="mry-subtitle mry-mb-20">${param[4]}</div>
                            <h1 class="mry-mb-30">${param[1].split(' ').slice(0, 2).join(' ')}<br><span class="mry-border-text">${param[1].split(' ').slice(2,).join(' ')}</span>
                            ${el}
                            <div class="mry-text mry-mb-30">${param[5]}</div>
                            <a class="mry-btn mry-default-link mry-anima-link" href="contact.html">Contact</a>
                            <a class="mry-btn-text mry-default-link mry-anima-link" href="portfolio-grid-1.html">All Projects</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- project end -->

    </div>`

    return swiperSlide;
}


const gridSizer = function (param, i) {

    let gridSizer =

        `<div class="mry-masonry-grid-item mry-masonry-grid-item-33 mry-masonry-grid-item-h-x-2 ${ param[4].toLowerCase() }">

            <div class="mry-card-item">
                <div class="mry-card-cover-frame mry-mb-20 mry-fo">
                    <div class="mry-badge">${ param[4].toLowerCase() }</div>
                    <img src="${ param[2] }" alt="project" >
                    <div class="mry-cover-overlay"></div>
                    <div class="mry-hover-links">
                        <a href="${ param[2] }" data-fancybox="works" class="mry-zoom mry-magnetic-link"><span class="mry-magnetic-object"><i
                                    class="fas fa-expand"></i></span></a>
                        <!-- <a href="project.html" class="mry-more mry-magnetic-link mry-anima-link"><span class="mry-magnetic-object"><i class="fas fa-arrow-right"></i></span></a> -->
                    </div>
                </div>
                <div class="mry-item-descr mry-fo">
                    <h4 class="mry-mb-10"><a href="project.html">${ param[1] }</a></h4>
                    <div class="mry-text">${ param[5].replace(/\\/g, '') }</div>
                </div>
            </div>

        </div>`

    return gridSizer;
}
