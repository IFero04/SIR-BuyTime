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

		<div class="card-body table-responsive">
			<table class="table table-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="35%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Favorite</th>
						<th>Project</th>
						<th>Date Started</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Category</th>
						<th>Priority</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					@require_once __DIR__ . '/../../../helpers/project.php';
					@require_once __DIR__ . '/../../../helpers/task.php';
					@require_once __DIR__ . '/../../../helpers/productivity.php';
					@require_once __DIR__ . '/../../../helpers/favProjects.php';

					$i = 1;
					$status = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
					$categories = array("Undetermined", "Professional", "Academic", "Personal", "Health", "Technology", "Art", "Community", "Business", "General");
					$priorities = array("Undetermined", "Not Important", "Normal", "Important");

					if (administrator()) {
						$projects = getProjects();
					} else {
						$userProjects = getUserProjects($user['id']);
						$userAddedProjects = getUserAddedProjects($user['id']);
						$projects = array_merge($userProjects, $userAddedProjects);
					}

					foreach ($projects as $project):
						$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
						unset($trans['\"'], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($project['description']), $trans);
						$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

						$prog = 0;
						$tasksWithProjectId = getTasksWithProjectId($project['id']);
						$tasksWithProjectIdAndStatus = getTasksWithProjectIdAndStatus($project['id'], 3);
						$productivitiesWithProjectId = getProductivitiesWithProjectId($project['id']);
						$isProjectFavorited = getFavoritedProjectsWithUserId($user['id'], $project['id']);

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
					?>
					<tr>
						<td class="text-center"><b><?php echo $i++ ?></b></td>
						<td class="text-center">
							<?php if ($isProjectFavorited): ?>
							<button class="btn btn-action btn-sm btn-rounded wave-effect" onclick="favorite_project(<?php echo $project['id']; ?>, false, <?php echo $user['id']; ?>)">
								<i class="fa fa-heart"></i> Remove
							</button>
							<?php else: ?>
							<button class="btn btn-action btn-sm btn-rounded wave-effect" onclick="favorite_project(<?php echo $project['id']; ?>, true, <?php echo $user['id']; ?>)">
								<i class="fa fa-heart"></i> Add
							</button>
							<?php endif; ?>
						</td>
						<td>
							<p><b><?php echo ucwords($project['title']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc); ?></p>
						</td>
						<td><p><?php echo date('d M, Y', strtotime($project['start_date'])) ?></p></td>
						<td><p><?php echo date('d M, Y', strtotime($project['end_date'])) ?></p></td>
						<td>
							<?php
							if ($status[$project['status']] == 'Pending') {
								echo "<span class='badge badge-p'>{$status[$project['status']]}</span>";
							} elseif ($status[$project['status']] == 'Started') {
								echo "<span class='badge badge-s'>{$status[$project['status']]}</span>";
							} elseif ($status[$project['status']] == 'On-Progress') {
								echo "<span class='badge badge-op'>{$status[$project['status']]}</span>";
							} elseif ($status[$project['status']] == 'On-Hold') {
								echo "<span class='badge badge-oh'>{$status[$project['status']]}</span>";
							} elseif ($status[$project['status']] == 'Over Due') {
								echo "<span class='badge badge-od'>{$status[$project['status']]}</span>";
							} elseif ($status[$project['status']] == 'Done') {
								echo "<span class='badge badge-d'>{$status[$project['status']]}</span>";
							}
							?>
						</td>
						<td>
							<?php
								echo "<span class='badge badge-bt'>{$categories[$project['category']]}</span>";
							?>
						</td>
						<td>
							<?php
								if ($priorities[$project['priority']] == 'Undetermined') {
									echo "<span class='badge badge-p'>{$priorities[$project['priority']]}</span>";
								} elseif ($priorities[$project['priority']] == 'Not Important') {
									echo "<span class='badge badge-oh'>{$priorities[$project['priority']]}</span>";
								} elseif ($priorities[$project['priority']] == 'Normal') {
									echo "<span class='badge badge-d'>{$priorities[$project['priority']]}</span>";
								} elseif ($priorities[$project['priority']] == 'Important') {
									echo "<span class='badge badge-od'>{$priorities[$project['priority']]}</span>";
								}
							?>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-action btn-sm btn-rounded wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								Actions
							</button>
							<div class="dropdown-menu">
								<a href="./index.php?page=view_project&id=<?php echo $project['id']; ?>" data-id="<?php echo $project['id'] ?>" class="dropdown-item view_project">View</a>
								<?php if ($project['manager_id'] == $user['id'] || administrator()): ?>
								<div class="dropdown-divider"></div>
								<a href="./index.php?page=edit_project&id=<?php echo $project['id']; ?>" class="dropdown-item">Edit</a>
								<div class="dropdown-divider"></div>
								<a href="javascript:void(0)" data-id="<?php echo $project['id']; ?>" class="dropdown-item delete_project">Delete</a>
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

<style>
	table p {
		margin: unset !important;
	}

	table td {
		vertical-align: middle !important;
	}
</style>

<script>	
	var tabela;

	$(document).ready(function(){
		tabela = $('#list').dataTable({
			order: [[1, 'desc'], [0, 'asc']]
		});
	
		$('.delete_project').click(function(){
			_conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
		});
	});

	function favorite_project($id, $favorito, $user_id) {
		$.ajax({
			url: '/BuyTime/helpers/ajax.php?action=favorite_project',
			method: 'POST',
			data: { id: $id, favorito: $favorito, user_id: $user_id },
			success: response => {
				//console.log(tabela.api().ajax);
				location.reload();
			},
			error: error => {
				console.error('Error: ', error);
			}
		});
	}

	function delete_project($id){
		start_load()
		$.ajax({
			url: '/BuyTime/helpers/ajax.php?action=delete_project',
			method: 'POST',
			data: {id:$id},
			success: response => {
				if (response == 1) {
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