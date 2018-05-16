dynform = { 
        dynForm : {
            jsonSchema : {
                title : "Theme Switcher ?",
                icon : "question-cirecle-o",
                noSubmitBtns : true,
                properties : {
                    custom :{
                        inputType : "custom",
                        html : function() { 
                            return "<div class='menuSmallMenu'>"+js_templates.loop( [ 
                                { label : "ph dori", classes:"bg-dark", icon:"fa-bullseye", action : "javascript:window.location.href = moduleId+'?theme=ph-dori'"},
                                { label : "notragora", classes:"bg-grey", icon:"fa-video-camera ", action : "javascript:window.location.href = moduleId+'?theme=notragora'"},
                                { label : "C02", classes:"bg-red", icon:"fa-search", action : "javascript:window.location.href = moduleId+'?theme=CO2'"},
                                { label : "network", classes:"bg-orange", icon:"fa-bars", action : "javascript:window.location.href = moduleId+'?theme=network'"},
                                
                            ], "col_Link_Label_Count", { classes : "bg-red kickerBtn", parentClass : "col-xs-12 col-sm-4 "} )+"</div>";
                        }
                    }
                }
            }
        }   };