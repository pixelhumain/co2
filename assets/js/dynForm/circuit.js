dynForm = {
    jsonSchema : {
	    title : "Add a services",
	    icon : "sun-o",
	    type : "object",	    
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		
	    	},
	    	onload : function(data){
	    	
	    	},
	    },
	    beforeBuild : function(){
	    	dyFObj.setMongoId('circuit',function(){
	    		uploadObj.gotoUrl = location.hash;
	    	});
	    },
	    beforeSave : function(){
	    	var tagAndTypes = ( $("#ajaxFormModal #tags").val() != "" ) ? $("#ajaxFormModal #tags").val()+"," : "" ;

	    	$("#ajaxFormModal #tags").val( tagAndTypes );	    	
	    	if( typeof $("#ajaxFormModal #description").code === 'function' )  
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    	if($('#ajaxFormModal #parentId').val() == "" && $('#ajaxFormModal #parentType').val() ){
		    	$('#ajaxFormModal #parentId').val(userId);
		    	$("#ajaxFormModal #parentType").val( "citoyens" ); 
		    }
	    },
	    afterSave : function(){
	    	dyFObj.closeForm();
		    urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"",//<p><i class='fa fa-info-circle'></i> Une Annonce est un élément assez libre qui peut etre géolocalisé ou pas, qui peut etre rataché à tous les éléments.</p>",
            },
            name : dyFInputs.name( "circuit" ),
            description : dyFInputs.textarea("Description", "..."),
            capacity : dyFInputs.quantity(),
	    }
	}
};