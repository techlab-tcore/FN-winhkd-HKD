$(window).resize(function(){
	isH5 = ($(window).width() < 992) ? true : false;
	let vh = window.innerHeight * 0.01;
	document.documentElement.style.setProperty('--vh', `${vh}px`);
}).resize();

$(function(){
	if (getUrlParameter('show')){
		var showPopUp = getUrlParameter('show');
		$('#'+showPopUp+'Btn').click();
	}
	
	if( !logged )
	{
		$('.marquee').marquee({
			duration:12000,
			gap:0,
			delayBeforeStart:-5000,
			direction: 'left',
			duplicated: true,
			pauseOnHover:true
		});
	}

	/*Desktop View*/
	$('#bannerSlick').slick({
		infinite:false,
		arrows:false,
		dots:true,
		dotsClass:'slick-dots',
		autoplay:true,
		customPaging:function(slider, i) {
			return '';
		},
	});

	$('.gameSlick').each(function(){
		$(this).slick({
			infinite:false,
			slidesToShow:4.5,
			slidesToScroll: 4,
			vertical:true,
			verticalSwiping:true,
			dots:true,
			swipeToSlide:true,
			swipe:true,
			dotsClass:'slick-dots',
			customPaging:function(slider, i) {
				return '';
			},
			prevArrow:'<i class="slick-prev icon-chevron-up-fill"></i>',
			nextArrow:'<i class="slick-next icon-chevron-up-fill"></i>',
		});
	})
	
	/*Mobile View*/ 
	$('#providerSlick').slick({
		infinite:false,
		dots:false,
		prevArrow:'<i class="slick-prev icon-chevron-left"></i>',
		nextArrow:'<i class="slick-next icon-chevron-right"></i>',
		slidesToShow:4,
	});

	$('.header-sticky .slick-slider').slick({
		slidesToShow: 5,
		infinite:false,
		prevArrow:'<i class="slick-prev icon-chevron-left-fill"></i>',
		nextArrow:'<i class="slick-next icon-chevron-right-fill"></i>',
	});

	customSelectStyle();
});

function gameSlick(elementId)
{
	if ($('#' + elementId).children().length > 5){
		$('#' + elementId).slick({
			infinite:false,
			slidesToShow:5.5,
			slidesToScroll: 5,
			vertical:true,
			verticalSwiping:true,
			dots:true,
			swipeToSlide:true,
			swipe:true,
			dotsClass:'slick-dots',
			customPaging:function(slider, i) {
				return '';
			},
			prevArrow:'<i class="slick-prev icon-chevron-up-fill"></i>',
			nextArrow:'<i class="slick-next icon-chevron-up-fill"></i>',
		});
	}

	$('#' + elementId).css("opacity", ""); 
}

/* Url paramater */
function updateParam(key,value){
	var url = new URL(window.location);
	url.searchParams.set(key, value);
	//window.history.pushState({}, '', url);
	window.history.replaceState({}, '', url);
}

function getUrlParameter(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/*Header*/
$(document).on('click','#hamburger',function(){
	$(this).toggleClass('active');
	$('#offcanvas').toggleClass('active');
	if ($(this).hasClass('active')){
		$('body').addClass('off-scroll');
	} else {
		$('body').removeClass('off-scroll');
	}
})

$(document).on('click','.langSwitcher',function(){
	$('.langSwitcher').toggleClass('active');
	$('.langDropdown').slideToggle();
})
	
$(document).on('click','#quicklinkBtn',function(){
	$(this).parent().toggleClass('active');
	$('#quicklinkDropdown').slideToggle();
})

/*Nav*/
$(document).on("click", ".tabNav [target]", function() { 
	var tar = $(this).attr('target');
	$(this).closest('.tabNav').find('[target]').removeClass('cur');
	$(this).addClass('cur');
	var childSlider = $(tar).find('.slick-slider');
	if (childSlider.length){
		childSlider.css('opacity','0').slick("refresh");
		childSlider.on('afterChange',function(event, slick){
			childSlider.animate({opacity: 1}, 500);
		});
	}
	$(tar).show().siblings('.tabContent').hide();
});

$(document).on('click','.btnSelections input',function(){
	$(this).addClass('cur').siblings().removeClass('cur');
})

/* Time*/
function checkTime(i) {
  if (i < 10) i = "0" + i;
  return i;
}

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  $('#timeShow').text(h + ":" + m + ":" + s + " GMT+8");
  t = setTimeout(function() {
    startTime()
  }, 1000);
}
startTime();

/*back to top*/
function backToTop(){
	$("html, body").animate({scrollTop: 0}, 1000);
}

$(window).scroll(function() {
    if ($(this).scrollTop()) {
        $('#toTop').fadeIn();
    } else {
        $('#toTop').fadeOut();
    }
});

function customSelectStyle(){
	$('select.customSelect').each(function(){
		var html = '<input class="form-control formSelect select-list-input" value="'+$(this).find("option:selected").text()+'" readonly>';
		var val = $(this).val();
		//dropdown
		html += '<ul class="select-list formSelectList collapse">';
		$(this).find('option').each(function(){
			var cur = '';
			if ($(this).val() == val){cur = 'class="selected"'}
			html += '<li '+cur+' value="' + $(this).val() + '">'+ $(this).text() +'</li>';
		});
		html += '</ul>';
		$(this).after(html);
	})
}

$(document).on('click','.formSelect',function(){
	$(this).toggleClass('active');
	$(this).next('.formSelectList').slideToggle(300);
})

$(document).on('click','.formSelectList li',function(){
	var list = $(this).closest('.formSelectList');
	var wrap = $(this).closest('.select-wrap');
	$(this).addClass('selected').siblings().removeClass('selected');
	list.slideUp(300);
	wrap.find('.formSelect').removeClass('active').val($(this).text());
	wrap.find('.customSelect').val($(this).attr('value'));
})

$(document).on('change','.customSelect',function(){
	var wrap = $(this).closest('.select-wrap');
	wrap.find('li[value='+$(this).val()+']').addClass('selected').siblings().removeClass('selected');
	wrap.find('.formSelect').val(wrap.find('option:selected').text());
})

/****************TEMP*************/
$("form").submit(function(e) {
    e.preventDefault();
});