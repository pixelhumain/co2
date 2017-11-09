
 function showTagsScopesMin(htmlId){
        htmlId=".scope-min-header";
        var numberOfScope = 0;
        if(typeof myMultiScopes != "undefined"){
            $.each(myMultiScopes, function(key, value){
                numberOfScope++;
            })  ;
        }
        scopeHtml="";

        //if(typeof userConnected != "undefined" && userConnected != null ){
             if( typeof communexion != "undefined" && notEmpty(communexion.values) ) {
                scopeHtml='<button class="pull-left btn btn-link bg-white text-red tooltips item-globalscope-checker start-new-communexion" '+
                            'data-toggle="tooltip" data-placement="top" title="'+trad["communectwith"]+' '+communexion.currentName+'" '+
                            'data-scope-value="'+communexion.currentValue+'" '+
                            'data-scope-name="'+communexion.currentName+'" '+
                            'data-scope-level="'+communexion.currentLevel+'" '+
                            'data-scope-type="'+communexion.communexionType+'" '+
                            'id="btn-my-co">'+
                            '<i class="fa fa-university"></i>'+
                        '</button>';
            }else{
                if(userId!=""){
                    scopeHtml='<button class="pull-left btn btn-link bg-white text-red tooltips" onclick="communecterUser();" '+
                            'data-toggle="tooltip" data-placement="top" title="'+trad["communectyou"]+'" '+
                            'id="btn-my-co">'+
                            '<i class="fa fa-university"></i>'+
                        '</button>';
                }
            }
        //}
       
        scopeHtml+='<h5 class="pull-left letter-red" style="margin-bottom: -8px;margin-top: 14px;">'+
                        '<button class="btn btn-default main-btn-scopes text-white tooltips margin-bottom-5 margin-left-10 margin-right-10" '+ 
                            'data-target="#modalScopes" data-toggle="modal" '+
                            'data-toggle="tooltip" data-placement="top" '+ 
                            'title="'+trad["selectscopesearch"]+'">'+
                            '<img src="'+themeUrl+'/assets/img/cible3.png" height=25>'+
                        '</button>';
                        if(numberOfScope > 0){
                            scopeHtml+= trad["searchingon"]+' <i class="fa fa-angle-right"></i>';
                        } else{
                            scopeHtml+= '<span id="helpMultiScope" class="toggle-scope-dropdown">'+
                                           '<a href="javascript:" data-target="#modalScopes" data-toggle="modal" class="letter-red">'+
                                                '<i class="fa fa-plus"></i> '+trad["addScopeFilters"]+' ?'+
                                            '</a>'+
                                        '</span>';
                        }
		


        scopeHtml+= '</h5>'+
                    '<div class="scope-min-header list_tags_scopes text-left ellipsis">'+
                    '</div>';

        if( notEmpty(userConnected) && notEmpty(userConnected.inter) ) {
        	scopeHtml+= "<div id='divInterScope' class='no-padding letter-red' style=''><br/><br/><br/><br/>"+
                		"Nous avons du remettre les paramètres géographiques à zéro, pour prendre en compte la nouvelle mise à jour "+
						'<a class="btn btn-xs tooltips btn-accept" href="javascript:;" onclick="validateScopeInter()">'+
							'<i class="fa fa-check "></i> Cliquer ici pour ne plus voir ce message.'+
						'</a>'+
		            "</div>";
        }
        
        $("#container-scope-filter").html(scopeHtml);
        //}
        /************** SCOPES **************/
        var iconSelectScope = "<i class='fa fa-circle-o'></i>";
        var scopeSelected = false;

        
        html = "<div class='list-select-scopes'>";
        if(numberOfScope > 0){
            $.each(myMultiScopes, function(key, value){
                numberOfScope++;
                var disabled = value.active == false ? "disabled" : "";
                if(typeof value.name == "undefined") value.name = key;
                html +=     "<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
                                "class='text-red "+disabled+" item-scope-checker item-scope-input margin-right-10' data-scope-value='"+ key + "'>" + 
                                "<i class='fa fa-check-circle'></i> " + value.name + 
                            "</span> ";
            });
        }
        html += "</div>";
        $(htmlId).html(html);
        if(actionOnSetGlobalScope=="save"){
            scopeHtml='<a class="pull-left btn btn-link bg-white text-red tooltips item-globalscope-checker start-new-communexion" '+
                            'data-toggle="tooltip" data-placement="top" title="Communecter avec '+communexion.currentName+'" '+
                            'data-scope-value="'+communexion.currentValue+'" '+
                            'data-scope-name="'+communexion.currentName+'" '+
                            'data-scope-level="'+communexion.currentLevel+'" '+
                            'data-scope-type="'+communexion.communexionType+'" '+
                            'id="btn-my-co">'+
                            '<i class="fa fa-university"></i>'+
                        '</a>'+
                        '<h5 class="pull-left letter-red" style="margin-bottom: -8px;margin-top: 14px;">'+
                            '<a class="btn btn-default main-btn-scopes text-white tooltips margin-bottom-5 margin-left-10 margin-right-10" '+ 
                                'data-target="#modalScopes" data-toggle="modal" '+
                                'data-toggle="tooltip" data-placement="top" '+ 
                                'title="Sélectionner des lieux de recherche">'+
                                '<img src="'+themeUrl+'/assets/img/cible3.png" height=25>'+
                            '</a>'+ 
                            'Selectionner les endroits de publications <i class="fa fa-angle-right"></i>'+ 
                        '</h5>'+
                        '<div class="scope-min-header list_tags_scopes hidden-xs text-left ellipsis">'+
                            html+
                        '</div>';
            $("#scopeListContainerForm").html(scopeHtml);
        }
        multiTagScopeLbl();
        //bindCommunexionScopeEvents();
        
        $(".toggle-scope-dropdown").click(function(){ //mylog.log("toogle");
            if(!$("#dropdown-content-multi-scope").hasClass('open'))
            setTimeout(function(){ $("#dropdown-content-multi-scope").addClass('open'); }, 300);
        });

        
        if(scopeSelected){ $(".btnShowAllScope").hide(); $(".btnHideAllScope").show(); } 
        else             { $(".btnShowAllScope").show(); $(".btnHideAllScope").hide(); }

        checkScopeMax();
        rebuildSearchScopeInput();

    }

var currentTypeSearchSend = "search";
function multiTagScopeLbl(type){
	if(!notEmpty(type)) type = currentTypeSearchSend;
	if(type=="search"){
		$("#lbl-my-scopes").html("Rechercher par lieux <i class='fa fa-angle-right'></i> ");
		$("#lbl-my-tags").html("Rechercher par tags <i class='fa fa-angle-right'></i> ");
		$("br.visible-in-form").hide();
	}else if(type=="send"){
		$("#lbl-my-scopes").html("<i class='fa fa-angle-down'></i> Sélectionnez les lieux de destination");
		$("#lbl-my-tags").html("<i class='fa fa-angle-down'></i> Sélectionner des tags<span class='hidden-xs'> pour définir le contenu de votre message</span>");
		$("br.visible-in-form").show();
	}
	currentTypeSearchSend = type;
}

function showEmptyMsg(){
	var c=0; 
	if(typeof myMultiScopes != "undefined")
		$.each(myMultiScopes, function(key, value){ c++; });
	mylog.log("showEmptyMsg", c);
	if(c==0) 
        $("#modalScopes .visible-empty").show(); 
    else 
        $("#modalScopes .visible-empty").hide();
	if(c==0) 
        $("#modalScopes .hidden-empty").hide(); 
    else 
        $("#modalScopes .hidden-empty").show();

	//c=0; $.each(myMultiTags, function(key, value){ c++; });
	//if(c==0) $("#dropdown-multi-tag .visible-empty").show(); else $("#dropdown-multi-tag .visible-empty").hide();
	
}


function slidupScopetagsMin(show){ //mylog.log("slidupScopetagsMin", show);
	if($("#list_filters").hasClass("hidden")){
	    $("#list_filters").removeClass("hidden");
	    $("#btn-slidup-scopetags").html("<i class='fa fa-minus'></i>");
	}
	else{
	    $("#list_filters").addClass("hidden"); //mylog.log("hidden slidupScopetagsMin", show);
	    $("#btn-slidup-scopetags").html("<i class='fa fa-plus'></i>");
	}

	if(show==true){
	    $("#list_filters").removeClass("hidden"); //mylog.log("removeClass hidden slidupScopetagsMin", show);
	    $("#btn-slidup-scopetags").html("<i class='fa fa-minus'></i>");
	}
	else if(show==false){
	    $("#list_filters").addClass("hidden");
	    $("#btn-slidup-scopetags").html("<i class='fa fa-plus'></i>");
	}
}

function validateScopeInter(){ 
	mylog.log("validateScopeInter");
	
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/person/updatescopeinter/",
		data: {},
		dataType: "json",
		success: function(data){
			mylog.log("validateScopeInter", data);
			if(data.result){
				 toastr.success(data.msg);
                 userConnected.inter = false ;
				$("#divInterScope").addClass("hidden");
			}
			else
				 toastr.error(data.msg);
		},
		
	});
}



