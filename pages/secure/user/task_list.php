<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-dark text-center" style="margin-top: 20px;"><strong>&nbsp;</strong></h4>
		</div>
	</div>
</div>

<div class="row">
<div class="col-lg-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
				<a href="./index.php?page=new_project" class="btn btn-block btn-sm btn-default btn-rounder">
					<i class="fa fa-plus"></i>
					<strong>Create New Project</strong>
				</a>
			</div>
		</div>
		<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Project</th>
						<th>Task</th>
						<th>Project Started</th>
						<th>Project Due Date</th>
						<th>Project Status</th>
						<th>Task Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					@require_once __DIR__ . '/../../../helpers/project.php';
					@require_once __DIR__ . '/../../../helpers/task.php';
					@require_once __DIR__ . '/../../../helpers/productivity.php';

					$i = 1;
					$where = "";

					if (!administrator()) {
						$where = " WHERE p.manager_id = " . $user['id'] . " OR FIND_IN_SET(" . $user['id'] . ", p.user_ids) > 0";
						//$where = " WHERE p.manager_id = " . $user['id'] . ";";
					}

					$status = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
					$tasks = getTasksContainingProjects($where);

					foreach ($tasks as $task):
						$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($task['description']), $trans);
						$desc = str_replace(array("<li>","</li>"), array("",", "), $desc);
						
						$prog = 0;
						$tasksWithProjectId = getTasksWithProjectId($task['pid']);
						$tasksWithProjectIdAndStatus = getTasksWithProjectIdAndStatus($task['pid'], 3);
						$productivitiesWithProjectId = getProductivitiesWithProjectId($task['pid']);

						$tprog = 0;
						$cprog = 0;
						$prod = 0;

						foreach($tasksWithProjectId as $taska):
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

						if ($task['pstatus'] == 0 && strtotime(date('Y-m-d')) >= strtotime($task['start_date'])):
							if ($prod > 0 || $cprog > 0)
								$task['pstatus'] = 2;
							else
								$task['pstatus'] = 1;
						elseif ($task['pstatus'] == 0 && strtotime(date('Y-m-d')) > strtotime($task['end_date'])):
							$task['pstatus'] = 4;
						endif;
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td>
							<p><b><?php echo ucwords($task['pname']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($task['task']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo date("d M, Y",strtotime($task['start_date'])) ?></b></td>
						<td><b><?php echo date("d M, Y",strtotime($task['end_date'])) ?></b></td>
						<td class="text-center">
							<?php
								if($status[$task['pstatus']] =='Pending'){
									echo "<span class='badge badge-p'>{$stat[$task['pstatus']]}</span>";
								}elseif($status[$task['pstatus']] =='Started'){
									echo "<span class='badge badge-s'>{$status[$task['pstatus']]}</span>";
								}elseif($status[$task['pstatus']] =='On-Progress'){
									echo "<span class='badge badge-op'>{$status[$task['pstatus']]}</span>";
								}elseif($status[$task['pstatus']] =='On-Hold'){
									echo "<span class='badge badge-oh'>{$status[$task['pstatus']]}</span>";
								}elseif($status[$task['pstatus']] =='Over Due'){
									echo "<span class='badge badge-od>{$status[$task['pstatus']]}</span>";
								}elseif($status[$task['pstatus']] =='Done'){
									echo "<span class='badge badge-d'>{$status[$task['pstatus']]}</span>";
								}
							?>
						</td>
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
							<button type="button" class="btn btn-action btn-sm btn-rounder wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      	Actions
		                    </button>
			                    <div class="dropdown-menu" style="">
			                      <a class="dropdown-item new_productivity" data-pid = '<?php echo $task['pid'] ?>' data-tid = '<?php echo $task['id'] ?>'  data-task = '<?php echo ucwords($task['task']) ?>' href="javascript:void(0)">Add Productivity</a>
								</div>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	table p {
		margin: unset !important;
	}

	table td {
		vertical-align: middle !important
	}
</style>

<script>
	$(document).ready(function(){
		$('#list').dataTable();

		$('.new_productivity').click(function() {
			uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"/BuyTime/templates/manage_progress.php?pid="+$(this).attr('data-pid')+"&tid="+$(this).attr('data-tid'),'large')
		});
	});

	function delete_project($id){
		start_load();
		$.ajax({
			url:'/BuyTime/helpers/ajax.php?action=delete_project',
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
		});
	}
</script>