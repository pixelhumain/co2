<?php

 $cssAnsScriptFiles = array(
    '/assets/js/web.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl);       
?>

<h1 class="letter-"><i class="fa fa-grav letter-red"></i> Bonjour <span class="letter-red">Super Admin</span></h1>
<h5 class="letter-">
	<button class="btn btn-sm btn-superadmin" data-action="lilo" data-idres="#central-container"><i class="fa fa-refresh"></i> </button>
	Section : <i class="fa fa-search letter-red"></i> 
	<span class="font-blackoutM letter-red">lilo</span>
</h5>

<br>
<hr>
<br>

<button class="btn btn-default" id="startLiloSearch">Rechercher</button>
<div id="allResLilo" class="hidden"></div>
<div id="resLilo"></div>

<script>
	
	jQuery(document).ready(function() {
		$("#startLiloSearch").click(function(){
			searchLilo("test");
		});

		$(".btn-superadmin").click(function(){
			var action = $(this).data("action");
				getAjax('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/"+action,function(){ 
					
			},"html");
		});
	});

	function searchLilo(search){
		
		$("#allResLilo, #resLilo").html("");

		var url = "https://search.lilo.org/searchweb.php?q=";
		$.ajax({ 
		    	url: "//cors-anywhere.herokuapp.com/"+url+search, // 'http://google.fr', 
		    	crossOrigin: true,
		    	timeout:10000,
		        success:
					function(data) {
						var tempDom = $('<output>').append($.parseHTML(data));
					    var res = $('.gsc-wrapper#results', tempDom).html();
					   
					    $("#resLilo").html(res);
					    
				}
		});
	}
	

</script>