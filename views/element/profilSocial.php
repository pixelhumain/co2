

<?php 

	$cssAnsScriptFilesModule = array(
		'/js/news/newsHtml.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/onepage.css',
				'/css/profilSocial.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',
				'/css/circle.css',	
				'/css/default/directory.css',	
				'/js/comments.js',
			  ) , 
		Yii::app()->theme->baseUrl. '/assets');
		$cssAnsScriptFilesTheme = array(
		
"/plugins/jquery-cropbox/jquery.cropbox.css",
"/plugins/jquery-cropbox/jquery.cropbox.js",

	);
	//if ($type == Project::COLLECTION)
	//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	$id = $_GET['id'];
	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';

	
	//récupération du type de l'element
    $typeItem = (@$element["typeSig"] && $element["typeSig"] != "") ? $element["typeSig"] : "";
    if($typeItem == "") $typeItem = @$element["type"] ? $element["type"] : "item";
    if($typeItem == "people") $typeItem = "citoyens";
    
    $typeItemHead = $typeItem;
    if($typeItem == "organizations" && @$element["type"]) $typeItemHead = $element["type"];
    
    if(strpos($typeItem, "place.")!==false){
    	$typeItem = "place";
    }
    
    //icon et couleur de l'element
    $icon = Element::getFaIcon($typeItemHead) ? Element::getFaIcon($typeItemHead) : "";
    $iconColor = Element::getColorIcon($typeItemHead) ? Element::getColorIcon($typeItemHead) : "";

    $useBorderElement = false;

    if(@Yii::app()->params["front"]) $front = Yii::app()->params["front"];
?>
<style>
	


<?php if($typeItem != "citoyens"){ ?>
	.section-create-page{
		display: none;
	}
<?php } ?>

</style>	
    <!-- <section class="col-md-12 col-sm-12 col-xs-12 header" id="header"></section> -->
<div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 no-padding">	
    <!-- Header -->
    <section class="col-md-12 col-sm-12 col-xs-12" id="social-header">
        <div id="topPosKScroll"></div>
    	<?php if(@$edit==true && false) { ?>
    	<button class="btn btn-default btn-sm pull-right margin-right-15 margin-top-70 hidden-xs btn-edit-section" 
    			data-id="#header">
	        <i class="fa fa-cog"></i>
	    </button>
	    <?php } ?>
        

        <?php 
	    	$this->renderPartial('../element/banniere', 
			        			array(	"iconColor"=>$iconColor,
			        					"icon"=>$icon,
			        					"type"=>$type,
			        					"element"=>$element,
			        					"linksBtn"=>$linksBtn,
			        					"elementId"=>(string)$element["_id"],
			        					"elementType"=>$type,
			        					"elementName"=> $element["name"],
			        					"edit" => @$edit,
			        					"openEdition" => @$openEdition) 
			        			); 
		?>

	    <div class="col-md-3 col-sm-3 col-xs-3 no-padding" style="bottom:-31px; position: absolute;">
					<?php if(@$element["profilMediumImageUrl"] && !empty($element["profilMediumImageUrl"]))
							$images=$element["profilMediumImageUrl"];
							else 
								$images="";	
								$this->renderPartial('../pod/fileupload', array(  "itemId" => (string) $element["_id"],
																			  "type" => $type,
																			  "resize" => false,
																			  "contentId" => Document::IMG_PROFIL,
																			  "show" => true,
																			  "editMode" => $edit,
																			  "image" => $images,
																			  "openEdition" => $openEdition) ); 
																			  ?>
								<!--<img class="img-responsive" alt="" 
									 src="<?php echo @$element['profilMediumImageUrl'] ? 
									 		Yii::app()->createUrl('/'.@$element['profilMediumImageUrl']) : $imgDefault; ?>">-->
								
								<?php if(false && @Yii::app()->session["userId"]){ ?>
								<div class="blockUsername">
								    <!--<h2 class="text-left">
									    <?php //echo @$element["name"]; ?><!-- <br>
									    <small>
									    	<?php if(@$element["address"] && @$element["address"]["addressLocality"]) {
					                				echo "<i class='fa fa-university'></i> ".$element["address"]["addressLocality"];
					                				if(@$element["address"]["postalCode"]) echo ", ";
					                			  }
					                			  if(@$element["address"] && @$element["address"]["postalCode"]) 
					                			  	echo $element["address"]["postalCode"];
					                		?>
					                	</small>
				                	</h2>-->
				                	<?php $this->renderPartial('../element/linksMenu', 
				                			array("linksBtn"=>$linksBtn,
				                					"elementId"=>(string)$element["_id"],
				                					"elementType"=>$type,
				                					"elementName"=> $element["name"],
				                					"openEdition" => $openEdition) 
				                			); 
				                	?>
								    <!-- <p><i class="fa fa-briefcase"></i> Web Design and Development.</p> -->
								</div>
								<?php } ?>
		</div>
    </section>
    
    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12 pull-right sub-menu-social no-padding">

    	<div class="btn-group inline">

    	  <?php 
    	  	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
			$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
		                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
		                      : "";
    	  ?>
    	  <div class="identity-min">
	    	  <img class="pull-left" src="<?php echo $thumbAuthor; ?>" height=45>
	    	  <div class="pastille-type-element hidden-xs bg-<?php echo $iconColor; ?> pull-left"></div>
			  <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs pull-left no-padding">
	    	  	<div class="text-left padding-left-15" id="second-name-element">
					<span id="nameHeader">
						<h5 class="elipsis"><?php echo @$element["name"]; ?></h5>
					</span>	
				</div>
	    	  </div>
    	  </div>

    	  <?php if(@Yii::app()->session["userId"] && 
    			 $type==Person::COLLECTION && 
    			 (string)$element["_id"]==Yii::app()->session["userId"]){ 

    			$iconNewsPaper="user-circle"; 
    	  ?>
		  <button type="button" class="btn btn-default bold" id="btn-start-newsstream">
		  		<i class="fa fa-rss"></i> Fil d'actu<span class="hidden-sm">alité</span>s
		  </button>

		  <?php } else {
		  		  $iconNewsPaper="rss"; 
		  		}
		  ?>

		  <button type="button" class="btn btn-default bold" id="btn-start-mystream">
		  		<i class="fa fa-<?php echo $iconNewsPaper ?>"></i> <?php echo Yii::t("common","Newspaper"); ?>
		  </button>

		  <?php if((@Yii::app()->session["userId"] && $isLinked==true) || @Yii::app()->session["userId"] == $element["_id"]){ ?>
		  <button type="button" class="btn btn-default bold" id="btn-start-notifications">
		  	<i class="fa fa-bell"></i> 
		  	<span class="hidden-xs hidden-sm">
		  		Mes notif<span class="hidden-md">ications</span>
		  	</span>
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  </button>
		  <?php } ?>


		  <?php if((@$edit && $edit) || (@$openEdition && $openEdition)){ ?>
		  <button type="button" class="btn btn-default bold letter-green" data-target="#selectCreate" data-toggle="modal">
		  		<i class="fa fa-plus-circle fa-2x"></i> <?php //echo Yii::t("common", "Créer") ?>
		  </button>
		  <?php } ?>
		</div>
		
		<div class="btn-group pull-right">

		  	
			<?php if((@$edit && $edit) || (@$openEdition && $openEdition)){ ?>
			  <button type="button" class="btn btn-default bold">
			  	<i class="fa fa-user-secret"></i> <span class="hidden-xs hidden-sm hidden-md">Admin</span>
			  </button>
			<?php } ?>
			  <?php if($element["_id"] == Yii::app()->session["userId"] && 
			  			Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>
			  <button type="button" class="btn btn-default bold" id="btn-superadmin">
			  	<i class="fa fa-grav letter-red"></i> <span class="hidden-xs hidden-sm hidden-md"></span>
			  </button>
			  <?php } ?>


		</div>


		<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
		<div class="btn-group pull-right">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<button type="button" class="btn btn-default bold">
			  			<i class="fa fa-cogs"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo Yii::t("common", "Settings"); ?></span>
			  		</button>
			  		<ul class="dropdown-menu arrow_box menu-params">			
		  				<li class="text-left">
			               	<a href="javascript:;" id="editConfidentialityBtn" class="bg-white">
			                    <i class="fa fa-cogs"></i> <?php echo Yii::t("common", "Confidentiality params"); ?>
			                </a>
			            </li>
						<li>
							<a href="javascript:;" onclick="showDefinition('qrCodeContainerCl',true)">
								<i class="fa fa-qrcode"></i> <?php echo Yii::t("common","QR Code") ?>
							</a>
						</li>

			  			<?php if($type !=Person::COLLECTION){ ?>
			  				<li class="text-left">
								<a href="javascript:;" id="btn-show-activity">
									<i class="fa fa-history"></i> <?php echo Yii::t("common","History")?> 
								</a>
							</li>
				  			<li class="text-left">
				               	<a href="javascript:;" class="bg-white text-red">
				                    <i class="fa fa-trash"></i> 
				                    <?php echo Yii::t("common", "Delete {what}", 
				                    					array("{what}"=> 
				                    						Yii::t("common","this ".Element::getControlerByCollection($type)))); 
				                    ?>
				                </a>
				            </li>
			            <?php } else { ?>
							<li class="text-left">
								<a href='javascript:' id="downloadProfil">
									<i class='fa fa-download'></i> <?php echo Yii::t("common", "Download your profil") ?>
								</a>
							</li>
							<li class="text-left">
				               	<a href='javascript:;' id="btn-update-password" class='text-red'>
									<i class='fa fa-key'></i> <?php echo Yii::t("common","Change password"); ?>
								</a>
				            </li>
			            <?php } ?>
			            
			  		</ul>
		  		</li>
		  	</ul>
		</div>
		<?php } ?>

	  	<?php if(isset(Yii::app()->session["userId"])){ ?>
			<div class="btn-group pull-right">
			  	<button 	class='btn btn-default bold btn-share pull-right'
	                    	data-ownerlink='share' data-id='<?php echo $element["_id"]; ?>' data-type='<?php echo $typeItem; ?>' 
	                    	data-isShared='false'>
	                    	<i class='fa fa-share'></i> Partager
	          	</button>
	        </div>
	    <?php } ?>

	</div>

	
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 profilSocial" style="margin-top:65px;">  
		
	    <?php 
	    	$params = array(    "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                //"countries" => @$countries,
                                //"controller" => $controller,
                                "openEdition" => $openEdition,
                                //"countStrongLinks" => $countStrongLinks,
                                //"countLowLinks" => @$countLowLinks,
                                //"countInvitations"=> $countInvitations,
                                //"linksBtn"=> @$linksBtn
                                );

	    	/*if(@$members) $params["members"] = $members;
	    	if(@$events) $params["events"] = $events;
	    	if(@$needs) $params["needs"] = $needs;
	    	if(@$projects) $params["projects"] = $projects;*/

	    	$this->renderPartial('../pod/menuLeftElement', $params ); 
	    ?>

		
	</div>
	<?php if(@$invitedMe && !empty($invitedMe)){ ?>
	<div class="col-xs-12 col-md-9 col-sm-9 col-lg-9 divInvited">
		<?php 
			
			$inviteRefuse="Refuse";
			$inviteAccept="Accept";
			$tooltipAccept="Join this ".Element::getControlerByCollection($type);
			if ($type == Project::COLLECTION){ 
				$tooltips = "La communauté du projet";
			}
			else if ($type == Organization::COLLECTION){
				$tooltips = "La communauté de l'organisation";							
			}
			else if ($type == Event::COLLECTION){
				$parentRedirect = "event";
				$inviteRefuse="Not interested";
				$inviteAccept="I go";
				$tooltipAccept="Go to the event";
				$tooltips = "La communauté de l'évènement";						
			}
			else if ($type == Person::COLLECTION){
				$tooltips = "La communauté de cette personne";						
			}
			else if ($type == Place::COLLECTION){
				$tooltips = "La communauté de ce lieu";						
			}


			echo "<a href='#page.type.".Person::COLLECTION.".id.".$invitedMe["invitorId"]."' class='lbh text-purple'>".$invitedMe["invitorName"]."</a><span class='text-dark'> vous a invité : ".
				'<a class="btn btn-xs btn-success tooltips" href="javascript:;" onclick="validateConnection(\''.$type.'\',\''.$id.'\', \''.Yii::app()->session["userId"].'\',\''.Person::COLLECTION.'\',\''.Link::IS_INVITING.'\')" data-placement="bottom" data-original-title="'.Yii::t("common",$tooltipAccept).'">'.
					'<i class="fa fa-check "></i> '.Yii::t("common",$inviteAccept).
				'</a> '.
				' <a class="btn btn-xs btn-danger tooltips" href="javascript:;" onclick="disconnectTo(\''.$type.'\',\''.$id.'\',\''.Yii::app()->session["userId"].'\',\''.Person::COLLECTION.'\',\'attendees\')" data-placement="bottom" data-original-title="'.Yii::t("common","Not interested by the invitation").'">'.
					'<i class="fa fa-remove"></i> '.Yii::t("common",$inviteRefuse).
				'</a>';
			
		?>
	</div>
	<?php } ?>
	<section class="col-xs-12 col-md-9 col-sm-9 col-lg-9 no-padding" style="margin-top: -10px;">
	
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin-top-50" id="central-container">
		</div>

		<?php $this->renderPartial('../pod/qrcode',array(
																"type" => @$type,
																"name" => @$element['name'],
																"address" => @$address,
																"address2" => @$address2,
																"email" => @$element['email'],
																"url" => @$element["url"],
																"tel" => @$tel,
																"img"=>@$element['profilThumbImageUrl']));
																?>
		<div class="col-md-3 col-lg-3 hidden-sm hidden-xs margin-top-50" id="notif-column">
		</div>

	</section>
</div>	
<?php 
$paramsConfidentiality = array( "element" => @$element, 
	"type" => @$type, 
	"edit" => @$edit,
	"controller" => $controller,
	"openEdition" => $openEdition,
);
$this->renderPartial('../pod/confidentiality', $params );

if( $type != Person::COLLECTION)
	$this->renderPartial('../element/addMembersFromMyContacts',array("type"=>$type, "parentId" =>(string)$element['_id'], "members"=>@$members));


?>

<script type="text/javascript">

	//var element = <?php //echo json_encode(Element::getElementForJS(@$element)); ?>;
    //var elementName = "<?php //echo @$element["name"]; ?>";
    //var contextType = "<?php //echo @$type; ?>";
    //var contextId = "<?php //echo @(string)$element['_id'] ?>";
    //var contextData = { "id":contextId, "type":contextType };
    var contextData = <?php echo json_encode(Element::getElementForJS(@$element, @$type)); ?>;

    //var members = <?php echo json_encode(@$members); ?>;
    var params = <?php echo json_encode(@$params); ?>;
    console.log("params", params);

    var dateLimit = 0;
    var typeItem = "<?php echo $typeItem; ?>";
    var liveScopeType = "";
    var subView="<?php echo @$_GET['view']; ?>";
    var hashUrlPage="#page.type."+contextData.type+".id."+contextData.id;
    var cropResult;

    var personCOLLECTION = "<?php echo Person::COLLECTION; ?>";
	

	jQuery(document).ready(function() {
		bindButtonMenu();
		if(subView!=""){
			if(subView=="gallery")
				loadGallery()
			else if(subView=="notifications")
				loadNotifications();
			else if(subView.indexOf("chart") >= 0){
				id=subView.split("chart");
				loadChart(id[1]);
			}
			else if(subView=="mystream")
				loadNewsStream(false);
			else if(subView=="history")
				loadHistoryActivity();
			else if(subView=="directory")
				loadDirectory();
			else if(subView=="editChart")
				loadEditChart();
			else if(subView=="detail")
				loadDetail();
			else if(subView=="urls")
				loadUrls();
			else if(subView=="contacts")
				loadContacts();
		} else
			loadNewsStream(true);

		KScrollTo("#topPosKScroll");
		initDateHeaderPage(contextData);

		
		
		//Sig.showMapElements(Sig.map, mapElements);
	});

	function initDateHeaderPage(params){
		var str = directory.getDateFormated(params);
		$(".section-date").html(str);
	}

	function getCroppingModal(){
		
	}

	function bindButtonMenu(){
		$("#btn-superadmin").click(function(){
			loadAdminDashboard();
		});
		$("#btn-start-newsstream").click(function(){
			history.pushState(null, "New Title", hashUrlPage);
			loadNewsStream(true);
		});
		$("#btn-start-mystream").click(function(){
			if(contextData.type=="citoyens" && userId==contextData.id)
				history.pushState(null, "New Title", hashUrlPage+".view.mystream");
			else
				history.pushState(null, "New Title", hashUrlPage);
			loadNewsStream(false);
		});
		$("#btn-start-gallery").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.gallery");
			//location.search="?view=gallery";
			loadGallery();
		});
		$("#btn-start-notifications").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.notifications");
			//location.search="?view=notifications";
			loadNotifications();
		});
		$(".btn-start-chart").click(function(){
			id=$(this).data("value");
			history.pushState(null, "New Title", hashUrlPage+".view.chart"+id);
			//location.search="?view=chart&id="+id;
			loadChart(id);
		});
		$("#btn-show-activity").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.history");
			loadHistoryActivity();
		});
		
		$(".open-confidentiality").click(function(){
			mylog.log("open-confidentiality");
			toogleNotif(false);
			smallMenu.open( dataHelper.markdownToHtml($("#descriptionMarkdown").val()));
			bindLBHLinks();
		});
	
		$(".open-directory").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.directory");
			loadDirectory();
		});
		$(".edit-chart").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.editChart");
			loadEditChart();
		});
		$(".btn-open-collection").click(function(){
			toogleNotif(false);
		});

		$("#btn-start-detail").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.detail");
			loadDetail();
		});

		$(".load-data-directory").click(function(){
   			var dataName = $(this).data("type-dir");
   			console.log(".load-data-directory", dataName);
   			loadDataDirectory(dataName, $(this).data("icon"));
   		});
   		
   		$("#subsubMenuLeft a").click(function(){
   			$("#subsubMenuLeft a").removeClass("active");
   			$(this).addClass("active");
   		});

   		$("#btn-start-urls").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.urls");
			loadUrls();
		});

   		$("#btn-start-contacts").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.contacts");
			loadContacts();
		});

		$(".btn-share").click(function(){

		      formData = new Object();
		      formData.parentId = $(this).attr("data-id");
		      formData.childId = userId;
		      formData.childType = personCOLLECTION;
		      formData.connectType =  "share";
		      var type = $(this).attr("data-type");
		      var name = $(this).attr("data-name");
		      var id = $(this).attr("data-id");
		      //traduction du type pour le floopDrawer
		      var typeOrigine = typeObjLib.get(type).col;
		      if(typeOrigine == "persons"){ typeOrigine = personCOLLECTION;}
		      formData.parentType = typeOrigine;
		      if(type == "person") type = "people";
		      else type = typeObjLib.get(type).col;

		      $.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/link/share",
		        data : formData,
		        dataType: "json",
		        success: function(data){
		          if ( data && data.result ) {
		            $(thiselement).html("<i class='fa fa-chain'></i>");
		            $(thiselement).attr("data-ownerlink","follow");
		            $(thiselement).attr("data-original-title", (type == "events") ? "Participer" : "Suivre");
		            removeFloopEntity(data.parentId, type);
		            toastr.success(trad["You are not following"]+data.parentEntity.name);
		          } else {
		             toastr.error("You leave succesfully");
		          }
		        }
		      });
		    });

	}
	
	function loadDataDirectory(dataName, dataIcon){
		showLoader('#central-container');
		// $('#central-container').html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");return;
		getAjax('', baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
					'/id/'+contextData.id+'/dataName/'+dataName+'?tpl=json',
					function(data){ 
						displayInTheContainer(data, dataName, dataIcon);
					}
		,"html");
	}

	function getLabelTitleDir(dataName, dataIcon, countData, n){
		mylog.log("bgetLabelTitleDir", dataName, dataIcon, countData, n)
		var elementName = "<span class='Montserrat' id='name-lbl-title'>"+$("#nameHeader .name-header").html()+"</span>";
		
		var s = (n>1) ? "s" : "";
		var html = "<i class='fa fa-"+dataIcon+" fa-2x margin-right-10'></i> <i class='fa fa-angle-down'></i> ";
		if(dataName == "follows")	{ html += elementName + " est <b>abonné</b> à " + countData + " page"+s+""; }
		else if(dataName == "followers")	{ html += countData + " <b>abonné"+s+"</b> à " + elementName; }
		else if(dataName == "members")	{ html += elementName + " est composé de " + countData + " <b>membre"+s+"</b>"; }
		else if(dataName == "attendees")	{ html += countData + " <b>invité"+s+"</b> à l'événement " + elementName; }
		else if(dataName == "contributors")	{ html += countData + " <b>contributeur"+s+"</b> au projet " + elementName; }
		
		else if(dataName == "events"){ 
			if(type == "events"){
				html += elementName + " est composé de " + countData+" <b> sous-événement"+s; 
			}else{
				html += elementName + " participe à " + countData+" <b> événement"+s; 
			}
		}
		else if(dataName == "organizations")	{ html += elementName + " est membre de " + countData+" <b>organisation"+s; }
		else if(dataName == "projects")		{ html += elementName + " contribue à " + countData+" <b>projet"+s }

		else if(dataName == "collections"){ html += countData+" <b>collection"+s+"</b> de " + elementName; }
		else if(dataName == "poi"){ html += countData+" <b>point"+s+" d'intérêt"+s+"</b> créé"+s+" par " + elementName; }
		else if(dataName == "classified"){ html += countData+" <b>annonce"+s+"</b> créée"+s+" par " + elementName; }

		else if(dataName == "needs"){ html += countData+" <b>besoin"+s+"</b> de " + elementName; }

		else if(dataName == "dda"){ html += countData+" <b>proposition"+s+"</b> de " + elementName; }

		else if(dataName == "urls"){ 
			html += elementName + " a " + countData+" <b> lien"+s;
			html += '<a class="tooltips btn btn-xs btn-success pull-right " data-placement="top" data-toggle="tooltip" data-original-title="'+trad["Add Link"]+'" href="javascript:;" onclick="elementLib.openForm ( \'url\',\'parentUrl\')">';
	    	html +=	'<i class="fa fa-plus"></i> '+trad["Add Link"]+'</a>' ;  
		}

		else if(dataName == "contacts"){ 
			html += elementName + " a " + countData+" <b> point de contact"+s;
			html += '<a class="tooltips btn btn-xs btn-success pull-right " data-placement="top" data-toggle="tooltip" data-original-title="'+trad["Add Link"]+'" href="javascript:;" onclick="elementLib.openForm ( \'contactPoint\',\'contact\')">';
	    	html +=	'<i class="fa fa-plus"></i> '+trad["Add Link"]+'</a>' ;  
		}

		return html;
	}

	function loadAdminDashboard(){
		showLoader('#central-container');
		getAjax('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/main",function(){ 
				
		},"html");
	}

	function loadNewsStream(isLiveBool){
		isLive = isLiveBool==true ? "/isLive/true" : ""; 
		dateLimit = 0;
		scrollEnd = false;

		toogleNotif(true);

		var url = "news/index/type/"+typeItem+"/id/"+contextData.id+isLive+"/date/"+dateLimit+
				  "?isFirst=1&tpl=co2&renderPartial=true";
		
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){ 
				loadLiveNow();
	            $(window).bind("scroll",function(){ 
				    if(!loadingData && !scrollEnd && colNotifOpen){
				          var heightWindow = $("html").height() - $("body").height();
				          if( $(this).scrollTop() >= heightWindow - 400){
				            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep, isLiveBool);
				          }
				    }
				});
		},"html");
	}
	function loadGallery(){
		toogleNotif(false);
		var url = "gallery/index/type/"+typeItem+"/id/"+contextData.id;
		
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadChart(id){
		toogleNotif(false);
		var url = "chart/index/type/"+typeItem+"/id/"+contextData.id+"/chart/"+id;
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadNotifications(){
		toogleNotif(false);
		var url = "element/notifications/type/"+typeItem+"/id/"+contextData.id;
		
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadHistoryActivity(){
		toogleNotif(false);
		var url = "pod/activitylist/type/"+typeItem+"/id/"+contextData.id;
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadDirectory(){
		toogleNotif(false);
		smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/directory/type/'+contextData.type+'/id/'+contextData.id+
								'?tpl=json','Communauté','fa-connectdevelop','dark');
		bindLBHLinks();
	}
	function loadEditChart(){
		toogleNotif(false);
		var url = "chart/addchartsv/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
		function(){},"html");
	}

	function loadDetail(){
		toogleNotif(false);
		var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}

	function loadInvite(){
		toogleNotif(false);
		var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}

	/*function loadUrls(){
		toogleNotif(false);
		smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/geturls/type/'+contextData.type+'/id/'+contextData.id+'?tpl=json','Urls','fa-external-link','dark');
		bindLBHLinks();
	}*/

	function loadUrls(){
		showLoader('#central-container');
		// $('#central-container').html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");return;
		getAjax('', baseUrl+'/'+moduleId+'/element/geturls/type/'+contextData.type+
					'/id/'+contextData.id,
					function(data){ 
						displayInTheContainer(data, "urls", "external-link", "urls");
					}
		,"html");
	}

	function loadContacts(){
		showLoader('#central-container');
		// $('#central-container').html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");return;
		getAjax('', baseUrl+'/'+moduleId+'/element/getcontacts/type/'+contextData.type+
					'/id/'+contextData.id,
					function(data){ 
						displayInTheContainer(data, "contacts", "envelope", "contacts");
					}
		,"html");
	}

	function displayInTheContainer(data, dataName, dataIcon, contextType){ 
		mylog.log("displayInTheContainer",data, dataName, dataIcon, contextType)
		var n=0;
		$.each(data, function(key, val){ if(typeof key != "undefined") n++; });
		if(n>0){

			var html = "<div class='col-md-12 margin-bottom-15 labelTitleDir'>"+
							getLabelTitleDir(dataName, dataIcon, parseInt(n), n)+
						"<hr></div>";

			if(dataName != "collections"){
				html += directory.showResultsDirectoryHtml(data, contextType);
			}else{
				$.each(data, function(col, val){
					html += "<h4 class='col-md-12'><i class='fa fa-star'></i> "+col+"<hr></h4>";
					$.each(val.list, function(key, elements){ 
						html += directory.showResultsDirectoryHtml(elements, key);
					});
				});
			}
			toogleNotif(false);
			$("#central-container").html(html);
			initBtnLink();
		}else{
			var nothing = "Aucun";
			if(dataName == "organizations" || dataName == "collections" || dataName == "follows")
				nothing = "Aucune";

			var html =  "<div class='col-md-12 margin-bottom-15'>"+
							getLabelTitleDir(dataName, dataIcon, nothing, n)+
						"</div>";
			$("#central-container").html(html + "<span class='col-md-12 alert bold bg-white'>"+
													"<i class='fa fa-ban'></i> Aucune donnée"+
												"</span>");
			toogleNotif(false);
		}
	}
	
	function loadStream(indexMin, indexMax, isLiveBool){ console.log("LOAD STREAM PROFILSOCIAL"); //loadLiveNow
		loadingData = true;
		currentIndexMin = indexMin;
		currentIndexMax = indexMax;
		

		if(typeof dateLimit == "undefined") dateLimit = 0;

		isLive = isLiveBool==true ? "/isLive/true" : "";
		var url = "news/index/type/"+typeItem+"/id/"+contextData.id+isLive+"/date/"+dateLimit+"?tpl=co2&renderPartial=true";
		$.ajax({ 
	        type: "POST",
	        url: baseUrl+"/"+moduleId+'/'+url,
	        data: { indexMin: indexMin, 
	        		indexMax:indexMax, 
	        		renderPartial:true 
	        	},
	        success:
	            function(data) {
	                if(data){ //alert(data);
	                	$("#news-list").append(data);
	                	//bindTags();
						
					}
					loadingData = false;
					$(".stream-processing").hide();
	            },
	        error:function(xhr, status, error){
	            loadingData = false;
	            $("#news-list").html("erreur");
	        },
	        statusCode:{
	                404: function(){
	                	loadingData = false;
	                    $("#news-list").html("not found");
	            }
	        }
	    });
	}

	var colNotifOpen = true;
	function toogleNotif(open){
		if(typeof open == "undefined") open = false;
		
		if(open==false){
			$('#notif-column').removeClass("col-md-3 col-sm-3 col-lg-3").addClass("hidden");
			$('#central-container').removeClass("col-md-9 col-lg-9").addClass("col-md-12 col-lg-12");
		}else{
			$('#notif-column').addClass("col-md-3 col-sm-3 col-lg-3").removeClass("hidden");
			$('#central-container').addClass("col-sm-12 col-md-9 col-lg-9").removeClass("col-md-12 col-lg-12");
		}

		colNotifOpen = open;
	}



function loadLiveNow () {
	mylog.log("loadLiveNow");
	var dep = ( ( notNull(contextData["address"])  && notNull(contextData["address"]["depName"]) ) ? contextData["address"]["depName"] : "");

	/*typeof element != "undefined" ? 
			  typeof element["address"] != "undefined" ? 
			  typeof element["address"]["depName"] != "undefined" ? 
			  element["address"]["depName"] : "" : "" : "";*/

    var searchParams = {
      //"name":$('.input-global-search').val(),
      "tpl":"/pod/nowList",
      //"latest" : true,
      //"searchType" : [typeObj["event"]["col"],typeObj["project"]["col"],
      //					typeObj["organization"]["col"],"classified",
      //				 /*typeObj["organization"]["col"]*//*,typeObj["action"]["col"]*/], 
      //"searchTag" : $('#searchTags').val().split(','), //is an array
      //"searchLocalityCITYKEY" : $('#searchLocalityCITYKEY').val().split(','),
      //"searchLocalityCODE_POSTAL" : $('#searchLocalityCODE_POSTAL').val().split(','), 
      "searchLocalityDEPARTEMENT" : new Array(dep), //$('#searchLocalityDEPARTEMENT').val().split(','),
      //"searchLocalityREGION" : $('#searchLocalityREGION').val().split(','),
      "indexMin" : 0, 
      "indexMax" : 30 
    };

    ajaxPost( "#notif-column", baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
					'/id/'+contextData.id+'/dataName/liveNow?tpl=nowList',
					searchParams, function() { 
			        bindLBHLinks();
			        /*if($('.el-nowList').length==0)
			        	$('.titleNowEvents').addClass("hidden");
			        else
			        	$('.titleNowEvents').removeClass("hidden");*/
     } , "html" );
}


function showLoader(id){
	$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
}

</script>


<?php //$this->renderPartial('sectionEditTools');?>
