dynForm = { 
        dynForm : {
            jsonSchema : {
                title : "Ajouter un élément ?",
                icon : "question-cirecle-o",
                noSubmitBtns : true,
                properties : {
                    custom :{
                        inputType : "custom",
                        html : function() { 
                            return "<div class='menuSmallMenu'>"+js_templates.loop( [ 
                                { label : "event", classes:"col-xs-12 text-bold bg-"+typeObj["event"].color, icon:"fa-"+typeObj["event"].icon, action : "javascript:dyFObj.openForm('event')"},
                                { label : "organization", classes:"col-xs-12 text-bold bg-"+typeObj["organization"].color, icon:"fa-"+typeObj["organization"].icon, action : "javascript:dyFObj.openForm('organization')"},
                                { label : "project", classes:"col-xs-12 text-bold bg-"+typeObj["project"].color, icon:"fa-"+typeObj["project"].icon, action : "javascript:dyFObj.openForm('project')"},
                                { label : "poi", classes:"col-xs-12 text-bold bg-"+typeObj["poi"].color, icon:"fa-"+typeObj["poi"].icon, action : "javascript:dyFObj.openForm('poi')"},
                                { label : "entry", classes:"col-xs-12 text-bold bg-"+typeObj["entry"].color, icon:"fa-"+typeObj["entry"].icon, action : "javascript:dyFObj.openForm('entry')"},
                                { label : "action", classes:"col-xs-12 text-bold bg-"+typeObj["actions"].color, icon:"fa-"+typeObj["actions"].icon, action : "javascript:dyFObj.openForm('action')"},
                                { label : "classified", classes:"col-xs-12 text-bold bg-"+typeObj["classified"].color, icon:"fa-"+typeObj["classified"].icon, action : "javascript:dyFObj.openForm('classified')"},
                                { label : "Documentation", classes:"col-xs-12 text-white text-bold bg-red lbh", icon:"fa-book", action : "#default.view.page.index.dir.docs"},
                                { label : "Signaler un bug", classes:"col-xs-12 text-white text-bold bg-red lbh", icon:"fa-bug", action : "#news.index.type.pixels"},
                            ], "col_Link_Label_Count", { classes : "bg-red kickerBtn", parentClass : "col-xs-12 col-sm-6 "} )+"</div>";
                        }
                    }
                }
            }
        }   };