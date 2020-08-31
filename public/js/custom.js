document.addEventListener('DOMContentLoaded',function(){

    var wrapper = document.querySelector('.wrapper-content');
        menu = document.querySelector('.menu');
        navLink = document.querySelectorAll('.nav-link');
        status = 'under 50';
        logo = document.querySelector('a.logo');
        navigation = document.querySelector('.Navigation');
        icon = document.querySelectorAll('.icon');
        dropContent = document.querySelectorAll('.drop-content');
        backToTop = document.querySelector('.back-to-top');


    // Scroll
    window.addEventListener('scroll',function(){

        if( window.pageYOffset > 50 ){
           if (status == 'under 50'){
                status = 'over 50';
                menu.classList.add('transform1');
                logo.classList.add('scale-down');
                navigation.classList.add('animated');
                navigation.classList.add('fadeInDown');
                backToTop.classList.add('opacity');
           }
        }

        else if ( window.pageYOffset <= 50){
            if (status =='over 50'){
                status = 'under 50';
                menu.classList.remove('transform1');
                logo.classList.remove('scale-down');
                navigation.classList.remove('animated');
                navigation.classList.remove('fadeInDown');
                backToTop.classList.remove('opacity');
            }
        }
    });

    for (let i = 0; i < icon.length; i++) {

        icon[i].addEventListener('click',function(e){
            e.preventDefault();
            if( this.classList[1] == 'active'){
                this.classList.remove('active');

                var showContent = icon[i].getAttribute('data-appearance');
                part_Of_show_Content = document.getElementById(showContent);
                part_Of_show_Content.classList.remove('show1');
            }

            else {

                for (let j = 0; j < icon.length; j++) {
                    icon[j].classList.remove('active')
                }
                this.classList.toggle('active');

                var showContent = icon[i].getAttribute('data-appearance');
                part_Of_show_Content = document.getElementById(showContent);
                for (let k = 0; k < dropContent.length; k++) {
                    dropContent[k].classList.remove('show1');
                }
                part_Of_show_Content.classList.toggle('show1');
            }
        })
    }

    // input search

    function testSearch(){
        var inputSearch = document.formlable1.search;
        var giatriSearch = inputSearch.value;
        var notice = document.getElementById('notify');
        if ( giatriSearch ==''){
          notice.style.display ='block';
          notice.innerHTML = 'Please type something!';
          return false;
        }
        else {
          return true;
        }
      }



},false);

// Jquery
$(document).ready(function () {
    $('.back-to-top').click(function(e){
        e.preventDefault();
        $('html').animate({scrollTop: 0},700);
        return false;
    })
});

