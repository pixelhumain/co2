
 function showTagsScopesMin(htmlId){
        htmlId=".scope-min-header";

        /************** SCOPES **************/
        var iconSelectScope = "<i class='fa fa-circle-o'></i>";
        var scopeSelected = false;

        
        html = "<div class='list-select-scopes'>";
        
        var numberOfScope = 0;
        if(typeof myMultiScopes != "undefined")
        $.each(myMultiScopes, function(key, value){
            numberOfScope++;
            var disabled = value.active == false ? "disabled" : "";
            if(typeof value.name == "undefined") value.name = key;
            html +=     "<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
                            "class='text-red "+disabled+" item-scope-checker margin-right-10' data-scope-value='"+ key + "'>" + 
                            "<i class='fa fa-check-circle'></i> " + value.name + 
                        "</span> ";
        });
        // if (numberOfScope == 0) {
        //     html +=     '<span id="helpMultiScope" class="toggle-scope-dropdown" style="padding-left:0px">'+
        //                     '<a href="javascript:"> Ajouter des filtres géographiques ?</a>'+
        //                 '</span>';
        // }
        html +=     "</span>";
        html += "</div>";

        $(htmlId).html(html);
        multiTagScopeLbl();

        $(".item-scope-checker").off().click(function(){ 
            toogleScopeMultiscope( $(this).data("scope-value") );
            $("#footerDropdown").html("<i class='fa fa-circle'></i> <i class='fa fa-circle'></i> <i class='fa fa-circle'></i><hr style='margin-top: 34px;'>");
            var sec = 3;
            if(typeof interval != "undefined") clearInterval(interval);
            interval = setInterval(function(){ 
            	if(sec == 1){
            		startSearch(0, indexStepInit); 
            		clearInterval(interval);
            	}
            	else{
            		sec--;
            		var str = "";
            		for(n=0;n<sec;n++) str += "<i class='fa fa-circle'></i> ";
            		str += "<hr style='margin-top: 34px;'>";
            		$("#footerDropdown").html(str);
            	}
            }, 800);

            //if(!loadingScope)
            	//setTimeout(function(){ startSearch(0, indexStepInit); }, 300);
       
            checkScopeMax();
        });
        
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
	console.log("showEmptyMsg", c);
	if(c==0) $("#modalScopes .visible-empty").show(); else $("#modalScopes .visible-empty").hide();
	if(c==0) $("#modalScopes .hidden-empty").hide(); else $("#modalScopes .hidden-empty").show();

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

