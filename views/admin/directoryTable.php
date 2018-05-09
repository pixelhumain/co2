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
/*$this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath , 
                            "page" => "admin") );*/ 
?>
<style type="text/css">
.simple-pagination li a, .simple-pagination li span {
    border: none;
    box-shadow: none !important;
    background: none !important;
    color: #2C3E50 !important;
    font-size: 16px !important;
    font-weight: 500;
}
.simple-pagination li.active span{
	color: #d9534f !important;
    font-size: 24px !important;	
}
</style>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<div id="" class="" style="width:80%;  display: -webkit-inline-box;">
	                <input type="text" class="form-control" id="input-search-table" 
	                        placeholder="search by name or by #tag, ex: 'commun' or '#commun'">
	    <button class="btn btn-default hidden-xs menu-btn-start-search-admin btn-directory-type">
	        <i class="fa fa-search"></i>
	    </button>
	    </div>
    </div>
	<div class="panel-heading border-light">
		<h4 class="panel-title"><i class="fa fa-globe fa-2x text-green"></i> Filtered by types : </h4>
		<?php foreach ($typeDirectory as $value) { ?>
			<a href="javascript:;" onclick="applyStateFilter('<?php echo $value ?>')" class="filter<?php echo $value ?> btn btn-xs btn-default active btncountsearch"> <?php echo $value ?> <span class="badge badge-warning countPeople" id="count<?php echo $value ?>"> <?php echo @$results["count"][$value] ?></span></a>
		<?php } ?>
		<!--<a href="javascript:;" onclick="applyStateFilter('<?php echo Person::COLLECTION ?>')" class="filter<?php echo Person::COLLECTION ?> btn btn-xs btn-default active btncountsearch"> People <span class="badge badge-warning countPeople" id="countcitoyens"> <?php echo @$results["count"]["citoyens"] ?></span></a>
		<a href="javascript:;" onclick="applyStateFilter('<?php echo Organization::COLLECTION ?>')" class="filter<?php echo Organization::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Organizations <span class="badge badge-warning countOrganizations" id="countorganizations"> <?php echo @$results["count"]["organizations"] ?></span></a> 
		<a href="javascript:;" onclick="applyStateFilter('<?php echo Event::COLLECTION ?>')" class="filter<?php echo Event::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Events <span class="badge badge-warning countEvents" id="countevents"> <?php echo @$results["count"]["events"] ?></span></a> 
		<a href="javascript:;" onclick="applyStateFilter('<?php echo Project::COLLECTION ?>')" class="filter<?php echo Project::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Projects <span class="badge badge-warning countProjects" id="countprojects"> <?php echo @$results["count"]["projects"] ?></span></a>
		<a href="javascript:;" onclick="clearAllFilters('')" class="btn btn-xs btn-default"> All</a></h4>-->
	</div>
	<!--<div class="panel-tools padding-20">
		<?php if( Yii::app()->session["userId"] ) { ?>
		<a href="javascript:;" onclick="dyFObj.openForm('organization')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Organization"><i class="fa fa-plus"></i> <i class="fa fa-group"></i> </a>

		<a href="javascript:;" onclick="dyFObj.openForm('event')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Event"><i class="fa fa-plus"></i> <i class="fa fa-calendar"></i></a>

		<a href="javascript:;" onclick="dyFObj.openForm('person')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Invite Someone "><i class="fa fa-plus"></i> <i class="fa fa-user"></i></a>
		<?php } ?>
	</div>-->
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
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
						<th>Status</th>
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
var initType = <?php echo json_encode($typeDirectory) ?>;
var betaTest= "<?php echo @Yii::app()->params['betaTest'] ?>";
var icons = {
	organizations : "fa-group",
	projects : "fa-lightbulb-o",
	events : "fa-calendar",
	citoyens : "fa-user",
	services : "fa-sun-o",
	classified : "fa-bullhorn",
	poi : "fa-map-marker",
	news : "fa-newspaper-o"
};
var search={
	value:null,
	page:"",
	type:initType[0]
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
            if(search.value=="")
            	search.value=true;
            startAdminSearch(true);
            // Init of search for count
            if(search.value===true)
            	search.value=null;
         }
    });
    initPageTable(results.count.citoyens);

});	
function initPageTable(number){
	numberPage=(number/100);
	$('.pageTable').pagination({
        items: numberPage,
        itemOnPage: 15,
        currentPage: 1,
        hrefTextPrefix:"?page=",
        cssStyle: 'light-theme',
        //prevText: '<span aria-hidden="true">&laquo;</span>',
        //nextText: '<span aria-hidden="true">&raquo;</span>',
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
function refreshCountBadge(count){
	$.each(count, function(e,v){
		$("#count"+e).text(v);
	});
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
	          if(typeof data.results.count !="undefined")
	          	refreshCountBadge(data.results.count);
	          console.log(data.results);
	          if(initPage)
	          	initPageTable(data.results.count[search.type]);
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
		if(typeof e._id =="undefined" || ((typeof e.name == "undefined" || e.name == "") && (e.text == "undefined" || e.text == "")) )
			return strHTML;
		actions = "";
		classes = "";
		id = e._id.$id;
		var status=[];
		/* **************************************
		* ADMIN STUFF
		***************************************** */
		if(userId != "" 
			&& typeof userConnected.roles != "undefined" 
			&& typeof userConnected.roles.superAdmin != "undefined" 
			&& userConnected.roles.superAdmin){
			if(type == "<?php echo Person::COLLECTION ?>"){

				mylog.log("superAdmin", e);
				//Activated
				if( typeof e.roles != "undefined" && typeof e.roles.tobeactivated != "undefined" && typeof e.roles.tobeactivated == true)
				{
					classes += "tobeactivated";
					status.push({"key":"tobeactivated","label":"To be activated"});
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 activatedUserBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span> Validate </a></li>';
				}
				//Beta Test
				if (betaTest) {
					if( typeof e.roles != "undefined" && typeof e.roles.betaTester != "undefined"  && typeof e.roles.betaTester == true ) {
						classes += "betaTester";
						actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 revokeBetaTesterBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Revoke this beta tester </a></li>';
					} else {
						$actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 addBetaTesterBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-1x stack-right-bottom text-danger"></i></span> Add this beta tester </a></li>';
					}
				}
				//Super Admin
				if( typeof e.roles != "undefined" && typeof e.roles.superAdmin != "undefined" && typeof e.roles.superAdmin == true ) {
					
					classes += "superAdmin";
					status.push({"key":"superAdmin", "label":"Super admin"});
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 revokeSuperAdminBtn"><span class="fa-stack"><i class="fa fa-user-plus fa-stack-1x"></i><i class="fa fa-times fa-stack-2x stack-right-bottom text-danger"></i></span> Revoke this super admin </a></li>';
				} else {
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 addSuperAdminBtn"><span class="fa-stack"><i class="fa fa-user-plus fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span> Add this super admin </a></li>';
				}
				if( typeof e.roles != "undefined" && typeof e.roles.isBanned != "undefined" ) {
					status.push({"key":"isBanned","label":"Banned user"});
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 unbanUserBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-stack-2x fa-check text-red"></i></span> Unban this user</a> </li>';
				}else{
					actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 banUserBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-stack-2x fa-ban stack-right-bottom text-danger"></i></span> Ban this user</a> </li>';
				}
				actions += '<li><a href="javascript:;" data-id="'+id+'" class="margin-right-5 switch2UserThisBtn"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-eye fa-stack-2x stack-right-bottom text-danger"></i></span> Switch to this user</a> </li>';
				
			}
			if(typeof e.tobevalidated != "undefined"){
				status.push({"key":"toBeValidated","label":"To be validated"});
				actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 validateThisBtn"><i class="fa fa-ban text-red"></i> Validate '+type+'</a> </li>';
			}
			actions += '<li><a href="javascript:;" data-id="'+id+'" data-type="'+type+'" class="margin-right-5 deleteThisBtn"><i class="fa fa-trash text-red"></i>Delete!</a> </li>';
			//TODO
			
			// else if( type == "<?php echo Organization::COLLECTION ?>" ) {
			
			//}
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
		if(typeof e.name != "undefined")
			title=e.name;
		else if(typeof e.text != "undefined")
			title=e.text;
		strHTML += '<td><a href="#page.type.'+type+'.id.'+id+'" class="lbh" target="_blank">'+title+'</a></td>';
		
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
				strHTML += ' <a href="javascript:;" onclick="applyTagFilter(\''+value+'\')"><span class="label label-inverse text-red">'+value+'</span></a>';
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
			if(typeof e.address.streetAddress != "undefined" ){
				strHTML += ' <a href="javascript:;" onclick="applyScopeFilter('+e.address.streetAddress+')" class="letter-blue"><span class="">'+e.address.streetAddress+'</span></a><br/>';
			//if( !in_array($e["address"]['codePostal'], $scopes['codePostal']) ) 
			//	array_push($scopes['codePostal'], $e["address"]['codePostal'] );
			}
			if(typeof e.address.postalCode != "undefined" ){
				strHTML += ' <a href="javascript:;" onclick="applyScopeFilter('+e.address.postalCode+')" class="letter-blue"><span class="">'+e.address.postalCode+'</span></a>';
			//if( !in_array($e["address"]['codePostal'], $scopes['codePostal']) ) 
			//	array_push($scopes['codePostal'], $e["address"]['codePostal'] );
			}
			if(typeof e.address.addressLocality != "undefined"){
				strHTML += ' <a href="javascript:;" onclick="applyScopeFilter('+e.address.addressLocality+')" class="letter-blue"><span class="">'+e.address.addressLocality+'</span></a><br/>';
			}
			if(typeof e.address.level1Name){
				strHTML += '<a href="javascript:;" onclick="applyScopeFilter('+e.address.level1Name+')" class="letter-blue"><span class="">'+e.address.level1Name+'</span></a><br/>';
			//if( !in_array($e["address"]['region'], $scopes['region']) ) 
			//	array_push($scopes['region'], $e["address"]['region'] );
			}
			if(typeof e.address.addressCountry){
				strHTML += '<a href="javascript:;" onclick="applyScopeFilter('+e.address.addressCountry+')" class="letter-blue"><span class="">'+e.address.addressCountry+'</span></a><br/>';
			//if( !in_array($e["address"]['region'], $scopes['region']) ) 
			//	array_push($scopes['region'], $e["address"]['region'] );
			}	
		}
		strHTML += '</td>';
		strHTML += '<td class="center status">';
			console.log(status);
			if(notEmpty(status)){
				$.each(status,function(e,v){
					strHTML+="<span class='badge bg-primary "+v.key+"'>"+v.label+"</span>";
				});
			}else{
				strHTML += "No status";
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
	//mylog.log("applyStateFilter",str);
	search.type=str;
	search.page=0;
	$(".btncountsearch").removeClass("active");
	$(".filter"+str).addClass("active");
	startAdminSearch(true);
	//directoryTable.DataTable().column( 0 ).search( str , true , false ).draw();
}
/*function clearAllFilters(str){ 
	directoryTable.DataTable().column( 0 ).search( str , true , false ).draw();
	directoryTable.DataTable().column( 2 ).search( str , true , false ).draw();
	directoryTable.DataTable().column( 3 ).search( str , true , false ).draw();
}*/
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

		$(".activatedUserBtn").off().on("click",function () 
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
			        	btnClick.parents().eq(2).find(".status .tobeactivated").remove();
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
			var id = $(this).data("id");
			var type = $(this).data("type");

			var url = baseUrl+"/"+moduleId+"/element/delete/id/"+id+"/type/"+type;
		    mylog.log("deleteElement", url);
			// var param = new Object;
			// param.reason = $("#reason").val();
			// $.ajax({
		 //        type: "POST",
		 //        url: url,
		 //        data: param,
		 //       	dataType: "json",
		 //    	success: function(data){
			//     	if(data.result){
			// 			toastr.success(data.msg);
			// 			console.log("Retour de delete : "+data.status);
			// 			if (data.status == "deleted") 
			// 				urlCtrl.loadByHash("#search");
			// 			else 
			// 				urlCtrl.loadByHash("#page.type."+type+".id."+id);
			//     	}else{
			//     		toastr.error(data.msg);
			//     	}
			//     },
			//     error: function(data){
			//     	toastr.error("Something went really bad ! Please contact the administrator.");
			//     }
			// });
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

	$(".banUserBtn").off().on("click",function (){
		mylog.log("banThisBtn click");
		var btnClick = $(this);
			bootbox.confirm("confirm please !!", function(result) {
				if (result) {
					changeRole(btnClick, "addBannedUser");
				}
		});
	});
	$(".unbanUserBtn").off().on("click",function (){
		mylog.log("banThisBtn click");
		var btnClick = $(this);
			bootbox.confirm("confirm to accept this user again !!", function(result) {
				if (result) {
					changeRole(btnClick, "revokeBannedUser");
				}
		});
	});
}

function changeRole(button, action) {
	mylog.log(button," click");
    //$(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
    var params ={
    	type:button.data("type"),
    	id:button.data("id"),
    	action:action
    }
    var urlToSend = baseUrl+"/"+moduleId+"/element/updatestatus";
    var res = false;

	$.ajax({
        type: "POST",
        url: urlToSend,
        data: params,
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
	var icon = '<span class="fa-stack"> <i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span>';
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
		button.parents().eq(4).find(".status").append("<span class='badge bg-primary superAdmin'>Super Admin</span>");
		button.html('<span class="fa-stack"> <i class="fa fa-user-plus fa-stack-1x"></i><i class="fa fa-times fa-stack-2x stack-right-bottom text-danger"></i></span>'+" Revoke this super admin");
	} else if (action=="revokeSuperAdmin") {
		button.removeClass("revokeSuperAdminBtn");
		button.addClass("addSuperAdminBtn");
		button.parents().eq(4).find(".status .superAdmin").remove();
		button.html(icon+" Add this super admin");
	} else if (action=="addBannedUser") {
		button.removeClass("banUserBtn");
		button.addClass("unbanUserBtn");
		button.parents().eq(4).find(".status").append("<span class='badge bg-primary isBanned'>Is banned</span>");
		button.html(icon+" Unban user");
	}else if (action=="revokeBannedUser") {
		button.removeClass("unbanUserBtn");
		button.addClass("banUserBtn");
		button.parents().eq(4).find(".status .isBanned").remove();
		button.html('<span class="fa-stack"> <i class="fa fa-user fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x stack-right-bottom text-danger"></i></span>'+" Ban user");
	} else {
		mylog.warn("Unknown action !");
	}
}

</script>