$js2=jQuery.noConflict();


	
	$js2(document).ready(function(){
		$js2(document).scroll(function() {    
		 
		var scroll = $js2(this).scrollTop();
			if (scroll >= 20) {
					$js2( '#mynav' ).addClass( "scrolled" );
			}else{
					$js2( '#mynav' ).removeClass( "scrolled" );
			}
		});
		
		if ($js2(".smooth-scroll").length>0) {
			$js2('.smooth-scroll a[href*=#]:not([href=#]), a[href*=#]:not([href=#]).smooth-scroll').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
					var target = $js2(this.hash);
					target = target.length ? target : $js2('[name=' + this.hash.slice(1) +']');
					if (target.length) {
						$js2('html,body').animate({
							scrollTop: target.offset().top-151
						}, 1000);
						return false;
					}
				}
			});
		}
		

				// Animations
		//-----------------------------------------------
		if (($js2("[data-animation-effect]").length>0) && !Modernizr.touch) {
			$js2("[data-animation-effect]").each(function() {
				var $this = $js2(this),
				animationEffect = $this.attr("data-animation-effect");
				if(Modernizr.mq('only all and (min-width: 768px)') && Modernizr.csstransitions) {
					$this.appear(function() {
						setTimeout(function() {
							$this.addClass('animated object-visible ' + animationEffect);
						}, 400);
					}, {accX: 0, accY: -130});
				} else {
					$this.addClass('object-visible');
				}
			});
		};



		// Isotope filters
		//-----------------------------------------------
		if ($js2('.isotope-container').length>0) {
			$js2(window).load(function() {
				$js2('.isotope-container').fadeIn();
				var $container = $js2('.isotope-container').isotope({
					itemSelector: '.isotope-item',
					layoutMode: 'masonry',
					transitionDuration: '0.6s',
					filter: "*"
				});
				// filter items on button click
				$js2('.filters').on( 'click', 'ul.nav li a', function() {
					var filterValue = $js2(this).attr('data-filter');
					$js2(".filters").find("li.active").removeClass("active");
					$js2(this).parent().addClass("active");
					$container.isotope({ filter: filterValue });
					return false;
				});
			});
		};

		//Modal
		//-----------------------------------------------
		if($js2(".modal").length>0) {
			$js2(".modal").each(function() {
				$js2(".modal").prependTo( "body" );
			});
		}


		
	});

