<?php
	/***************************************************************
	* tools page file, included by start if selected (also ?p=30). *
	* dependencies: msgs as $_msg (config);                        *
	*               session as $_session (login);                  *
	*               pgsql as $_pgobj (config).                     *
	****************************************************************/

	// ----- Checking Dependecies ----- //
	if(!isset($_msg)) die("Error: Messages Class not Initialized!");
	if(!isset($_session)) $_msg->error("Class Session not set!");
	if(!isset($_pgobj)) $_msg->error("Class PgSQL not set!");
?>
						<div class="x_panel">
							<div class="x_title">
								<h2><?= $_msg->lang("Tools") ." &raquo; ". $_msg->lang("Home"); ?></h2>
								<div class="col-md-2 col-sm-2 col-ms-2 col-xs-2 pull-right">
									<i class="fa fa-refresh fa-spin fa-fw" style="visibility: hidden;"></i>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="col-lg-4 col-md-6 col-sm-6 col-ms-9 col-xs-12 text-center">
									<button type="button" class="btn btn-default" onclick="tools_ontAutofind();"><?= $_msg->lang("ONT Autofind"); ?></button>
									<table id="onts" class="table">
										<thead>
											<tr>
												<th style="text-align: center;"><?= $_msg->lang("ONT"); ?></th>
												<th style="text-align: center;"><?= $_msg->lang("Port"); ?></th>
												<th style="text-align: center;"><?= $_msg->lang("Serial Number"); ?></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div><div class="col-lg-4 col-md-6 col-sm-6 col-ms-9 col-xs-12 text-center">
									<h4><?= $_msg->lang("Customer Select"); ?></h4>
									<select id="customer" data-live-search="true" class="selectpicker" onchange="tools_ontCustomerSelect(this.value);" multiple data-max-options=1 disabled>
<?php // List Customers
	$_pgobj->query('SELECT id, substring(data from \':"name";s:[0-9]+:"([^"]+)";\') AS name, username FROM at_userdata ORDER BY name');
	for($i=0; $i<$_pgobj->rows; $i++) {
		echo str_repeat("\t", 10) .'<option value="'. $_pgobj->result[$i]['id'] .':';
		echo substr($_pgobj->result[$i]['username'], 0, strpos($_pgobj->result[$i]['username'], '@'));
		echo '">'. $_pgobj->result[$i]['name'] ."</option>\n";
	}
?>
									</select>
								</div><div class="col-lg-4 col-md-6 col-sm-6 col-ms-9 col-xs-12 text-center">
									<h4><?= $_msg->lang("ONT Activate"); ?></h4>
									<input id="customer_description" type="hidden" />
									<input id="customer_id" type="hidden" />
									<input id="ont_port" type="hidden" />
									<input id="ont_sn" type="hidden" />
									<button id="activate_pppoe" type="button" class="btn btn-primary" onclick="tools_ontActivate('PPPoE');" disabled><?= $_msg->lang("ONT Activate PPPoE"); ?></button>
									<button id="activate_bridge" type="button" class="btn btn-primary" onclick="tools_ontActivate('Bridge');" disabled><?= $_msg->lang("ONT Activate Bridge"); ?></button>
								</div><div class="col-lg-4 col-md-6 col-sm-6 col-ms-9 col-xs-12 text-center" style="display: none;">
									<h4><?= $_msg->lang("Result"); ?></h4>
									<div id="result"></div>
								</div>
								<script src="<?= $_path->js; ?>/bootstrap-select.min.js"></script>
								<script type="text/javascript" >
									$(function () {
									// Prepare document loading animation
										$(document).ajaxStart(function (){ $('.fa-spin').css("visibility", 'visible');})
														.ajaxStop(function (){ $('.fa-spin').css("visibility", 'hidden'); });
										$(".selectpicker").selectpicker({ noneSelectedText: '<?= $_msg->lang("Nothing Selected"); ?>' });
									});
								</script>
							</div>
						</div>