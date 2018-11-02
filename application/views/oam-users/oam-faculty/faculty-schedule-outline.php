<br><br><div><b><center><?php echo $user_info['u_full_name']; ?> SCHEDULE OUTLINE</center></b></div>
<div class="cd-schedule loading">
	<div class="timeline">
		<ul>
			<li><span>08:00</span></li>
			<li><span>08:30</span></li>
			<li><span>09:00</span></li>
			<li><span>09:30</span></li>
			<li><span>10:00</span></li>
			<li><span>10:30</span></li>
			<li><span>11:00</span></li>
			<li><span>11:30</span></li>
			<li><span>12:00</span></li>
			<li><span>12:30</span></li>
			<li><span>13:00</span></li>
			<li><span>13:30</span></li>
			<li><span>14:00</span></li>
			<li><span>14:30</span></li>
			<li><span>15:00</span></li>
			<li><span>15:30</span></li>
			<li><span>16:00</span></li>
			<li><span>16:30</span></li>
			<li><span>17:00</span></li>
			<li><span>17:30</span></li>
			<li><span>18:00</span></li>
			<li><span>18:30</span></li>
			<li><span>19:00</span></li>
			<li><span>19:30</span></li>
			<li><span>20:00</span></li>
			<li><span>20:30</span></li>
		</ul>
	</div> <!-- .timeline -->

	<div class="events">
		<ul>
			<li class="events-group">
				<div class="top-info"><span>Monday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='MONDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-1">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Tuesday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='TUESDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-2">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Wednesday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='WEDNESDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-1">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Thursday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='THURSDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-4">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Friday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='FRIDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-5">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Saturday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='SATURDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-3">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>

			<li class="events-group">
				<div class="top-info"><span>Sunday</span></div>

				<ul>
					<?php if(!empty($schedules)): ?>
						<?php foreach ($schedules as $value): ?>
							<?php if($value['day']=='SUNDAY'): ?>
								<li class="single-event" data-start="<?php echo rtrim(rtrim($value['time'],'0'),':'); ?>" data-end="<?php echo rtrim(rtrim(date('H:i:s',strtotime('+1 hour +30 minutes',strtotime($value['time']))),'0'),':'); ?>" data-content="event-abs-circuit" data-event="event-2">
									<a href="#0">
										<em class="event-name"><?php echo $value['subject_code']; ?></em>
										<em class="h5"><?php echo $value['room_name']; ?></em>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
		</ul>
	</div>

	<div class="event-modal">
		<header class="header">
			<div class="content">
				<span class="event-date"></span>
				<h3 class="event-name"></h3>
			</div>

			<div class="header-bg"></div>
		</header>

		<div class="body">
			<div class="event-info"></div>
			<div class="body-bg"></div>
		</div>

		<a href="#0" class="close">Close</a>
	</div>

	<div class="cover-layer"></div>
</div> <!-- .cd-schedule -->
</body>
</html>