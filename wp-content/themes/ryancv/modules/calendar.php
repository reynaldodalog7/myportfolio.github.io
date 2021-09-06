<?php
	$title = get_sub_field( 'title' );
	$items = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!-- 
	Calendar
-->
<div class="content calendar">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row border-line-v">
		<div class="col col-m-12 col-t-12 col-d-12">
			<?php if ( $items ) : ?>
			<div class="custom-calendar-wrap">
				<div id="custom-inner" class="custom-inner">
					<div class="custom-header clearfix">
						<nav>
							<span id="custom-prev" class="custom-prev"></span>
							<span id="custom-next" class="custom-next"></span>
						</nav>
						<div id="custom-month" class="custom-month"></div>
						<div id="custom-year" class="custom-year"></div>
					</div>
					<div id="calendar" class="fc-calendar-container"></div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>

</div>

<script>
	( function( $ ) {
		$(window).on("load", function() {

			/*
				Calendar
			*/

			$(document).on('shown.calendar.calendario', function(e, instance){
				if(!instance) instance = cal;
				var $cell = instance.getCell(new Date().getDate());
				if($cell.hasClass('fc-today')) $cell.trigger('click.calendario');
			});

			var c_events = {
				<?php foreach ( $items as $item ) { ?>
				'<?php echo esc_attr( $item['date'] ); ?>' : '<span class="event-name">'+'<?php echo esc_attr( $item['description'] ); ?>'+'</span>',
				<?php } ?>
			};

			var transEndEventNames = {
				'WebkitTransition' : 'webkitTransitionEnd',
				'transition' : 'transitionend'
			},
			transEndEventName = transEndEventNames[Modernizr.prefixed('transition')],
			$wrapper = $('#custom-inner'),
			$calendar = $('#calendar'),
			cal = $calendar.calendario({
				onDayClick:function($el, data, dateProperties) {
					if(data.content.length > 0 ) {
						showEvents(data.content, dateProperties);
					}
				},
				caldata : c_events,
				displayWeekAbbr : true,
				events: 'click'
			}),
			$month = $('#custom-month').html(cal.getMonthName()),
			$year = $('#custom-year').html(cal.getYear());

			// navigations
			$('#custom-next').on('click', function() {
				cal.gotoNextMonth(updateMonthYear);
			});
			$('#custom-prev').on('click', function() {
				cal.gotoPreviousMonth(updateMonthYear);
			});

			// update dates
			function updateMonthYear() {                
				$month.html(cal.getMonthName());
				$year.html(cal.getYear());
			}

			// calendar event description popup
			function showEvents( contentEl, dateProperties ) {
				hideEvents();
				var $events = $('<div id="custom-content-reveal" class="custom-content-reveal"><span class="event-date">' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</span></div>'),
				$close = $('<span class="custom-content-close"></span>').on('click', hideEvents);
				$events.append(contentEl.join(''), $close).insertAfter($wrapper);
				setTimeout( function() {
					$events.css('bottom', '0%');
				}, 25);
			}
			function hideEvents() {
				var $events = $('#custom-content-reveal');
				if( $events.length > 0 ) {
					$events.css('bottom', '-100%');
					Modernizr.csstransitions ? $events.on(transEndEventName, function() {
						$(this).remove();
					}):$events.remove();
				}
			}
		});
	} )( jQuery );
</script>