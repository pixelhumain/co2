<?php
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/jquery.dataTables.min.1.10.4.js');
//echo CHtml::cssFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/css/DT_bootstrap.css');
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/DT_bootstrap.js');
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
$this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath , 
                            "page" => "admin") ); 
?>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	<div class="panel-heading border-light">
		<h4 class="panel-title"><i class="fa fa-globe fa-2x text-green"></i> <a href="javascript:;" onclick="applyStateFilter('organization|NGO|Group|LocalBusiness')" class="filter<?php echo Organization::COLLECTION ?> btn btn-xs btn-default"> Organizations <span class="badge badge-warning"> <?php echo count(@$organizations) ?></span></a> 
																				<a href="javascript:;" onclick="applyStateFilter('person')" class="filter<?php echo Person::COLLECTION ?> btn btn-xs btn-default"> People <span class="badge badge-warning"> <?php echo count(@$results["countPeople"]) ?></span></a>  
																				<a href="javascript:;" onclick="applyStateFilter('event|concert|meeting|dance')" class="filter<?php echo Event::COLLECTION ?> btn btn-xs btn-default"> Events <span class="badge badge-warning"> <?php echo count(@$events) ?></span></a> 
																				<a href="javascript:;" onclick="applyStateFilter('project')" class="filter<?php echo Project::COLLECTION ?> btn btn-xs btn-default"> Projects <span class="badge badge-warning"> <?php echo count(@$projects) ?></span></a>
																				<a href="javascript:;" onclick="clearAllFilters('')" class="btn btn-xs btn-default"> All</a></h4>
	</div>
	<div class="panel-tools padding-20">
		<?php if( Yii::app()->session["userId"] ) { ?>
		<a href="javascript:;" onclick="dyFObj.openForm('organization')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Organization"><i class="fa fa-plus"></i> <i class="fa fa-group"></i> </a>

		<a href="javascript:;" onclick="dyFObj.openForm('event')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Event"><i class="fa fa-plus"></i> <i class="fa fa-calendar"></i></a>

		<a href="javascript:;" onclick="dyFObj.openForm('person')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Invite Someone "><i class="fa fa-plus"></i> <i class="fa fa-user"></i></a>
		<?php } ?>
	</div>

	 <div id="" class="col-sm-3 col-md-4 col-lg-4">
                <input type="text" class="form-control" id="input-search-table" 
                        placeholder="<?php echo Yii::t("common", "search by name") ?>">
    </div>
            <button class="btn btn-default hidden-xs pull-left menu-btn-start-search-admin btn-directory-type">
                    <i class="fa fa-search"></i>
            </button>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
	<div class="panel-body">
		<div>	
			<?php //var_dump($projects) ?>
			<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>Type</th>
						<th>Name</th>
						<?php //if( Yii::app()->session[ "userIsAdmin"] && Yii::app()->controller->id == "admin" ){?>
						<th>Email</th>
						<?php //} ?>
						<th>Tags</th>
						<th>Scope</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
					<?php 
					$memberId = Yii::app()->session["userId"];
					$memberType = Person::COLLECTION;
					$tags = array();
					$scopes = array(
						"codeInsee"=>array(),
						"codePostal"=>array(),
						"region"=>array(),
					);
					
					/* ************ ORGANIZATIONS ********************** */
					/*if(isset($organizations)) 
					{ 
						foreach ($organizations as $e) 
						{ 
							buildDirectoryLine($e, Organization::COLLECTION, Organization::CONTROLLER, Organization::ICON, $this->module->id,$tags,$scopes);
						};
					}

					/* ********** PEOPLE ****************** 
					if(isset($people)) 
					{ 
						foreach ($people as $e) 
						{ 
							buildDirectoryLine($e, Person::COLLECTION, Person::CONTROLLER, Person::ICON, $this->module->id,$tags,$scopes);
						}
					}

					/* ************ EVENTS ************************ 
					if(isset($events)) 
					{ 
						foreach ($events as $e) 
						{ 
							buildDirectoryLine($e, Event::COLLECTION, Event::CONTROLLER, Event::ICON, $this->module->id,$tags,$scopes);
						}
					}
	
					/* ************ PROJECTS **************** 
					if( count($projects) ) 
					{ 
						foreach ($projects as $e) 
						{ 
							buildDirectoryLine($e, Project::COLLECTION, Project::CONTROLLER, Project::ICON, $this->module->id,$tags,$scopes);
						}
					}*/

					?>
				</tbody>
			</table>


			<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 0px; display: none;"><div class="ps-scrollbar-x" style="left: -10px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 230px; display: inherit;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div>
			<?php 
				/*if (isset($organizations) && count($organizations) == 0) {
			?>
				<div id="infoPodOrga" class="padding-10">
					<blockquote> 
						Create or Connect 
						<br>an Organization, NGO,  
						<br>Local Business, Informal Group. 
						<br>Build links in your network, 
						<br>to create a connected local directory 
					</blockquote>
				</div>
			<?php 
				};*/
			?>
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>
<script type="text/javascript">
var openingFilter = "<?php echo ( isset($_GET['type']) ) ? $_GET['type'] : '' ?>";
var directoryTable = null;
var contextMap = {
	"tags" : <?php echo json_encode($tags) ?>,
	"scopes" : <?php echo json_encode($scopes) ?>,
};
var results = <?php echo json_encode($results) ?>;
var betaTest= "<?php echo @Yii::app()->params['betaTest'] ?>";
var icons = {
	organizations : "fa-group",
	projects : "fa-lightbulb-o",
	events : "fa-calendar",
	citoyens : "fa-user",
};
var search={
	value:"",
	page:""
};
jQuery(document).ready(function() {
	setTitle("Espace administrateur : Répertoire","cog");
	initKInterface();
	initViewTable(results);
	if(openingFilter != "")
		$('.filter'+openingFilter).trigger("click");
	$("#input-search-table").keyup(function(e){
        //$("#second-search-bar").val($("#input-search-map").val());
        //$("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            search.page=0;
            search.value = $(this).val();
            startAdminSearch(true);
         }
    });
    initPageTable(results.countPeople);

});	
function initPageTable(number){
	numberPage=(number/100);
	$('.pageTable').pagination({
        items: numberPage,
        itemOnPage: 8,
        currentPage: 1,
        hrefTextPrefix:"?page=",
        cssStyle: 'light-theme',
        prevText: '<span aria-hidden="true">&laquo;</span>',
        nextText: '<span aria-hidden="true">&raquo;</span>',
        onInit: function () {
            // fire first page loading
        },
        onPageClick: function (page, evt) {
            // some code
            //alert(page);
            search.page=(page-1);
            startAdminSearch();
        }
    });
}
function initViewTable(data){
	$('#panelAdmin .directoryLines').html("");
	//showLoader('#panelAdmin .directoryLines');
	console.log("valuesInit",data);
	$.each(data,function(type,list){
		$.each(list, function(key, values){
			entry=buildDirectoryLine( values, type, type, icons[type]);
			$("#panelAdmin .directoryLines").append(entry);
		});
	});
	bindAdminBtnEvents();
	//resetDirectoryTable() ;
}
function startAdminSearch(initPage){

    //$("#second-search-bar").val(search);
    $('#panelAdmin .directoryLines').html("Recherche en cours. Merci de patienter quelques instants...");

    /*var params = {
        search:search,
        status:status,
        orderBy:"url"
    };*/

    $.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+"/admin/directory/tpl/json",
        data: search,
        dataType: "json",
        success:function(data) { 
	          initViewTable(data.results);
	          bindAdminBtnEvents();
	          if(initPage)
	          	initPageTable(data.results.countPeople);
        },
        error:function(xhr, status, error){
            $("#searchResults").html("erreur");
        },
        statusCode:{
                404: function(){
                    $("#searchResults").html("not found");
            }
        }
    });
}
function buildDirectoryLine( e, collection, type, icon/* tags, scopes*/ ){
		strHTML="";
		if(typeof e._id =="undefined" || typeof e.name == "undefined" || e.name == "" )
			return strHTML;
		actions = "";
		classes = "";
		id = e._id.$id;

		/* **************************************
		* ADMIN STUFF
		***************************************** */
		if(userId != "" 
			&& typeof userConnected.roles != "undefined" 
			&& typeof userConnected.roles.superAdmin != "undefined" 
			&& userConnected.roles.superAdmin){
			if(type == "<?php echo Person::COLLECTION ?>"){
				//Activated
				if( typeof e.roles != "undefined" && typeof e.roles.tobeactivated != "undefined" )
				{
					classes += "tobeactivated";
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 validateThisBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Validate </a></li>';
				}
				//Beta Test
				if (betaTest) {
					if( typeof e.roles != "undefined" && typeof e.roles.betaTester != "undefined" ) {
						classes += "betaTester";
						actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 revokeBetaTesterBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Revoke this beta tester </a></li>';
					} else {
						$actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 addBetaTesterBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Add this beta tester </a></li>';
					}
				}
				//Super Admin
				if( typeof e.roles != "undefined" && typeof e.roles.superAdmin != "undefined" ) {
					classes += "superAdmin";
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 revokeSuperAdminBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Revoke this super admin </a></li>';
				} else {
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 addSuperAdminBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Add this super admin </a></li>';
				}

				actions += '<li><a href="javascript:;" data-id="'+id+'" class="margin-right-5 switch2UserThisBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-eye fa-stack-1x stack-right-bottom text-danger"></i></span> Switch to this user</a> </li>';

				actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 deleteThisBtn"><i class="fa fa-times text-red"></i>Delete</a> </li>';
				//TODO
				actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 banThisBtn"><i class="fa fa-times text-red"></i> TODO : Ban</a> </li>';
				
			} else if( type == "<?php echo Organization::COLLECTION ?>" ) {
			
			}
		}

		/* **************************************
		* TYPE + ICON
		***************************************** */
	strHTML += '<tr id="'+type+id+'">'+
		'<td class="'+collection+'Line '+classes+'">'+
			'<a href="#page.type.'+type+'.id.'+id+'" class="lbh" target="_blank">';
				if (e && typeof e.profilThumbImageUrl != "undefined" && e.profilThumbImageUrl!="")
					strHTML += '<img width="50" height="50" alt="image" class="img-circle" src="'+baseUrl+e.profilThumbImageUrl+'">'+e.type;
				else 
					strHTML += '<i class="fa '+icon+' fa-2x"></i> '+type;
			strHTML += '</a>';
		strHTML += '</td>';
		
		/* **************************************
		* NAME
		***************************************** */
		strHTML += '<td><a href="#page.type.'+type+'.id.'+id+'" class="lbh" target="_blank">'+e.name+'</a></td>';
		
		/* **************************************
		* EMAIL for admin use only
		***************************************** */
		strHTML += '<td>'+e.email+'</td>';

		/* **************************************
		* TAGS
		***************************************** */
		strHTML += '<td>';
		if(typeof e.tags != "undefined"){
			$.each(e.tags, function(key,value){
				strHTML += ' <a href="#" onclick="applyTagFilter(\''+value+'\')"><span class="label label-inverse">'+value+'</span></a>';
				//if( tags != "" && !in_array($value, tags) ) 
				//	array_push($tags, $value);
			});
		}
		strHTML += '</td>';

		/* **************************************
		* SCOPES
		***************************************** */
		strHTML += '<td>';
		/*if( typeof e.address != "undefined" && isset( $e["address"]['codeInsee']) ){
			$strHTML .= ' <a href="#" onclick="applyScopeFilter('.$e["address"]['codeInsee'].')"><span class="label label-inverse">'.$e["address"]['codeInsee'].'</span></a>';
			if( !in_array($e["address"]['codeInsee'], $scopes['codeInsee']) ) 
				array_push($scopes['codeInsee'], $e["address"]['codeInsee'] );
		}*/
		if( typeof e.address != "undefined"){
			if(typeof e.address.codePostal != "undefined" ){
				strHTML += ' <a href="#" onclick="applyScopeFilter('+e.address.codePostal+')"><span class="label label-inverse">'+e.address.codePostal+'</span></a>';
			//if( !in_array($e["address"]['codePostal'], $scopes['codePostal']) ) 
			//	array_push($scopes['codePostal'], $e["address"]['codePostal'] );
			}
			if(typeof e.address.addressLocality != "undefined"){
				strHTML += ' <a href="#" onclick="applyScopeFilter('+e.address.addressLocality+')"><span class="label label-inverse">'+e.address.addressLocality+'</span></a>';
			}
			if(typeof e.address.region){
				strHTML += '<a href="#" onclick="applyScopeFilter('+e.address.region+')"><span class="label label-inverse">'+e.address.region+'</span></a>';
			//if( !in_array($e["address"]['region'], $scopes['region']) ) 
			//	array_push($scopes['region'], $e["address"]['region'] );
			}	
		}
		strHTML += '</td>';

		/* **************************************
		* ACTIONS
		***************************************** */
		strHTML += '<td class="center">';
		if( actions != "" ){ 
			strHTML += '<div class="btn-group">'+
						'<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm"><i class="fa fa-cog"></i> <span class="caret"></span></a>'+
						'<ul class="dropdown-menu pull-right dropdown-dark" role="menu">'+
							actions+
						'</ul></div>';
		}
		strHTML += '</td>';
	
	strHTML += '</tr>';
	return strHTML;
}

function resetDirectoryTable() 
{ 
	/*mylog.log("resetDirectoryTable");

	if( !$('.directoryTable').hasClass("dataTable") )
	{
		directoryTable = $('.directoryTable').dataTable({
			"aoColumnDefs" : [{
				"aTargets" : [0]
			}],
			"oLanguage" : {
				"sLengthMenu" : "Show _MENU_ Rows",
				"sSearch" : "",
				"oPaginate" : {
					"sPrevious" : "",
					"sNext" : ""
				}
			},
			"aaSorting" : [[1, 'asc']],
			"aLengthMenu" : [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
			],
			// set the initial value
			"iDisplayLength" : 10,
		});
	} 
	else 
	{
		if( $(".directoryLines").children('tr').length > 0 )
		{
			directoryTable.dataTable().fnDestroy();
			directoryTable.dataTable().fnDraw();
		} else {
			mylog.log(" directoryTable fnClearTable");
			directoryTable.dataTable().fnClearTable();
		}
	}*/
}

function applyStateFilter(str)
{
	mylog.log("applyStateFilter",str);
	directoryTable.DataTable().column( 0 ).search( str , true , false ).draw();
}
function clearAllFilters(str){ 
	directoryTable.DataTable().column( 0 ).search( str , true , false ).draw();
	directoryTable.DataTable().column( 2 ).search( str , true , false ).draw();
	directoryTable.DataTable().column( 3 ).search( str , true , false ).draw();
}
function applyTagFilter(str)
{
	mylog.log("applyTagFilter",str);
	if(!str){
		str = "";
		sep = "";
		$.each($(".btn-tag.active"), function() { 
			mylog.log("applyTagFilter",$(this).data("id"));
			str += sep+$(this).data("id");
			sep = "|";
		});
	} else 
		clearAllFilters("");
	mylog.log("applyTagFilter",str);
	directoryTable.DataTable().column( 2 ).search( str , true , false ).draw();
	return $('.directoryLines tr').length;
}

function applyScopeFilter(str)
{
	//mylog.log("applyScopeFilter",$(".btn-context-scope.active").length);
	if(!str){
		str = "";
		sep = "";
		$.each( $(".btn-context-scope.active"), function() { 
			mylog.log("applyScopeFilter",$(this).data("val"));
			str += sep+$(this).data("val");
			sep = "|";
		});
	} else 
		clearAllFilters("");
	mylog.log("applyScopeFilter",str);
	directoryTable.DataTable().column( 3 ).search( str , true , false ).draw();
	return $('.directoryLines tr').length;
}

function bindAdminBtnEvents(){
	mylog.log("bindAdminBtnEvents");
	
	<?php 
	/* **************************************
	* ADMIN STUFF
	***************************************** */
	if( Yii::app()->session["userIsAdmin"] ) { ?>		

		$(".validateThisBtn").off().on("click",function () 
		{
			mylog.log("validateThisBtn click");
	        $(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
	        var btnClick = $(this);
	        var id = $(this).data("id");
	        var type = $(this).data("type");
	        var urlToSend = baseUrl+"/"+moduleId+"/admin/activateuser/user/"+id;
	        
	        bootbox.confirm("confirm please !!",
        	function(result) 
        	{
				if (!result) {
					btnClick.empty().html('<i class="fa fa-thumbs-down"></i>');
					return;
				}
				$.ajax({
			        type: "POST",
			        url: urlToSend,
			        dataType : "json"
			    })
			    .done(function (data)
			    {
			        if ( data && data.result ) {
			        	toastr.info("Activated User!!");
			        	btnClick.empty().html('<i class="fa fa-thumbs-up"></i>');
			        } else {
			           toastr.info("something went wrong!! please try again.");
			        }
			    });

			});

		});

		$(".addBetaTesterBtn").off().on("click",function () {
			var btnClick = $(this);
			bootbox.confirm("confirm please !!", function(result) {
				if (result) {
					changeRole(btnClick, "addBetaTester");
				}
			});
		});

		$(".revokeBetaTesterBtn").off().on("click",function () {
			var btnClick = $(this);
			bootbox.confirm("confirm please !!", function(result) {
				if (result) {
					changeRole(btnClick, "revokeBetaTester")
				}
			});
		});

		$(".addSuperAdminBtn").off().on("click",function () {
			var btnClick = $(this);
			bootbox.confirm("confirm please !!", function(result) {
				if (result) {
					changeRole(btnClick, "addSuperAdmin");
				}
			});
		});

		$(".revokeSuperAdminBtn").off().on("click",function () {
			var btnClick = $(this);
			bootbox.confirm("confirm please !!", function(result) {
				if (result) {
					changeRole(btnClick, "revokeSuperAdmin")
				}
			});
		});

		
		$(".switch2UserThisBtn").off().on("click",function () 
		{
			mylog.log("A FAIRE : switch2UserThisBtn click");
	        //$(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
	        var btnClick = $(this);
	        var id = $(this).data("id");
	        var urlToSend = baseUrl+"/"+moduleId+"/admin/switchto/uid/"+id;
	        
	        bootbox.confirm("confirm please !!",
        	function(result) 
        	{
				if (!result) {
					btnClick.empty().html('<i class="fa fa-thumbs-down"></i>');
					return;
				} else {
					$.ajax({
				        type: "POST",
				        url: urlToSend,
				        dataType : "json"
				    })
				    .done(function (data)
				    {
				        if ( data && data.result ) {
				        	toastr.info("Switched user!!");
				        	location.hash='#page.type.citoyens.id.'+data.id;
						        				window.location.reload();
				        	//window.location.href = baseUrl+"/"+moduleId;
				        } else {
				           toastr.error("something went wrong!! please try again.");
				        }
				    });
				}
			});

		});

		$(".deleteThisBtn").off().on("click",function () 
		{
			mylog.log("deleteThisBtn click");
	        /*$(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
	        var btnClick = $(this);
	        var id = $(this).data("id");
	        var type = $(this).data("type");
	        var urlToSend = baseUrl+"/"+moduleId+"/admin/delete/type/"+type+"/id/"+id;
	        
	        bootbox.confirm("confirm please !!",
        	function(result) 
        	{
				if (!result) {
					btnClick.empty().html('<i class="fa fa-thumbs-down"></i>');
					return;
				} else {
					$.ajax({
				        type: "POST",
				        url: urlToSend,
				        dataType : "json"
				    })
				    .done(function (data) {
				        if ( data && data.result ) {
				        	toastr.info("User has been deleted");
				        	$("#"+type+id).remove();
				        	//window.location.href = "";
				        } else {
				           toastr.error("something went wrong!! please try again.");
				        }
				    });
				}
			});*/

		});
	
	<?php } ?>

	$(".banThisBtn").off().on("click",function (){
		mylog.log("banThisBtn click");
	});
}

function changeRole(button, action) {
	mylog.log(button," click");
    //$(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
    var urlToSend = baseUrl+"/"+moduleId+"/person/changerole/";
    var res = false;

	$.ajax({
        type: "POST",
        url: urlToSend,
        data: {
        	"id" : button.data("id"),
			"action" : action
        },
        dataType : "json"
    })
    .done(function (data) {
        if ( data && data.result ) {
        	toastr.success("Change has been done !!");
        	changeButtonName(button, action);
        	bindAdminBtnEvents();
        } else {
           toastr.error("Something went wrong!! please try again. " + data.msg);
        }
    });
}

function changeButtonName(button, action) {
	mylog.log(action);
	var icon = '<span class="fa-stack"> <i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span>';
	if (action=="addBetaTester") {
		button.removeClass("addBetaTesterBtn");
		button.addClass("revokeBetaTesterBtn");
		button.html(icon+" Revoke this beta tester");
	} else if (action=="revokeBetaTester") {
		button.removeClass("revokeBetaTesterBtn");
		button.addClass("addBetaTesterBtn");
		button.html(icon+" Add this beta tester");
	} else if (action=="addSuperAdmin") {
		button.removeClass("addSuperAdminBtn");
		button.addClass("revokeSuperAdminBtn");
		button.html(icon+" Revoke this super admin");
	} else if (action=="revokeSuperAdmin") {
		button.removeClass("revokeSuperAdminBtn");
		button.addClass("addSuperAdminBtn");
		button.html(icon+" Add this super admin");
	} else {
		mylog.warn("Unknown action !");
	}
}

</script>