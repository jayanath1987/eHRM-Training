<script type='text/javascript' src="<?php echo public_path('../../scripts/fullcalendar-1.5.2/jquery/jquery-1.5.2.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo public_path('../../scripts/fullcalendar-1.5.2/jquery/jquery-ui-1.8.11.custom.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo public_path('../../scripts/fullcalendar-1.5.2/fullcalendar/fullcalendar.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo public_path('../../scripts/jquery/sagimann.localizer.js') ?>"></script>
<?php if($culture=="en"){ ?>
<script type='text/javascript' src="<?php echo public_path('../../scripts/localization/training/strings-es.js') ?>"></script>
<?php }else if($culture=="si"){ ?>
<script type='text/javascript' src="<?php echo public_path('../../scripts/localization/training/strings-si.js') ?>"></script>
<?php }else if($culture=="ta"){ ?>
<script type='text/javascript' src="<?php echo public_path('../../scripts/localization/training/strings-ta.js') ?>"></script>

<?php } ?>   
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>

<link rel='stylesheet' type='text/css' href="<?php echo public_path('../../scripts/fullcalendar-1.5.2/fullcalendar/fullcalendar.css') ?>" />
<link rel='stylesheet' type='text/css' href="<?php echo public_path('../../scripts/fullcalendar-1.5.2/fullcalendar/fullcalendar.print.css') ?>" media='print' />
<style type="text/css">
.fc-event-skin {
    background-color: #999966;
    border-color: #999966;
    color: #FFFFFF;
}
</style>

<div class="formpage4col">
    <div class="navigation">
    </div>
 <div class="outerbox"> 
     <br class="clear">   
<div id='calendar'></div>
    <br class="clear">  
 </div>
</div>

<script type='text/javascript' charset="utf-8">
          
           
	$(document).ready(function() {
                
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
                
                var myArray2= new Array();
                var name;
                <?php foreach ($courseList as $course) { ?>
                   <?php  if($culture=="en"){ ?>
                       name='<?php echo $course->td_course_name_en; ?>';
                <?php  }else{ ?>
                      <?php $column="td_course_name_".$culture; 
                            if($course->$column==null){ ?>
                             name='<?php echo $course->td_course_name_en; ?>';   
                      <?php  }else{ ?>
                             name='<?php echo $course->$column; ?>';   
                      
                      <?php } }   ?>;  
                   myArray2.push({title: name ,start: new Date("<?php echo $course->td_course_fromdate; ?>"),end: new Date("<?php echo $course->td_course_todate; ?>"), url: "<?php echo url_for('training/SaveTrainRequest?insid='.$course->td_inst_id.'&cid1='.$course->td_course_id) ?>" });     
                        
                <?php } ?>

                
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title'
                                //,     
				//right: 'month,agendaWeek,agendaDay'
			},
			//selectable: true,
			//selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Event Title:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{      
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			//editable: true,
                        
                        
                        
			events: 
                            
                            myArray2
		
                        
		});
	$('html').localize();	
        
$('.fc-button-inner').click(function(){
    var t=setTimeout("alertMsg()",1);

});
        
        
	});
function alertMsg()
{

$('html').localize();
}
</script>
<style type='text/css'>

	body {
		
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 750px;
                height: 100%;
		margin: 0 auto;
		}
        .fc-widget-header{
                 background: khaki;   
                }        

</style>

