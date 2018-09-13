
var clndr = {};
var secondClick = false;
var eventsGrouped = [];
jQuery( function($) {






  clndr = $('#full-clndr').clndr({
    template: $('#full-clndr-template').html(),
    events: events,
	startWithMonth: moment(),
	showAdjacentMonths: true,
	trackSelectedDate: false,
	//previousMonth: this.month.subtract(1, 'month').format('MMMM'),
	//nextMonth: this.month.add(1, 'month').format('MMMM'),
	multiDayEvents: {
	    startDate: 'date',
	    endDate: 'end'
	},
	extras:{
		firstDate : '',
		lastDate : '',
		category : ''
	},
    constraints: {
    	startDate: today,
		endDate:''
  },

  clickEvents: {
      click: function(target) {


	  		//Reset category on day click


		    if(defaultURL!=window.location && !jQuery.browser.msie){
			    window.history.pushState({path:defaultURL},'',defaultURL);
			}

			$('.filter-list li').removeClass('active');
		  	clndr.options.extras.category = '';


	  			//Single Day click
	      		if( !$('.clndr .days .day').hasClass('selected')  && $(target.element).hasClass('event')  ) {
			      	//if( !$('.clndr .days .day').hasClass('selected') && !$(target.element).hasClass('inactive') && $(target.element).hasClass('event') ) {
			        //console.log('You picked a valid date!');
			        //$('#list-title').html( moment(target.date._i).format('MMMM Do') );
				      markup = BuildEventBlock(target.events);
				      // put your new markup in the events container!
				      $('.clndr-event-list').html( markup );
				      //$('.clndr-sort-list span').removeClass('active');
				      //$('.clndr-sort-list .reset').show();
				      //console.log(target);
			      } else {
			        //console.log('That date is outside of the range.');
			      }

    },
    onMonthChange: function(month) {

		//console.log('you just went to ' + month.format('MMMM, YYYY'));
		//If no dates are selected, show the current months events
	 if( !(this.options.extras.lastDate || this.options.extras.firstDate) ) {
			 //console.log(this.options.extras.category);
		 	 $('#list-title').html( 'Events in ' + month.format('MMMM, YYYY') );

		 	 	eventsGrouped = $.makeArray( $(this.options.events).filter( function() {
			        // filter the dates down to the ones that match.
			        //console.log(this._clndrStartDateObject);
			       return (this._clndrStartDateObject.format("YYYY-MM") == month.format("YYYY-MM")  && this._clndrStartDateObject.isAfter( moment() ) );
			      }) );

		    // now you have an array eventsGrouped that will contain any events happening today.
		    if( !jQuery.isEmptyObject(eventsGrouped) ) {

				markup = BuildEventBlock(eventsGrouped );
				// put your new markup in the events container!
				$('.clndr-event-list').html( markup );
		    }else{
			    //No events
			     $('.clndr-event-list').html( '<div class="no-events">No events this month</div>' );
/*
				 console.log('bob');
			     	eventsGrouped = $.makeArray( $(this.options.events).filter( function() {
				        // filter the dates down to the ones that match.
				        //console.log(this._clndrStartDateObject);
				       return this._clndrStartDateObject.format("YYYY-MM").add(1, 'month') == month.format("YYYY-MM").add(1, 'month');
				      }) );

			      markup = BuildEventBlock(eventsGrouped );
				// put your new markup in the events container!
				$('.clndr-event-list').html( markup );
*/

		    }

		  }//end no dates selected


    	}
    },
/*
    ready: function () {
	    if( jQuery.isEmptyObject(this.options.events) ) {
		     $('.clndr-event-list').html( '<div class="no-events">No current Events</div>' );
		 }
    },
*/
    doneRendering: function() {

	  		//console.log(this.options.extras.firstDate);
	      //console.log('this would be a fine place to attach custom event handlers.');
		 // full_list = $('.clndr-event-list').html();
		  // make a moment object representing from date range
		  var target = moment();


		  if(this.options.events) {
		    // are any of the events happening today?


			//Filtered by category
		    if( this.options.extras.category ) {
			  current_cat = this.options.extras.category;
			    // eventDate = this._clndrStartDateObject;
			    //console.log(current_cat);
				if(current_cat =='past'){
				 	eventsGrouped = $.makeArray( $(this.options.events).filter( function() {

						  return ( this._clndrStartDateObject.isBefore( moment() )   );
				      }) );
				}else if(current_cat =='all'){
					console.log('all');
				 	eventsGrouped = $.makeArray( $(this.options.events).filter( function() {

						  return ( this._clndrStartDateObject.isAfter( moment() )   );
				      }) );
				}else{ //end if all upcoming
					 eventsGrouped = $.makeArray( $(this.options.events).filter( function() {

					      return (   this.cat_slug ==current_cat  && this._clndrStartDateObject.isAfter( moment() )   );
						  //return ( ( eventDate.isSame(moment(), 'day') || eventDate.isBefore(moment().add(1, 'year'), 'year') ) && (this.cat_slug ==current_cat || current_cat =='all' )  );
				      }) );
				}//end not past
			} else if(moment(target).isSame(moment(),'month')){ //Show all events for this week
					//console.log(this._clndrStartDateObject);
					 //console.log(moment());
					eventsGrouped = $.makeArray( $(this.options.events).filter( function() {
			        // filter the dates down to the ones that match.
					//console.log(this._clndrStartDateObject.isAfter( moment() ));
					//console.log(this._clndrStartDateObject);
					 //console.log(moment().startOf('day'));
			       return (this._clndrStartDateObject.format("YYYY-MM") == moment().format("YYYY-MM") && this._clndrStartDateObject.isAfter( moment().subtract(1, "days") ) );

			      }) );


		    }

			//console.log(this.options.extras.firstDate);


			$('.loading').hide();
					//console.log(eventsGrouped);
		    // now you have an array eventsGrouped that will contain any events happening today.
		    if( !jQuery.isEmptyObject(eventsGrouped) ) {

					    //loop through the events, making a <div> for each with relevation info
					  	markup = BuildEventBlock(eventsGrouped);
					  	//$('#list-title').html( moment(target.date._i).format('MMMM Do') );
				        // put your new markup in the events container!
				        $('.clndr-event-list').html( markup );

		    }else{
			    //No events
			     //$('.clndr-event-list').html( '<div class="no-events">No events this month</div>' );


			     eventsGrouped = $.makeArray( $(this.options.events).filter( function() {
			        // filter the dates down to the ones that match.
			        //console.log(moment(target).isSame(moment(),'month'));
			       return ( ( this._clndrStartDateObject.isAfter(moment(), 'month') && this._clndrStartDateObject.isBefore(moment().add(2, 'month'), 'month'))  );
			      }) );


			       //loop through the events, making a <div> for each with relevation info
					  	markup = BuildEventBlock(eventsGrouped);
					  	//$('#list-title').html( moment(target.date._i).format('MMMM Do') );
				        // put your new markup in the events container!
				        $('.clndr-event-list').html( '<div class="no-events">No events this month, check out next months.<br/><br/></div>' + markup );
		    }

		}
	},
});

function BuildEventBlock(events){
	      // loop through the events, making a <div> for each with relevation info
		  markup ='';
	      for(var i = 0; i < events.length; i++) {
	       	  markup += '<div id="" class="' + events[i].cat_slug + ' ' + events[i].past + '  row event-summery expand"  data-etype="' + events[i].cat + '" data-day="' + events[i].day + '" data-date="' + events[i].sort_date + '">';
	       	  markup += '<div class="col-sm-4 event-date text-right"><strong>'  + events[i].time_info + '</strong> <br/> ' + events[i].day+'</div>';
	       	  markup += '<div class="col-sm-8">';
	       	  markup += '<div class="event-cat">' + events[i].cat + '</div>';

              markup += '<div class="event-title"><h4><a href="' + events[i].url + '">' + events[i].title + '</a></h4></div>';
              markup += '<div class="event-excerpt">' + events[i].event_notes + '</div>';
              markup += '<div class="event-notes">';
              markup += '</div>';
              //markup += '<div class="more-details">more details</div>';
              //markup += '<div class="clndr-event-desc">';
              //markup += '<div class="event-artist">' + events[i].artists + '</div>';
              //markup += '<div class="event-location"><strong>' + events[i].location + '</strong></div>';
			  //markup += '</div>';
			  markup += '<hr/>';
			  markup += '</div>';//end info
			  markup += '</div>';//end row
			}

			 return markup;

}


		  if(current_slug!=''){
		  		//console.log(current_slug);
		  		clndr.options.extras.category = current_slug;
		  		clndr.render();

		  		jQuery(".filter-list a[data-filter='" + current_slug + "']").parent().addClass('active');
		  		$('#list-title').html( 'All '+jQuery(".filter-list a[data-filter='" + current_slug + "']").text()+' Events' );
          };

		  var $btns = $('.filter-list .filterit').click(function(event) {
				itsClass= $(this).data('filter');
	      		clndr.options.extras.firstDate = '';
		  		clndr.options.extras.lastDate = '';
		  		clndr.options.constraints.startDate = '';
				clndr.options.constraints.endDate = '';

		  		//pageurl = defaultURL;
		  		pageurl = defaultURL+'type/'+itsClass+'/';

			    if(pageurl!=window.location && !jQuery.browser.msie){
				    window.history.pushState({path:pageurl},'',pageurl);
				}




			  if (itsClass == 'all') {
				  clndr.options.extras.category = 'all';
				  clndr.options.constraints.startDate = today;
				  //$('.clndr-event-list > div').fadeIn(450);
				  listTitle = 'All Upcoming Events';
			  }else if(itsClass == 'past') {
				  //console.log(itsClass);
			   		//$('.clndr-event-list > div').fadeIn(450);
			    	listTitle = 'All Past Events';
			    	clndr.options.extras.category = itsClass;
					clndr.options.constraints.startDate = '';
					clndr.options.constraints.endDate= today;

			   } else {
			   		// var $el = $('.' + itsClass).fadeIn(450);
			   		// $('.clndr-event-list > div').not($el).hide();
			   		listTitle = 'All ' +$(this).text() +' Events';
			   		clndr.options.extras.category = itsClass;
			  }

			  clndr.render();

			  $('#list-title').html( listTitle );


			  $btns.parent().removeClass('active');
			  $(this).parent().addClass('active');



			  event.preventDefault();

})



// show event description
/*
	$('.clndr-event-list .expand').on('click','.more-details',function(e){
			e.preventDefault();
			var desc = $(this).parent().find('.clndr-event-desc');
			//console.log(desc);
			if (!desc.find('a').hasClass('button')) {
				var eventUrl = $(this).find('a').attr('href');
				// create a button to go to event url
				desc.append('<a href="' + eventUrl + '"  class="button">view event</a>')
			}
			if (desc.is(':visible')) {
				desc.slideUp();
			} else {
					$('.clndr-event-list').find('.clndr-event-desc').slideUp();
				desc.slideDown();
			}
	});
*/





/*
	//Sort events by date or type
$('.clndr-sort-list').on('click','a',function(event){
		  event.preventDefault();
		$('.list-headers').remove();
		$('.clndr-sort-list li').removeClass('active');
		$(this).parent().addClass('active');
		var type = $(this).parent().data('type');
		var last ='';
		if(type=='type'){
			$('div.clndr-event-list>div').tsort({order:'asc',attr:'class'});
			$('div.clndr-event-list>div').tsort({order:'asc',attr:'class'},{order:'asc',data:'date'});
			$('div.clndr-event-list').children().each(function(){
				 var header = $(this).data('etype');
				 if( last != header ){
				 	$(this).before('<div class="list-headers">'+header+'</div>');
				};
				last=header;
				$('.clndr-sort-list .reset').show();
			});
		}else if(type=='date'){
			$('div.clndr-event-list>div').tsort({order:'asc',data:'date'});
			$('div.clndr-event-list').children().each(function(){
				 var header = $(this).data( "day" );
				 if( last != header ){
				 	$(this).before('<div class="list-headers">'+header+'</div>');
				};
				last=header;
				$('.clndr-sort-list .reset').show();
			});
		}else if(type=='reset'){
			 	clndr.options.constraints.startDate = '';
		      	clndr.options.constraints.endDate = '';
		      	clndr.render();
			$('.clndr-sort-list li.date').addClass('active');
			// $('.clndr-event-list').html( full_list );
			  $('.clndr-sort-list .reset').hide();
		};
	});
*/



});