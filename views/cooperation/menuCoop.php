<?php 
	
	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/Chart.min.js"
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>

<style>

	body.modal-open{
		overflow: hidden !important;
	}
	/* MODAL */
	#modalCoop.modal,	
	#modalCoop.modal .modal-dialog,
	#modalCoop.modal .modal-content{
		position: fixed;
		top: 0px;
		bottom: 0px;
		left: 0px;
		right: 0px;
		width:100%;
		margin:0px;
		padding:0px;
	}

	#modalCoop.modal .modal-header{
		padding: 0px;
	}
	#modalCoop.modal .modal-content{
		border-radius:0px;
		padding-top: 0px !important;
		border:0px !important;
		
	}

	#modalCoop.modal .modal-body{
		position: fixed;
	    top: 55px;
	    bottom: 0px;
	    left: 0px;
	    right: 0px;
	}

	ul#menuCoop{
		overflow-y: auto;
		position: absolute;
		top: 0px;
		bottom: 0px;
		left: 0px;
		right: 0px;
		margin: 0px;
		padding: 0px;
	}

	#modalCoop.modal #main-coop-container{
		position: absolute;
		right: 0px;
		top: 0px;
		bottom: 0px;
	}

	#coop-container{
		position: absolute;
		top: 2px;
		bottom: 0px;
		right: 0px;
		left: 0px;
	}

	#modalCoop.modal #menu-room{
		position: absolute;
		top: 0px;
		bottom: 0px;
		left: 0px;
		padding: 10px 20px 10px 10px;
		overflow-y: auto;
	}

	#modalCoop.modal #coop-data-container{
		overflow-y: auto;
		position: absolute;
		top: 0px;
		bottom: 0px;
		right: 0px;
		margin: 0px;
		padding: 10px 20px 10px 10px;
		left: unset;
	}


	/* MODAL */

	ul.menuCoop {
	    list-style-type: none;
	    /*position: absolute;*/
	    /*top:0px;*/
	}

	.menuCoop hr{
	    margin-top: 7px;
    	margin-bottom: 7px;	
    	border-top: 2px solid #ededed;
	}

	.menuCoop .title-section{
		text-decoration: none !important;
		color:#FFF;
		background-color:#229296;
		font-size: 17px;
		padding: 6px;
		padding-left: 10px;
		display: block;
		text-align: left;
		font-weight: bold;
		border: 0px solid #e4e4e4;
		margin-top: 10px;
		margin-bottom: 10px;
		/*border-radius: 50px;*/
	}

	.menuCoop a.title-section.open{
		/*border-color: #a2c8ae;*/
	}

	.menuCoop a.title-section .fa-caret-down,
	.menuCoop a.title-section .fa-caret-right{
		margin-top:3px;
		width:20px;
	}

	/*.menuCoop a.title-section:hover {
	    color: #0095FF;
	    background-color: #edecec;
	    border: 2px solid #0095FF;
	}*/

	.menuCoop a{
		text-decoration: none !important;
		color:#3C545D;
		font-size: 13px;
		padding: 7px;
		padding-left: 20px;
		display: block;
		text-align: left;
		font-weight: bold;
		border-left: 3px solid transparent;
	}


	.menuCoop a.load-coop-data:hover{
		color:#0095FF;
		background-color: #edecec;
		border-left: 3px solid #0095FF;
	}
	
	.menuCoop a.letter-green:hover{
		border-left: 3px solid #34a853;
	}

	.menuCoop a.load-coop-data:active,
	.menuCoop a.load-coop-data.active{
		background-color: #C8EBF5;
		border-left: 3px solid #0095FF;
		/*color:#0095FF;*/
	}
	
	.menuCoop i.fa{
		/*width: 25px;*/
		text-align: center;
	}


	.menuCoop a{
		padding-left:4px; 
	}
	
	
	.menuCoop a.load-coop-data{
		font-size:13px;
		padding-left: 14px;
	}

	.menuCoop .sub-rooms a.load-coop-data{
		font-size:14px;
	}


	#menuCoop a.letter-green,
	#menuCoop a.text-dark{
		padding-left:15px; 
	}

	#div-reopen-menu-left-container{
		margin-top: 35px;
		padding-top: 10px;
	}

	#comments-container .footer-comments{
		background-color: white !important;
	}

	#coop-container h1, 
	#coop-container h2,
	#coop-container h3,
	#coop-container h4, 
	#coop-container h5, 
	#coop-container h6 {
	    text-transform: none !important;
	    letter-spacing: -1px;
	    font-weight: 200 !important;
	}

	#coop-container h6, 
	#coop-container h5 {
	    letter-spacing: 0px;
	}

	#coop-container .menuCoop .title-section{
		background-color: #d7eeef;
		color:#353535;
	}


	.submenucoop.sub-proposals{
		padding: 0px 10px 0 0 !important;
	}

</style>

	<?php 
		$menuCoopData = Cooperation::getCoopData($type, (string)$element["_id"], "room");
		$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $type, (string)$element["_id"]);
	?>
		<li class="padding-10 submenucoop sub-rooms">
			<h5 class="padding-left-10">
				<i class="fa fa-angle-down"></i> <i class="fa fa-connectdevelop"></i> Espace coopératif
				
			  	
			</h5>
			
		</li>

	<li class="submenucoop sub-rooms"><hr></li>
	
	<div id="coop-room-list" class="margin-bottom-50">
		<?php $this->renderPartial('../cooperation/roomList', array("roomList"=>$menuCoopData["roomList"], "auth"=>$auth)); ?>
	</div>

	<?php if(!@$menuCoopData["roomList"]) return; ?>

	
	<!----------------- PROPOSALS ------------ -->
	<li>
		<a href="javascript:" class="title-section elipsis open" data-key="proposals">
	  		<i class="fa fa-caret-right"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Proposals") ?>
	  	</a>
	</li>

	<li class="submenucoop hidden sub-proposals"><hr></li>
	
	<?php foreach(array("mine" => "My proposals", 
						"amendable"=>"Amendable", 
						"tovote"=>"To vote",
						"closed" => "Closed", 
						"archived"=> "Archived") as $status=>$tradStatus){ ?>

		<li class="submenucoop sub-proposals">
			<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="<?php echo $status ?>">
		  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> <?php echo Yii::t("cooperation", $tradStatus) ?>
		  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?>">
		  			<?php echo @$menuCoopData["allCount"]["proposals"][$status]; ?>
		  		</span>
		  	</a>
		</li>
	<?php } ?>

	
	
	<!-- ------------ ACTIONS -------------- -->
	<li>
		<a href="javascript:" class="title-section elipsis open" data-key="actions">
	  		<i class="fa fa-caret-right"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Actions") ?>
	  	</a>
	</li>

		<li class="submenucoop hidden sub-actions"><hr></li>

		<?php foreach(array("mine" => "My actions", "todo"=>"To do", 
							"done" => "Done", "archived"=> "Archived") as $status=>$tradStatus){ ?>

			<li class="submenucoop sub-actions">
				<a href="javascript:" class="load-coop-data" data-type="action" data-status="<?php echo $status ?>">
			  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> <?php echo Yii::t("cooperation", $tradStatus) ?>
			  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?>">
			  			<?php echo @$menuCoopData["allCount"]["actions"][$status]; ?>
			  		</span>
			  	</a>
			</li>
		<?php } ?>

	
	
	<!-- ----------- RESOLUTION --------------- -->
	<li class="hidden">
		<a href="javascript:" class="title-section" data-key="resolutions">
	  		<!-- <i class="fa fa-caret-right"></i>   -->
	  		<i class="fa fa-inbox margin-left-25"></i> <?php echo Yii::t("cooperation", "Resolutions") ?>
	  	</a>
	</li>



<!-- ************ MODAL ********************** -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modalHelpCOOP">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <!-- <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <div class="modal-title" id="modalText">
		        	<h4><i class="fa fa-info-circle"></i> Aide</h4>
		        </div>
		      </div>
		       -->
		       <div class="modal-body padding-25">
				<?php $this->renderPartial('../cooperation/pod/home', array("type"=>$type)); ?>
		      </div>
		      <div class="modal-footer">
		      	<div id="modalAction" style="display:inline"></div>
		        <button class="btn btn-default pull-right btn-sm margin-top-10 margin-right-10" data-dismiss="modal"> J'ai compris</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->