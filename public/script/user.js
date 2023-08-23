var hideMenu = null,
	mainBnr = null,
	mainEvent = null,
	sponBnr = null,
	mainSponsor = null,
	photoList = null;

// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	initial();

	var win_w = $(window).width();

	if (win_w > 768) {
		//PC
		setting_pc();

			if ($("div.diabetesIntro").length) {
				$("ul.introMenu a").on("mouseenter", function(){
					var nIdx = $(this).parent().index();
					if (nIdx == "0") 	{
						$("ul.introMenu").addClass("general");
					} else {
						$("ul.introMenu").addClass("doctor");
					}
				});
				$("ul.introMenu a").on("mouseleave", function(){
					$("ul.introMenu").removeClass("general");
					$("ul.introMenu").removeClass("doctor");
				});
			}

		} else {
		//Mobile
			setting_mobile();

		}

		if ($("div#container").attr("class") == "main") {
			$("div.wrapper").addClass("mainWrap");

	}

	$("dl.login dt a").on({
		click :	function(){
			$(this).toggleClass("on");
			$("dl.login dd").toggle();
		},
	});


	// 탭메뉴
	var tabArea = $(".tabArea");

	if (tabArea.length) {

		for (var i=0 ; i<tabArea.length ; i++) {
			var tabMenu = tabArea.eq(i).find("ul.tabMenu > li"),
				tabCon = tabArea.eq(i).find(".tabCon");

			tabMenu.removeClass("on").eq(0).addClass("on");
			tabCon.hide().eq(0).show();
		}


		tabArea.on("click", "ul.tabMenu a", function(){
			var currTabMenu =  $(this).parent().parent().parent().find("ul.tabMenu li"),
				currTabCon =  $(this).parent().parent().parent().find(".tabCon"),
				currIdx = $(this).parent().index();

			currTabMenu.removeClass("on").eq(currIdx).addClass("on");
			currTabCon.hide().eq(currIdx).show();

			return false
		});

	}

	var rwTabArea = $(".rwTabArea");
	if (rwTabArea.length) {
		var rwTabMenu = rwTabArea.find("ul.rwTabMenu li"),
			rwTabCon = rwTabArea.find("div.tabCon");

		rwTabMenu.eq(0).addClass("on");
		rwTabCon.hide().eq(0).show();

		rwTabMenu.on("click", "a",  function(){
			var win_w = $(window).width(),
				nIdx = $(this).parent().index(),
				menuTxt = $(this).text();

			if (win_w < 961) {
					rwTabArea.find("dl.rwMenu > dt").removeClass("view");
					rwTabArea.find("dl.rwMenu > dt").find("i").attr("class",  function(i){
						var src = $(this).attr("class");
						return src.replace("-up", "-down");
					});
					rwTabArea.find(".toggleCon").slideUp();
			}
			rwTabArea.find("a.trigger span").text(menuTxt);
			rwTabMenu.removeClass("on").eq(nIdx).addClass("on");
			rwTabCon.hide().eq(nIdx).show();


			return false
		});
	}


	//toggle
	$(document).on("click","a.trigger",function() {
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");

		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-down", "-up");
			});
			_currToggle.find(".toggleCon").slideDown();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-up", "-down");
			});
			_currToggle.find(".toggleCon").slideUp();
		}

		return false
	});

	$('#create_member').validate({
		rules: {
			'member_name' : 'required',
			'member_id': 'required',
			'passwd': 'required'
		},
		invalidHandler: function (event, validator) {
			if (validator.numberOfInvalids() > 0) {
				var first_error = validator.errorList[0];

				var name = first_error.element.getAttribute('name');

				if( $(event.target).attr('id') == 'update_member' ){
					if (name === 'member_id') {
						alert('아이디를 입력하세요.');
						return false;
					} else if (name === 'member_name') {
						alert('이름을 입력하세요.');
						return false;
					}
					onsubmit();
				} else {
					if (name === 'member_id') {
						alert('아이디를 입력하세요.');
					} else if (name === 'passwd') {
						alert('비밀번호를 입력하세요.');
					} else if (name === 'member_name') {
						alert('이름을 입력하세요.');
					}
				}
			}
		},
		errorPlacement: function (label, element) {
			//
		},
		success: function (label, element) {
			//
		},
		highlight: function (element, errorClass) {
			//
		},
		unhighlight: function (element, errorClass) {
			//
		}
	});
});



// 브라우저창 사이즈가 변경될 때
$(window).resize(function(){
	initial();


	var win_w = $(window).width();
	if (win_w > 768) {
	//PC
		setting_pc();

	} else {
	//Mobile
		setting_mobile();
	}
});



//공통 이벤트
function initial(){
	$(".viewMenu a, ul#gnb, ul#gnb ul, ul#gnb > li, ul#gnb > li > a, #lnb p a").off();

	$("ul.headerMenu .search a").off();
	$("ul.headerMenu .search a, div.mainSponsor ul, div.mainSponsor li").removeClass("view");

	var win_w = $(window).width();
	if (win_w > 767) {
		//PC
			$("div.gnbSearch").show();
		} else {
		//Mobile
			if ($("div.allSearch").length) {
				$("ul.headerMenu .search a").addClass("view");
				$("div.gnbSearch").show();
			}

			$("ul.headerMenu .search a").on("click", function(){

				if ($(this).attr("class") == "view") {
					$(this).removeClass("view");
					$("div.gnbSearch").slideUp();
				} else {
					$(this).addClass("view");
					$("div.gnbSearch").slideDown();
				}

				return false
			});

			$("div.viewMenu a").on("click", function(){

				if ($(this).attr("class") == "close") {
					$("body").removeClass("overHidden");
					$(this).removeClass("close");

					$("div.gnbWrap").animate({
						"left":"100%"
					}, 500);

				} else {
					$("body").addClass("overHidden");
					$(this).addClass("close");

					$("div.gnbWrap").animate({
						"left":0
					}, 500);
				}

				return false
			});
	}

	//위로가기 버튼
	var wingBnrPosition = parseInt($("div.mainCon").css("top"));
	$(window).scroll(function() {
		var position = $(window).scrollTop();
		if (position > 700) 	{
			$("div.mainCon").addClass("animation");
			$("div.mainCon").show();
		} else {

		}
	});

	if ($("div.login").length) {
		var win_h = $(window).height(),
			login_h = $("div.login div.formArea").outerHeight() + 200;

		if (login_h > win_h) {
			reH = login_h

		}  else {
			reH = $(window).height()
		}

		$("div.login").outerHeight(reH);
	}


	if (sponBnr != null) {
		sponBnr.destroySlider();
		$("div.mainSponsor ul, div.mainSponsor li").removeAttr("style");
	}

	$("div.mainSponsor ul, div.mainSponsor li").removeAttr("style");
	var win_w = $(window).width();
	if (win_w > 768) {
		//PC
			if ($("div.mainSponsor li").length > 7) {
				sponBnr = $("div.mainSponsor ul").bxSlider({
					maxSlides:7,
					minSlides:7,
					moveSlides:1,
					slideWidth:160,
					pause:3000,
					slideMargin:15,
					pager:false,
					auto:true,
					controls:true
				});
			}
		} else {
		//Mobile
			if ($("div.mainSponsor li").length > 3) {
				sponBnr = $("div.mainSponsor ul").bxSlider({
					maxSlides:3,
					minSlides:3,
					moveSlides:1,
					pause:3000,
					slideWidth:100,
					slideMargin:15,
					pager:false,
					auto:true,
					controls:true
				});
			}
	}


	$("dl.rwMenu dt, dl.rwMenu dd, dl.rwMenu li").removeAttr("style");
	$("dl.rwMenu .view, .toggleMenu .view").removeClass("view");


	if ($("dl.rwMenu").length) {

		for (var i=0; i<$("dl.rwMenu").length;i++) {
			var _currMenu = $("dl.rwMenu").eq(i),
				menuEA = $("dl.rwMenu").eq(i).find("dd li");

			if (menuEA.length > 4) {
				var win_w = $(window).width();
				if (win_w > 960) {
				//PC
					_currMenu.find("dt").hide();
					var reW = 100 / menuEA.length;
					_currMenu.find("li").css({
						"width" : reW + "%"
					});
					_currMenu.find("dd > ul").removeClass("noBg, col2ea, col3ea, col4ea");

				} else {
				//Mobile
					_currMenu.find("dt").show();
					_currMenu.find("dd").hide();
					_currMenu.find("dd > ul").addClass("noBg");
				}

			} else {
				var win_w = $(window).width();
				if (win_w > 960) {
				//PC
					_currMenu.find("dt").hide();

					if (menuEA.length == 2) {
						_currMenu.find("dd > ul").addClass("col2ea")
					} else 	if (menuEA.length == 3) {
						_currMenu.find("dd > ul").addClass("col3ea")
					} else 	if (menuEA.length == 4) {
						_currMenu.find("dd > ul").addClass("col4ea")
					}

					/*
					_currMenu.removeClass("rwMenu")
						.find("dd.toggleCon").removeClass("toggleCon");
					*/
				} else {
				//Mobile
				}
			}
		}
	}

	/*
	if ($("div.lnbWrap").length == 0) {
		$("div.titArea").addClass("noLnb");
	}


	 if ($("dl.lnb2").length) {
		var win_w = $(window).width(),
			reW = 0;
		if (win_w > 960) {
		//PC
			for (var i=0;i<$("dl.lnb2 li").length;i++){
				var lnb2_subW =$("dl.lnb2 li").eq(i).outerWidth();
				reW = reW + lnb2_subW
			}

			if (reW > 1300) {
				var lnb2_re_subW = 1300 / $("dl.lnb2 li").length
				$("dl.lnb2 ul").addClass("tblCell");
				$("dl.lnb2 li").css({"width":lnb2_re_subW});
			}

		} else {
		//Mobile
			$("dl.lnb2 li").removeAttr("style");
		}
	}

	if ($("ul.lnb4").length) {
		$("ul.lnb4, div.contents").removeAttr("style");
		$("dl.lnb3 > dd > ul").removeClass("sub");
		$("ul.lnb4").removeClass("col2ea col3ea col4ea");

		var win_w = $(window).width();
		if (win_w > 960) {
		//PC
			$("dl.lnb3 > dd > ul").addClass("sub");
			var re_paddingT = parseInt($("div.contents").css("padding-top")) + $("ul.lnb4").outerHeight();
			$("div.contents").css({
				"padding-top":re_paddingT
			});

			var menuW = $("dl.lnb3 > dd").outerWidth(),
				menuW_ea = menuW / $("dl.lnb3 > dd > ul > li").length,
				num = $("dl.lnb3 > dd > ul > li.on").index(),
				menu_po = ((win_w - menuW) / 2) + (menuW_ea * num),
				total_w = menu_po + parseInt($("ul.lnb4").outerWidth()),
				space = menuW + ((win_w - menuW) / 2)

				if (total_w > space) {
					menu_po = menu_po - (total_w - space);
				}

				$("ul.lnb4").css({
					"left":menu_po
				})


		} else {
		//Mobile
			var menuEA = $("ul.lnb4 li").length
			if (menuEA == 2) {
				$("ul.lnb4").addClass("col2ea")
			} else 	if (menuEA == 3) {
				$("ul.lnb4").addClass("col3ea")
			} else 	if (menuEA == 4) {
				$("ul.lnb4").addClass("col4ea")
			}
		}
	}*/


	if (mainBnr != null) {
		mainBnr.destroySlider();
		$("div.mainBnr ul, div.mainBnr li").removeAttr("style");
		mainBnr = null;
	}
	$("div.mainBnr ul, div.mainBnr li").removeAttr("style");

	if ($("div.mainBnr li").length) {
		var win_w = $(window).width();
		if (win_w > 960) {
			var reH = 470;
		} else {
			var reH = $("div.mainBnr img").height();
		}

		mainBnr = $("div.mainBnr ul").bxSlider({
			slideMargin:20,
			auto:true
		});
		$("div.mainBnr div.bx-viewport").css("opacity", 0);

		setTimeout(function(){
			var win_w = $(window).width();
			if (win_w > 960) {
				var reW = 772,
					reNum = 792 * (-1);
			} else {
				var reW = $("div.mainBnr").outerWidth(),
					reNum = ((reW + 20)) * (-1);
			}

		$("div.mainBnr div.bx-viewport").css("opacity", 1);
			$("div.mainBnr ul").css({
				"transform": "translate3d(" + reNum + "px, 0px, 0px)"
			});
			$("div.mainBnr li").css("width", reW);
		}, 20);

	}


	if (mainEvent != null) {
		mainEvent.destroySlider();
		$("dl.mainSchedule ul, dl.mainSchedule li").removeAttr("style");
		mainEvent = null;
	}

	if ($("dl.mainSchedule li").length) {
		mainEvent = $("dl.mainSchedule ul").bxSlider({
			mode:"vertical",
			pause:5000,
			speed:1000,
			slideMargin:10,
			pager:false,
			auto:true
		});

	}


	//게시판 타이틀관련
	if ($("table.bbs").length) {
		$("table.bbs .tit a").removeAttr("style");

		var win_w = $(window).width();
		if (win_w > 960) {
			//PC
			var reW = $("table.bbs").find(".tit").width();
			$("table.bbs .tit a").css({
				"max-width":reW
			})
		}
	}

	if ($("div.year").length) {
		$("div.year a.prev, div.year a.next").off();
		$("div.year ul, div.year li").removeAttr("style");

		var win_w = $(window).width(),
			yearCon_w = $("div.year").width();

		if (win_w > 960) {
			//PC
			var yearEA_w = $("div.year li").outerWidth(),
				year_w = yearEA_w * $("div.year li").length;

			$("div.year ul").css("width",year_w);

			for (var i=0;i<$("div.year li").length;i++) {
				var sClass = $("div.year li").eq(i).attr("class");
				if (sClass == "on") {
					var num = i
				}
				re_marginLeft = yearEA_w * (num - 2) * (-1);

				$("div.year ul").css({
					"margin-left":re_marginLeft
				})
			}

		} else {
			//Mobile
			var yearEA_w = $("div.year").width() / 3,
				year_w = yearEA_w * $("div.year li").length;

			$("div.year ul").css("width",year_w);
			$("div.year li").css("width",yearEA_w);

			for (var i=0;i<$("div.year li").length;i++) {
				var sClass = $("div.year li").eq(i).attr("class");
				if (sClass == "on") {
					var num = i
				}
				re_marginLeft = yearEA_w * (num - 1) * (-1);

				$("div.year ul").css({
					"margin-left":re_marginLeft
				})
			}
		}
	}


	$("div.year a.prev").on("click", function(){
		var marginLeft = parseInt($("div.year ul").css("margin-left")),
			yearCon_w = $("div.year").width(),
			year_w = yearEA_w * $("div.year li").length,
			basic_w = (year_w + marginLeft);


		if (marginLeft >= yearEA_w) {
			alert("다음 년도 일정이 없습니다.");
		} else {
			var re_marginLeft = marginLeft + yearEA_w;

			$("div.year ul").animate({
				"margin-left":re_marginLeft
			}, 200);
		}

		return false
	});

	$("div.year a.next").on("click", function(){
		var marginLeft = parseInt($("div.year ul").css("margin-left")),
			year_w = yearEA_w * $("div.year li").length,
			yearCon_w = $("div.year").width(),
			basic_w = (year_w + marginLeft);

		for (var i=0;i<$("div.year li").length;i++) {
			var sClass = $("div.year li").eq(i).attr("class");
			if (sClass == "on") {
				var num = i
			}
		}


		var re_marginLeft = marginLeft - yearEA_w;

		if ((basic_w < yearCon_w)) {
			alert("이전 년도 일정이 없습니다.");
		} else {
			$("div.year ul").animate({
				"margin-left":re_marginLeft
			}, 200);
		}


		return false
	});
}



//모바일 화면 세팅 함수
function setting_mobile() {
	$("div.wrapper, div#headerWrap, #goTop, #floatingMenu, div#container").removeAttr("style");
	$("ul#gnb ul, div.gnbBg").removeAttr("style");
	$("div.mainBbs ul, div.mainBbs li, div.mainEvent ul, div.mainEvent li, div.kafmService dl, div.bnrZone ul, div.bnrZone li").removeAttr("style");

	$("ul#gnb > li, div.mainCon").off();

	$("div.lnbWrap dt a").off();
	$("div.lnbWrap dt.view").removeClass("view");



	setTimeout(function(){
		var win_h = $(window).height(),
			header_h = $("div#headerWrap").outerHeight(),
			footer_h = $("div#footerWrap").outerHeight(),
			con_minH = win_h - header_h - footer_h;

		$("div#container").css({"min-height":con_minH});
	}, 300);

	//GNB
	/*$(".viewMenu a").on("click", function(){
		$("div.gnbWrap").animate({
			"left":0
		}, 500);
		return false
	});

	$(".gnbClose a").on("click", function(){
		$("div.gnbWrap").animate({
			"left":"100%"
		}, 500);
		setTimeout(function(){
			$("dl.allMenu dt").removeClass("on");
			$("dl.allMenu dt").eq(0).addClass("on");
		}, 500);
		return false
	});*/

	$("ul#gnb > li > a").on("click", function(){

		if ($(this).parent().attr("class") == "on") {

			$(this).parent().removeClass("on");
			$(this).next().slideUp();

		} else {

			$(this).parent().addClass("on");
			$(this).next().slideDown();
		}

		return false
	});


	$("dl.allMenu dt a").on("click", function(){
		if ($(this).parent().attr("class") == "on") {
			$(this).parent().removeClass("on");
		} else {
			$("dl.allMenu dt").removeClass("on");
			$(this).parent().addClass("on");
		}
		return false
	});

	//포토갤러리
	if (photoList != null) {
		photoList.destroySlider();
		$("div.photoList ul, div.photoList li").removeAttr("style");
		photoList = null;
	}


	if ($("div.photoView").length) {
		var imgSrc = $("div.photoList ul > li:first-child img").attr("src");
		$("div.bigPhoto img").attr("src", imgSrc);

		$("div.photoList ul li").on("click", function(){
			var imgSrc = $(this).find("img").attr("src"),
				viewNum = $(this).attr("pub-num");
			$("div.bigPhoto img").attr("src", imgSrc);
			$("div.photoList span").text(viewNum);
			return false
		});
	}


	if ($("div.photoList li").length > 3) {
		var photoEA = $("div.photoList li").length;
		for (var i = 0;i < photoEA ; i++) {
			var nIdx = $("div.photoList li").eq(i).index() + 1;
			$("div.photoList li").eq(i).attr("pub-num", nIdx);
		}


		if ($("div.photoList div.pager").length < 1)	{
			$("div.photoList").append('<div class="pager"><span>1</span> / ' + photoEA + '</div>');
		} else {
			$("div.photoList span").text('1');
		}

		photoList = $("div.photoList ul").bxSlider({
			minSlides:3,
			maxSlides:3,
			moveSlides:1,
			pause:6000,
			speed:1000,
			slideWidth:80,
			slideMargin:10,
			infiniteLoop:false,
			hideControlOnEnd:true,
			pager:false,
			touchEnabled: true,
			controls:true,
			onSlideNext: function($slideElement, newIndex) {
				var num = parseInt($("div.photoList div.pager span").text()) + 1;

				if (num > photoEA) {
					num = '1'
				}
				$("div.photoList div.pager span").text(num);
				var viewNum = num - 1;
					imgSrc = $("div.photoList img").eq(viewNum).attr("src");
				$("div.bigPhoto img").attr("src", imgSrc);
			},
			onSlidePrev: function($slideElement, newIndex) {
				var num = parseInt($("div.photoList div.pager span").text()) - 1;
				if (num < 1) {
					num = parseInt(photoEA)
				}
				$("div.photoList div.pager span").text(num);
				var viewNum = num - 1;
					imgSrc = $("div.photoList img").eq(viewNum).attr("src");
				$("div.bigPhoto img").attr("src", imgSrc);
			}
		});


	}

}

//PC 화면 세팅 함수
function setting_pc() {
	$("body").removeClass("overHidden");
	$("div.wrapper, div.gnbWrap, ul#gnb ul").removeAttr("style");
	$("div#container, dl.toggleArea_rw > dd, div.photoList li").removeAttr("style");

	$("ul#gnb > li, dl.allMenu dt a, .allMenu a").off();

	$("div.lnbWrap dt.view").removeClass("view");
	$("div.lnbWrap dt a").off();


	// animation
	/* $(window).scroll(function() {
		var position = $(window).scrollTop();
		if (position > 50) 	{
			$(".mainCon").addClass("animation");
			$(".mainCon").show();
		} else {

		}
	});*/


	//LNB
	if ($("div.lnbWrap").length) {
		hideMenu = null;

		$("div.lnbWrap *").removeAttr("style");
		$("div.lnbWrap dd.toggleCon").show();

		for (var i=0;i<$("div.lnbWrap dl").length;i++) {
			var reW = $("div.lnbWrap dl").eq(i).outerWidth() + 20;

			$("div.lnbWrap dl").eq(i).width(reW).find("dd").hide();
		}

		$("dl.depth1 dt a").on("click", function(){
			return false
		});

	}

	//GNB
	if ($("div.gnbBg").length == 0) {
		$("div#headerWrap").append('<div class="gnbBg"></div>');
	}
	var gnbBg = $("div.gnbBg"),
		hideMenu = null,
		gnbBg_h = $("ul#gnb > li:first-child ul").outerHeight();

	gnbBg.height(gnbBg_h);
	$("ul#gnb ul").hide();

	gnbBg.on("mouseenter", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu);
		}
	});

	$("ul#gnb > li > a").on("mouseenter", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu);
		}

		gnbBg.height(gnbBg_h);

		if ($(this).parent().attr("class") != "on") {
			$("ul#gnb ul").slideDown();
			gnbBg.slideDown();

			$("ul#gnb > li").removeClass("on");
			$(this).parent().addClass("on");

		} else {
			$("ul#gnb ul").slideUp();
			gnbBg.slideUp();
			$("ul#gnb > li").removeClass("on");
		}
		return false
	});

	// 헤더 외 다른곳 클릭시 헤더 메뉴 닫기
	$(document).mouseup(function(e) {

		var container = $("ul#gnb li");

		if (!container.is(e.target) && container.has(e.target).length === 0){

			$("ul#gnb > li").removeClass("on");
			$("ul#gnb ul").hide();
			gnbBg.hide();
		}
	});

	/* $(window).scroll(function(){
		var scrollH = $(window).scrollTop();
		if (scrollH > 0) {
			$("div#headerWrap").addClass("fixed");
			gnbBg.addClass("fixed");
		} else {
			$("div#headerWrap").removeClass("fixed");
			gnbBg.removeClass("fixed");
		}
	});*/

	/* $(window).scroll(function(){
		var scrollH = $(window).scrollTop();
		if (scrollH > 0) {
			$("div#headerWrap").addClass("fixed");
			gnbBg.addClass("fixed");
		} else {
			$("div#headerWrap").removeClass("fixed");
			gnbBg.removeClass("fixed");
		}
	}); */

	//사이트맵보기
	// $(".allMenu a").on("click", function(){
	// 	$("div.allMenu").show();
	// 	return false
	// });
	$("li.allMenu a").on("click", function(){
		$("div.allMenu").show();
		return false
	});

	$("div.allMenuClose a").on("click", function(){
		$("div.allMenu").hide();
		return false
	});


	if ($("dl.rwMenu").length) {

		for (var i=0; i<$("dl.rwMenu").length;i++) {
			var _currMenu = $("dl.rwMenu").eq(i),
				menuEA = $("dl.rwMenu").eq(i).find("dd li");


			if (menuEA.length > 4) {
				_currMenu.find("dt").hide();
				var reW = 100 / menuEA.length;
				_currMenu.find("li").css({
					"width" : reW + "%"
				});
				_currMenu.find("dd > ul").removeClass("noBg");

			} else {
				_currMenu.find("dt").hide();

				if (menuEA.length == 2) {
					_currMenu.find("dd > ul").addClass("col2ea")
				} else 	if (menuEA.length == 3) {
					_currMenu.find("dd > ul").addClass("col3ea")
				} else 	if (menuEA.length == 4) {
					_currMenu.find("dd > ul").addClass("col4ea")
				}

				/*
				_currMenu.removeClass("rwMenu")
					.find("dd.toggleCon").removeClass("toggleCon");
				*/
			}
		}
	}




	//floatingMenu
	var foatingPosition = parseInt($("#floatingMenu").css("top")),
		foating_h = $("#floatingMenu").outerHeight();


	$("#floatingMenu dl").on("click", "dt a", function(){
		if ($("#floatingMenu dl").attr("class") == "hide") {
			$("#floatingMenu dl").removeClass("hide");
			$("#floatingMenu dd").show();
		} else {
			$("#floatingMenu dl").addClass("hide");
			$("#floatingMenu dd").hide();
		}

		return false
	});

	$(window).scroll(function() {
		var position = $(window).scrollTop(),
			scroll_h = position+foatingPosition,
			remove_h = scroll_h - foating_h;

		if (remove_h < 365) {
			remove_h = 365
		}
		$("#floatingMenu").stop().animate({"top": remove_h +"px"},1000);

	});


	//위로가기 버튼

	var wingBnrPosition = parseInt($("#goTop").css("top"));
	$(window).scroll(function() {
		var position = $(window).scrollTop();
		$("#goTop").stop().animate({"top":position+wingBnrPosition+"px"},1000);
		if (position > 100) 	{
			$("p#goTop").show();
		} else {
			$("p#goTop").hide();
		}
	});




	//포토갤러리
	if (photoList != null) {
		photoList.destroySlider();
		$("div.photoList ul, div.photoList li").removeAttr("style");
		photoList = null;
	}

	if ($("div.photoView").length) {
		var imgSrc = $("div.photoList ul > li:first-child img").attr("src");
		$("div.bigPhoto img").attr("src", imgSrc);

		$("div.photoList li").on("click", function(){
			var imgSrc = $(this).find("img").attr("src"),
				viewNum = $(this).attr("pub-num");
			$("div.bigPhoto img").attr("src", imgSrc);
			$("div.photoList span").text(viewNum);
			return false
		});
	}



	if ($("div.photoList li").length > 6) {
		var photoEA = $("div.photoList li").length;

		var photoEA = $("div.photoList li").length;
		for (var i = 0;i < photoEA ; i++) {
			var nIdx = $("div.photoList li").eq(i).index() + 1;
			$("div.photoList li").eq(i).attr("pub-num", nIdx);
		}

		if ($("div.photoList div.pager").length < 1)	{
			$("div.photoList").append('<div class="pager"><span>1</span> / ' + photoEA + '</div>');
		}

		photoList = $("div.photoList ul").bxSlider({
			minSlides:6,
			maxSlides:6,
			moveSlides:1,
			pause:6000,
			speed:1000,
			slideWidth:130,
			slideMargin:20,
			pager:false,
			touchEnabled: true,
			infiniteLoop:false,
			hideControlOnEnd:true,
			controls:true,
			onSlideNext: function($slideElement, newIndex) {
				var num = parseInt($("div.photoList div.pager span").text()) + 1;

				if (num > photoEA) {
					num = '1'
				}
				$("div.photoList div.pager span").text(num);
				var viewNum = num - 1;
					imgSrc = $("div.photoList img").eq(viewNum).attr("src");
				$("div.bigPhoto img").attr("src", imgSrc);
			},
			onSlidePrev: function($slideElement, newIndex) {
				var num = parseInt($("div.photoList div.pager span").text()) - 1;
				if (num < 1) {
					num = parseInt(photoEA)
				}
				$("div.photoList div.pager span").text(num);
				var viewNum = num - 1;
					imgSrc = $("div.photoList img").eq(viewNum).attr("src");
				$("div.bigPhoto img").attr("src", imgSrc);
			}
		});

		setTimeout(function(){
			photoList.redrawSlider()
		}, 300)


	}




}

function lnb_fixed() {
	var scrollValue = $(window).scrollTop(),
		basic_h = $(".pageTit").outerHeight();
	if (scrollValue > basic_h) {
		$("div.lnbWrap").addClass("fixed")
	} else {
		$("div.lnbWrap").removeClass("fixed")
	}
}

function adminPopUp(url) {
	if( $("#adminPopUp").attr('dis') == '0' ){

		$.ajax({
			type: "get"
			,url: '/member/admin'
			,dataType : 'JSON'
			,success: function(data) {
				if( data.length > 0 ){
					var html = '';
					data.forEach(function(val, key, arr){
						html += `
							<tr id="member${val['sid']}">
								<td>${key+1}</td>
								<td>${val['member_name']}</td>
								<td>${val['member_id']}</td>
								<td class="sort">
									<a href="javascript:void(0)" class="edit" onclick="adminUpdateMember(${val['sid']});">수정</a>
									<a href="javascript:void(0)" class="del" onclick="adminDeleteMember(${val['sid']});">삭제</a>
								</td>
							</tr>
						`;
					});
					$("#memberList").html(html);
				}
			}, error: function(data){
				console.log(data);
			}
		});

		$("#adminPopUp").css('display', 'block');
		$("#adminPopUp").attr('dis', '1');
	} else {
		$("#adminPopUp").css('display', 'none');
		$("#adminPopUp").attr('dis', '0');
	}
}

function adminUpdateMember(key){
	$("#create_memberBtn").hide();
	$("#update_memberBtn").show();
	$("#create_member").attr('action', '/member/update');
	$("#create_member").attr('id', 'update_member');
	$('input[name=member_name]').val( $("#member"+key).children('td')[1].innerHTML );
	$('input[name=member_id]').val( $("#member"+key).children('td')[2].innerHTML );
	$("#sid").val(key);
}

function adminDeleteMember(key){

	if( confirm('삭제하시겠습니까?') ){
		$.ajax({
			type: "get"
			,url: '/member/destroy'
			,dataType : 'JSON'
			,data : {
				sid : key
			}
			,success: function(data) {
				alert(data.msg);
				location.reload();
				return false;
			}, error: function(data){
				console.log(data);
				return false;
			}
		});
	}
	
}

function memberLogout(){
	Swal.fire({
		title: '로그아웃 하시겠습니까?',
		confirmButtonText: `네`,
		showCancelButton: true,
		cancelButtonText: `아니오`,
		// showDenyButton: true,
		// denyButtonText: `Don't save`,
	  }).then((result) => {
		if (result.isConfirmed) {
			$("#logout-form").submit();
		} else if (result.isDismissed) {
			$("dl.login dt a").toggleClass("on");
			$("dl.login dd").toggle();
		}
	});
}

function swalYesOrNo( swaltitle, formId ){

	Swal.fire({
		title: swaltitle,
		confirmButtonText: `네`,
		showCancelButton: true,
		cancelButtonText: `아니오`,
	}).then((result) => {
			if( result.isConfirmed ){
				$("#"+formId).find("input[name=swalBool]").val('true');
				$("#"+formId).submit();
			} else {
				$("#"+formId).find("input[name=swalBool]").val('false');
			}
	});

}







