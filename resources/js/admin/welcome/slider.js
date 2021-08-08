// click on slider
const slider = {
    prev: document.querySelector('.prev'),
    next: document.querySelector('.next'),
    slides: document.querySelectorAll('.mySlides'),
    curIndex: 0,
    nextSlide: function() {
        this.curIndex += 1;
        if (this.curIndex >= this.slides.length) {
            this.curIndex = 0;
        }
    },
    prevSlide: function() {
        this.curIndex -= 1;
        if (this.curIndex < 0) {
            this.curIndex = this.slides.length - 1;
        }
    },
    loadCurSlide: function() {
        if (document.querySelector('.mySlides.active')) {
            document.querySelector('.mySlides.active').classList.remove('active');
        }
        for (let i = 0; i < this.slides.length; i++) {
            if (i == this.curIndex) {
                this.slides[i].classList.add('active');
            }
        }
    },
    autoload: function() {
        this.nextSlide();
        this.loadCurSlide();
    },
    handle: function() {
        const _this = this;
        this.prev.onclick = function() {
            _this.prevSlide();
            _this.loadCurSlide();
        }
        this.next.onclick = function() {
            _this.nextSlide();
            _this.loadCurSlide();
        }
    },
    start: function() {
        this.loadCurSlide();
        this.handle();
        setInterval(function() {
            slider.autoload();
        },5000)
    }
}
slider.start();
