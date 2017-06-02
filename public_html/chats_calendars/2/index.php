<!DOCTYPE html>
<html>
<head>
    <title>HTML5 Event Calendar</title>
	<!-- demo stylesheet -->
    	<link type="text/css" rel="stylesheet" href="media/layout.css" />    

        <link type="text/css" rel="stylesheet" href="themes/calendar_g.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_green.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_traditional.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_transparent.css" />    
        <link type="text/css" rel="stylesheet" href="themes/calendar_white.css" />    

	<!-- helper libraries -->
	<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
	
	<!-- daypilot libraries -->
        <script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
	
</head>
<body>
        <?php
		require_once ('../../db_and_functions.php');

		$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$chat_id = explode("/",$current_url)[5];
		$sql = "SELECT * FROM chats WHERE chat_id = $chat_id";
		$result=mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			while ($row = $result->fetch_assoc()) {
				$admin_user_id = $row['admin_user_id'];
				$chat_name = $row['chat_name'];
				$is_private = $row['is_private'];
				$allowed_users = $row['allowed_users'];
				if($is_private) {
					$not_allowed = true;
					$allowed_user_array = explode(",",$allowed_users);
					if(in_array($cookie_user_id, $allowed_user_array)) {
						$not_allowed = false;
					}
				}
				else {
					$not_allowed = false;
				}
			}
		}
							
		if(!$logged_in || $not_allowed) {
            echo '<meta http-equiv="refresh" content="0;url=index.php">';
		}
		?>
        <div id="header">
			<div class="bg-help">
				<div class="inBox" style="dir:rtl; text-align:right; margin-top:20px; margin-right:20px;">
					<h1 id="logo">יומן משימות לחדר צ'אט <?php echo $chat_name; ?></h1>
					<hr class="hidden" />
				</div>
			</div>
        </div>
        <div class="shadow"></div>
        <div class="hideSkipLink">
        </div>
        <div class="main">
            
            <div style="float:left; width: 160px;">
                <div id="nav"></div>
            </div>
            <div style="margin-left: 160px;">
                
                <div class="space">
                    Theme: <select id="theme">
                        <option value="calendar_default">Default</option>
                        <option value="calendar_white">White</option>                        
                        <option value="calendar_g">Google-Like</option>                        
                        <option value="calendar_green">Green</option>                        
                        <option value="calendar_traditional">Traditional</option>                        
                        <option value="calendar_transparent">Transparent</option>                        
                    </select>
                </div>
                
                <div id="dp"></div>
            </div>

            <script type="text/javascript">
                
                var nav = new DayPilot.Navigator("nav");
                nav.showMonths = 3;
                nav.skipMonths = 3;
                nav.selectMode = "week";
                nav.onTimeRangeSelected = function(args) {
                    dp.startDate = args.day;
                    dp.update();
                    loadEvents();
                };
                nav.init();
                
                var dp = new DayPilot.Calendar("dp");
                dp.viewType = "Week";

                dp.onEventMoved = function (args) {
                    $.post("backend_move.php", 
                            {
                                id: args.e.id(),
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Moved.");
                            });
                };

                dp.onEventResized = function (args) {
                    $.post("backend_resize.php", 
                            {
                                id: args.e.id(),
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Resized.");
                            });
                };

                // event creating
                dp.onTimeRangeSelected = function (args) {
                    var name = prompt("New event name:", "Event");
                    dp.clearSelection();
                    if (!name) return;
                    var e = new DayPilot.Event({
                        start: args.start,
                        end: args.end,
                        id: DayPilot.guid(),
                        resource: args.resource,
                        text: name
                    });
                    dp.events.add(e);

                    $.post("backend_create.php", 
                            {
                                start: args.start.toString(),
                                end: args.end.toString(),
                                name: name
                            }, 
                            function() {
                                console.log("Created.");
                            });

                };

                dp.onEventClick = function(args) {
                    alert("clicked: " + args.e.id());
                };

                dp.init();

                loadEvents();

                function loadEvents() {
                    var start = dp.visibleStart();
                    var end = dp.visibleEnd();

                    $.post("backend_events.php", 
                    {
                        start: start.toString(),
                        end: end.toString()
                    }, 
                    function(data) {
                        //console.log(data);
                        dp.events.list = data;
                        dp.update();
                    });
                }

            </script>
            
            <script type="text/javascript">
            $(document).ready(function() {
                $("#theme").change(function(e) {
                    dp.theme = this.value;
                    dp.update();
                });
            });  
            </script>

        </div>
        <div class="clear">
        </div>
        
</body>
</html>

