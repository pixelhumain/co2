dynForm = {
    jsonSchema : {
	    title : tradDynForm.addroom,
	    icon : "connectdevelop",
	    type : "object",
	    onLoads : {
	    	sub : function(){
    			uploadObj.gotoUrl = "tmp";
    		},
        onload : function(data){
            dataHelper.activateMarkdown("#ajaxFormModal #description");
            $("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
                                        .addClass("bg-turq");

            console.log("init input hidden parentdata : ", contextData.id, contextData.type);
            $("#ajaxFormModal #parentId").val(contextData.id);
            $("#ajaxFormModal #parentType").val(contextData.type);
            // if(data && data.type){
            //     $(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+tradCategory[data.type]+"</h4>");
            //     $(".sectionBtntagList").hide();
            // } else
            //     $(".nametext, .imageuploader, .tagstags, #btn-submit-form").hide();
        }
	    },
      beforeBuild : function(){
          dyFObj.setMongoId('actionRooms',function(){});
      },
	    afterSave : function(data){
            /*if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { */
                console.log("RES CREATE ROOM :", data);
                dyFObj.closeForm(); 
                uiCoop.getCoopData(data.map.parentType, data.map.parentId, "room");
                setTimeout(function(){
                  uiCoop.getCoopData(data.map.parentType, data.map.parentId, "room", null, data.id);
                }, 1000);
                
                //uiCoop.getCoopData(contextData.type, contextData.id, "room", null, uploadObj.id);
                //urlCtrl.loadByHash( uploadObj.gotoUrl );
            /*}*/
	    },
      canSubmitIf : function () { 
           return ( $("#ajaxFormModal #type").val() ) ? true : false ;
      },
      actions : {
          clear : function() {
              
              $("#ajaxFormModal #section, #ajaxFormModal #type").val("");

              $(".breadcrumbcustom").html( "");
              $(".sectionBtntagList").show(); 
              $(".nametext, .imageuploader, .tagstags, #btn-submit-form").hide();
          }
      },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm.infocreateRoom+".</p>",
            },
            parentId : dyFInputs.inputHidden(contextData.id),
            parentType : dyFInputs.inputHidden(contextData.type),
            status : dyFInputs.inputHidden("open"),
            name : dyFInputs.name("room"),
            description : dyFInputs.textarea(tradDynForm.description, "...",null,true),
            roles : dyFInputs.tags(rolesList, tradDynForm["addroles"] , tradDynForm["limitAccessRole"]),
      }
	}
};