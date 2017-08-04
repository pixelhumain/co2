dynForm = {
    jsonSchema : {
	    title : tradDynForm.addroom,
	    icon : "connectdevelop",
	    type : "object",
        save : function (){
            alert("saving Room!!");
            mylog.log("type : ", $("#ajaxFormModal #type").val());
            
            var params = { 
               "email" : userConnected.email , 
               "name" : $("#ajaxFormModal #name").val() , 
               "tags" : $("#ajaxFormModal #tags").val().split(","),
               "type" : $("#ajaxFormModal #type").val()
            };
            if( $("#ajaxFormModal #parentType").val() != "")
              params.parentType = $("#ajaxFormModal #parentType").val();
            if( $("#ajaxFormModal #parentId").val() != "")
              params.parentId = $("#ajaxFormModal #parentId").val();
           mylog.dir(params);
            $.ajax({
              type: "POST",
              url: baseUrl+"/"+moduleId+'/rooms/saveroom',
              data: params,
              success: function(data){
                if(data.result){
                  delete window.myActionsList;
                  delete window.myVotesList;
                  alert("SUCCESS SAVE ROOM :");
                  mylog.dir(data);
                  dyFObj.elementObj.dynForm.jsonSchema.afterSave();
                }
                else {
                  toastr.error(data.msg);
                }
                $.unblockUI();
              },
              dataType: "json"
            });
        },
	    onLoads : {
	    	sub : function(){
    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-url");
    		 	
    		 	if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
    		},
            onload : function(data){
                if(data && data.type){
                    $(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+tradCategory[data.type]+"</h4>");
                    $(".sectionBtntagList").hide();
                } else
                    $(".nametext, .imageuploader, .tagstags, #btn-submit-form").hide();
            }
	    },
        beforeSave : function(){
            
            if( $("#ajaxFormModal #section").val() )
                $("#ajaxFormModal #type").val($("#ajaxFormModal #section").val());

            if($('#ajaxFormModal #parentId').val() == "" && $('#ajaxFormModal #parentType').val() ){
                $('#ajaxFormModal #parentId').val( userId );
                $("#ajaxFormModal #parentType").val( "citoyens" ); 
            }
        },
        beforeBuild : function(){
            dyFObj.setMongoId('poi',function(){
                uploadObj.gotoUrl = (contextData != null && contextData.type && contextData.id ) ? "#page.type."+contextData.type+".id."+contextData.id+".view.directory.dir.poi" : location.hash;
            });
        },
	    afterSave : function(){
            if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { 
                dyFObj.closeForm(); 
                urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
            }
	    },
        canSubmitIf : function () { 
             return ( $("#ajaxFormModal #type").val() ) ? true : false ;
        },
        actions : {
            clear : function() {
                
                $("#ajaxFormModal #section, #ajaxFormModal #type, #ajaxFormModal #subtype").val("");

                $(".breadcrumbcustom").html( "");
                $(".sectionBtntagList").show(); 
                $(".typeBtntagList").hide(); 
                $(".subtypeSection").html("");
                $(".subtypeSectioncustom").show();
                $(".nametext, .imageuploader, .tagstags, #btn-submit-form").hide();
            }
        },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm.infocreateRoom+".</p>",
            },
            parentId : dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
            breadcrumb : {
                inputType : "custom",
                html:"",
            },
            sectionBtn :{
                label : tradDynForm.whichkindofroom+" ? ",
                inputType : "tagList",
                placeholder : "Choisir un type",
                list : roomList.sections,
                trad : tradCategory,
                init : function(){ //console.log("LIST ROOM TYPE", roomList);
                    $(".sectionBtn").off().on("click",function()
                    {
                        $(".typeBtntagList").show();
                        $(".sectionBtn").removeClass("active btn-dark-blue text-white");
                        $( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
                        $("#ajaxFormModal #type").val( $(this).data('key') );
                        
                        
                        $(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(this).data('tag')+"</h4>");
                        $(".sectionBtntagList").hide();
                        $(".nametext, .imageuploader, .tagstags").show();
                        dyFObj.canSubmitIf();
                    });
                }
            },
            type : dyFInputs.inputHidden(),
            name : dyFInputs.name("room"),
            image : dyFInputs.image(),
            tags : dyFInputs.tags()
	    }
	}
};