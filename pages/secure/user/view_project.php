<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';
@require_once __DIR__ . '/../../../helpers/project.php';
@require_once __DIR__ . '/../../../helpers/task.php';
@require_once __DIR__ . '/../../../helpers/productivity.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';

$stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
$categories = array("Undetermined", "Professional", "Academic", "Personal", "Health", "Technology", "Art", "Community", "Business", "General");
$priorities = array("Undetermined", "Not Important", "Normal", "Important");

$project = project($_GET['id']);
if ($project) {
	foreach ($project as $k => $v) {
		$$k = $v;
	}
}

$prog = 0;
$tasksWithProjectId = getTasksWithProjectId($id);
$tasksWithProjectIdAndStatus = getTasksWithProjectIdAndStatus($id, 3);
$productivitiesWithProjectId = getProductivitiesWithProjectId($id);

$tprog = 0;
$cprog = 0;
$prod = 0;

foreach($tasksWithProjectId as $task):
	$tprog++;
endforeach;

foreach ($tasksWithProjectIdAndStatus as $task2):
	$cprog++;
endforeach;

foreach ($productivitiesWithProjectId as $productivity):
	$prod++;
endforeach;

$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
$prog = $prog > 0 ? number_format($prog, 2) : $prog;

if ($project['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($project['start_date'])):
	if ($prod > 0 || $cprog > 0)
		$project['status'] = 2;
	else
		$project['status'] = 1;
elseif ($project['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($project['end_date'])):
	$project['status'] = 4;
endif;

$manager = getUserWithId($manager_id);
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-dark text-center" style="margin-top: 20px;"><strong>&nbsp;</strong></h4>
		</div>
	</div>
</div>

<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<span><b>Project Info:</b></span>
					<?php if (administrator() || $project['manager_id'] == $user['id']): ?> 
					<div class="card-tools">
						<button class="btn btn-block btn-sm btn-default btn-rounder" type="button" id="edit_project" data-id="<?php echo $project['id'] ?>">
							<i class="fa fa-edit"></i>
							 	<strong>Edit Project</strong>
						</button>
					</div>
					<?php endif; ?>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<div class="row">
							<div class="col-sm-5">
								<dl>
									<dt><b>Project Name</b></dt>
									<dd><?php echo ucwords($title); ?></dd>
									<dt><b>Description</b></dt>
									<dd><?php echo html_entity_decode($description); ?></dd>
								</dl>
							</div>
							<div class="col-md-5">
								<dl>
									<dt><b>Start Date</b></dt>
									<dd><?php echo date("F d, Y", strtotime($start_date)); ?></dd>
								</dl>
								<dl>
									<dt><b>End Date</b></dt>
									<dd><?php echo date("F d, Y", strtotime($end_date)); ?></dd>
								</dl>
								<dl>
									<dt><b>Project Manager</b></dt>
									<dd>
										<?php if (isset($manager['id'])): ?>
											<div class="d-flex align-items-center mt-1">
											<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="/BuyTime/assets/uploads/<?php echo $manager['foto'] ?>" alt="Avatar">
											<b><?php echo ucwords($manager['name'] . ' ' . $manager['lastname']) ?></b>
										</div>
										<?php else: ?>
											<small><i>Manager Deleted from Database</i></small>
										<?php endif; ?>
									</dd>
								</dl>
							</div>
							<div class="col-md-2">
								<dl>
									<dt><b>Status</b></dt>
									<dd>
										<?php
										if ($stat[$status] == 'Pending') {
											echo "<span class='badge badge-p'>{$stat[$status]}</span>";
										} elseif ($stat[$status] == 'Started') {
											echo "<span class='badge badge-s'>{$stat[$status]}</span>";
										} elseif ($stat[$status] == 'On-Progress') {
											echo "<span class='badge badge-op'>{$stat[$status]}</span>";
										} elseif ($stat[$status] == 'On-Hold') {
											echo "<span class='badge badge-oh'>{$stat[$status]}</span>";
										} elseif ($stat[$status] == 'Over Due') {
											echo "<span class='badge badge-od'>{$stat[$status]}</span>";
										} elseif ($stat[$status] == 'Done') {
											echo "<span class='badge badge-s'>{$stat[$status]}</span>";
										}
										?>
									</dd>
								</dl>
								<dl>
									<dt><b>Category</b></dt>
									<dd>
										<?php
											echo "<span class='badge badge-bt'>{$categories[$category]}</span>";
										?>
									</dd>
								</dl>
								<dl>
									<dt><b>Priority</b></dt>
									<dd>
										<?php
											if ($priorities[$priority] == 'Undetermined') {
												echo "<span class='badge badge-p'>{$priorities[$priority]}</span>";
											} elseif ($priorities[$priority] == 'Not Important') {
												echo "<span class='badge badge-oh'>{$priorities[$priority]}</span>";
											} elseif ($priorities[$priority] == 'Normal') {
												echo "<span class='badge badge-s'>{$priorities[$priority]}</span>";
											} elseif ($priorities[$priority] == 'Important') {
												echo "<span class='badge badge-od'>{$priorities[$priority]}</span>";
											}
										?>
									</dd>
								</dl>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<span><b>Team Member/s:</b></span>
					<div class="card-tools"></div>
				</div>
				<div class="card-body">
					<ul class="users-list clearfix">
						<?php
						if (!empty($user_ids)):
						$members = getUsersWithIds($user_ids);
						foreach ($members as $member):
						?>
						<li>
							<img src="/BuyTime/assets/uploads/<?php echo $member['foto']; ?>" alt="User Image">
							<a href="javascript:void(0)" class="users-list-name"><?php echo ucwords($member['name'] . ' ' . $member['lastname']); ?></a>
						</li>
						<?php
						endforeach;
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<span><b>Task List:</b></span>
					<?php if (administrator() || $project['manager_id'] == $user['id']): ?>
					<div class="card-tools">
						<button class="btn btn-block btn-sm btn-default btn-rounder" type="button" id="new_task">
							<i class="fa fa-plus"></i>
							 	<strong>New Task</strong>
						</button>
					</div>
					<?php endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-condenses m-0 table-hover">
							<colgroup>
								<col width="5%">
								<col width="25%">
								<col width="30%">
								<col width="15%">
								<col width="15%">
							</colgroup>
							<thead>
								<th>#</th>
								<th>Task</th>
								<th>Description</th>
								<th>Status</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<?php
									$i = 1;
									$tasksWithProjectId = getTasksWithProjectId($id);

									foreach ($tasksWithProjectId as $task):
									
									$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($task['description']), $trans);
									$desc = str_replace(array("<li>","</li>"), array("",", "), $desc);
								?>
								<tr>
									<td class="text-center"><?php echo $i++; ?></td>
									<td><b><?php echo ucwords($task['task']); ?></b></td>
									<td><p class="truncate"><?php echo strip_tags($desc) ?></p></td>
									<td>
										<?php
			                        	if($task['status'] == 1){
									  		echo "<span class='badge badge-p'>Pending</span>";
			                        	}elseif($task['status'] == 2){
									  		echo "<span class='badge badge-op'>On-Progress</span>";
			                        	}elseif($task['status'] == 3){
									  		echo "<span class='badge badge-d'>Done</span>";
			                        	}
										?>
									</td>
									<td class="text-center">
										<button class="btn btn-action btn-sm btn-rounder wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
											Actions
										</button>
										<div class="dropdown-menu">
											<a href="javascript:void(0)" class="dropdown-item view_task" data-id="<?php echo $task['id'] ?>" data-task="<?php echo $task['task'] ?>">View</a>
											<?php if (administrator() || $project['manager_id'] == $user['id']): ?>
											<div class="dropdown-divider"></div>
											<a href="javascript:void(0)" class="dropdown-item edit_task" data-id="<?php echo $task['id'] ?>" data-task="<?php echo $task['task'] ?>">Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $task['id'] ?>">Delete</a>
											<?php endif; ?>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<b>Members Progress/Activity</b>
					<div class="card-tools">
						<button class="btn btn-block btn-sm btn-default btn-rounder" type="button" id="new_productivity">
							<i class="fa fa-plus"></i>
							 	<strong>New Productivity</strong>
						</button>
					</div>
				</div>
				<div class="card-body">
					<?php
					$progress = getProductivityFullWithProjectId($id);
					foreach($progress as $prog):
					?>
					<div class="post">
						<div class="user-block">
							<?php if ($user['id'] == $prog['user_id']): ?>
							<span class="btn-group dropleft float-right">
								<span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
									<i class="fa fa-ellipsis-v"></i>
								</span>
								<div class="dropdown-menu">
									<a class="dropdown-item manage_progress" href="javascript:void(0)" data-id="<?php echo $prog['id'] ?>" data-task="<?php echo $prog['task'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $prog['id'] ?>">Delete</a>
								</div>
							</span>
							<?php endif; ?>
							<img src="/BuyTime/assets/uploads/<?php echo $prog['foto'];?>" alt="User Image" class="img-circle img-bordered-sm">
							<span class="username">
								<a href="#"><?php echo ucwords($prog['uname']) ?> [ <?php echo ucwords($prog['task']) ?> ]</a>
		                    </span>
							<span class="description">
								<span class="fa fa-calendar-day"></span>
								<span><b><?php echo date('M d, Y',strtotime($prog['date'])) ?></b></span>
								<span class="fa fa-user-clock"></span>
								<span>Start: <b><?php echo date('h:i A',strtotime($prog['date'].' '.$prog['start_time'])) ?></b></span>
								<span> | </span>
								<span>End: <b><?php echo date('h:i A',strtotime($prog['date'].' '.$prog['end_time'])) ?></b></span>
							</span>
						</div>
						<div>
							<?php echo html_entity_decode($prog['comment']); ?>
						</div>
						<?php if ($prog['attachment'] != ''): ?>
						<div>
							<div class="dropdown-divider"></div>
							<strong>Attachment:</strong>
							<a href="/BuyTime/assets/attachments/<?php echo $project['id']; ?>/<?php echo $prog['attachment']; ?>" download><?php echo $prog['attachment']; ?></a>
						</div>
						<?php endif; ?>
					</div>
					<div class="post clearfix"></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.users-list > li img {
	    border-radius: 50%;
	    height: 67px;
	    width: 67px;
	    object-fit: cover;
	}

	.users-list > li {
		width: 33.33% !important
	}

	.truncate {
		-webkit-line-clamp:1 !important;
	}
</style>

<script>
	$('#new_task').click(function(){
		uni_modal("New Task For <?php echo ucwords($title) ?>", "/BuyTime/templates/manage_task.php?pid=<?php echo $id ?>", "mid-large");
	});

	$('.edit_task').click(function(){
		uni_modal("Edit Task: "+$(this).attr('data-task'), "/BuyTime/templates/manage_task.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),"mid-large");
	});

	$('.view_task').click(function(){
		uni_modal("Task Details", "/BuyTime/templates/view_task.php?id="+$(this).attr('data-id'), "mid-large");
	});

	$('#new_productivity').click(function(){
		uni_modal("<i class='fa fa-plus'></i> New Progress", "/BuyTime/templates/manage_progress.php?pid=<?php echo $id ?>", 'large');
	});

	$('.manage_progress').click(function(){
		uni_modal("<i class='fa fa-edit'></i> Edit Progress", "/BuyTime/templates/manage_progress.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'), 'large');
	});

	$('.delete_progress').click(function(){
		_conf("Are you sure to delete this progress ?", "delete_progress", [$(this).attr('data-id')])
	});

	$('.delete_task').click(function(){
		_conf("Are you sure to delete this task ?", "delete_task", [$(this).attr('data-id')])
	});

	$('#edit_project').click(function() {
		window.location = "/BuyTime/pages/secure/index.php?page=edit_project&edit=true&id=" + [$(this).attr('data-id')];
	});

	function delete_progress($id){
		start_load()
		$.ajax({
			url:'/BuyTime/helpers/ajax.php?action=delete_progress',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					}, 1500);
				} else {
					alert_toast(resp);
					end_load();
				}
			}
		})
	}

	function delete_task($id){
		start_load()
		$.ajax({
			url:'/BuyTime/helpers/ajax.php?action=delete_task',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					}, 1500);
				} else {
					alert_toast(resp);
					end_load();
				}
			}
		})
	}
</script>