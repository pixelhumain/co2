dynForm = {
    jsonSchema : {
	    title : tradDynForm.addinfotodoc,
	    icon : "camera",
	    type : "object",
      save : function (){
            mylog.log("type : ", $("#ajaxFormModal #type").val());
            var params = { 
               id : $("#ajaxFormModal #docId").val(),
               title : $("#ajaxFormModal #title").val() , 
               //tags : $("#ajaxFormModal #tags").val().split(","),
               //type : $("#ajaxFormModal #type").val(),
               //parentId : (contextData.parentId) ? contextData.parentId : contextData.id,
               //parentType : (contextData.parentType) ? contextData.parentType : contextData.type
            };

           mylog.dir(params);
            $.ajax({
              type: "POST",
              url: baseUrl+"/"+moduleId+'/document/update',
              data: params,
              success: function(data){
                if(data.result){
                  //delete window.myActionsList;
                  //delete window.myVotesList;
                  toastr.success( "SUCCESS have title !");
                  mylog.dir(data);
                  $("#"+data.data.id).find(".tools-bottom > span").html(data.data.title);
                  dyFObj.closeForm();
                  //uploadObj.gotoUrl = (uploadObj.gotoUrl) ? "#page.type."+params.parentType+".id."+params.parentId+".view.dda.dir."+$("#ajaxFormModal #type").val() +".idda."+ uploadObj.id : location.hash;
                  //dyFObj.elementObj.dynForm.jsonSchema.afterSave();
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
    		 	
    		 	$("#ajax-modal-modal-title").html(
    		 	$("#ajax-modal-modal-title").html());
    		
				//$("#ajaxFormModal #docId").val();
    			//if( contextData && contextData.type )
    			//	$("#ajaxFormModal #parentType").val( contextData.type ); 
    		},
	    },
	    afterSave : function(data){
			  dyFObj.closeForm();
		    mylog.dir(data);
            //urlCtrl.loadByHash( location.hash );
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm.infoimages+".</p>",
            },
        title : dyFInputs.inputText(tradDynForm.titleimage, tradDynForm.titleimage, { required : true }),
	      docId : dyFInputs.inputHidden(null, { required : true }),
	    }
	}
};