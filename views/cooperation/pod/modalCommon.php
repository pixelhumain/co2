
<!-- ************ MODAL ASSIGN ACTION ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalAssignMe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close margin-5 padding-10" data-dismiss="modal" aria-label="Close">
        	<i class="fa fa-times"></i>
        </button>
        
        <div class="modal-title" id="modalText">
        	<h5 class="pull-left margin-top-15">
        	 <i class="fa fa-handshake-o"></i> Participer à une action
        	</h5>
        </div>
      </div>
      
       <div class="modal-body padding-15">
			<strong>Êtes-vous sûr de vouloir participer à cette action ?</strong><br>
	    	Vous serez inscrit dans la liste des participants.
      </div>

      <div class="modal-footer">
      	<button class="btn btn-success pull-right margin-left-10" data-dismiss="modal" id="btn-validate-assign-me">
      		<i class="fa fa-check"></i> Oui
      	</button>
      	<button class="btn btn-default pull-right" data-dismiss="modal">
      		<i class="fa fa-times"></i> Non
      	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- ************ MODAL DELETE AMENDEMENT ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteAm">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close margin-5 padding-10" data-dismiss="modal" aria-label="Close">
        	<i class="fa fa-times"></i>
        </button>
        
        <div class="modal-title" id="modalText">
        	<h5 class="pull-left margin-top-15">
        	 <i class="fa fa-trash"></i> Supprimer un amendement
        	</h5>
        </div>
      </div>
      
       <div class="modal-body padding-15">
			<strong>Êtes-vous sûr de vouloir supprimer votre amendement ?</strong><br>
	    	Toute suppression est définitive.
      </div>

      <div class="modal-footer">
      	<button class="btn btn-danger pull-right margin-left-10" 
      		data-id-am="" data-dismiss="modal" id="btn-delete-am">
      		<i class="fa fa-check"></i> Oui, supprimer
      	</button>
      	<button class="btn btn-default pull-right" data-dismiss="modal">
      		<i class="fa fa-times"></i> Non
      	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="modalLinkAction">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
            <div class="modal-header bg-green-k text-white">
                <h4 class="modal-title"><i class="fa fa-check"></i> <?php echo Yii::t("login","Assigner une personne") ?></h4>
            </div>
            <div class="modal-body center text-dark" style="height: 300px;">
              <div class="col-xs-12">
                <h5><i class="fa fa-angle-down"></i> Recherche</h5>
          <input type="text" class="form-control text-left" placeholder='<?php //echo Yii::t("invite", "A name, an e-mail..."); ?>' autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
          <div class="col-xs-12 no-padding" id="dropdown-search-invite" style="max-height: 400px; overflow: auto;"></div>
              </div>

              <div id="select" class="col-xs-12">
                <h5><i class="fa fa-angle-down"></i> Selectionner</h5>
          <span id="name"></span><br/>
          <span id="id"></span><br/>
          <div class="modal-footer">
            <button id="annule" type="button" class="btn btn-error letter-red" data-dismiss="modal"><i class="fa fa-check"></i> Annulez </button>
            <button id="validEligible" type="button" class="btn btn-default letter-green" data-dismiss="modal"><i class="fa fa-check"></i> Validez </button>
                </div>
              </div>
            </div>
           
        </div>
    </div>
</div>

<script type="text/javascript">

jQuery(document).ready(function() {
  $('#modalLinkAction #inviteSearch').keyup(function(e){
    var search = $('#modalLinkAction #inviteSearch').val();
    mylog.log("#modalLinkAction #inviteSearch", search);
    if(search.length>2){
      clearTimeout(timeout);
      timeout = setTimeout('autoCompleteInviteModalSwitchLink("'+encodeURI(search)+'")', 500); 
    }else{
      $("#modalLinkAction #dropdown-search-invite").hide();
      $("#modalLinkAction #form-invite").hide();
    }
  });

  $("#modalLinkAction #annule").off().on("click",function(){
    $("#modalLinkAction").modal("hide");
  });

    $("#modalLinkAction #validEligible").off().on("click",function(){

        console.log( $("#modalLinkAction #id").html(), $("#modalLinkAction #name").html());
        var ccc = { } ;


        ccc[$("#modalLinkAction #id").html()] = {
            name : $("#modalLinkAction #name").html()
        } ;
         

        var listInvite = { citoyens : ccc };

        var params = {
            parentId : actionId,
            parentType : "actions",
            listInvite : listInvite
        };

        $.ajax({
            type: "POST",
            url: baseUrl+'/'+moduleId+"/link/multiconnect",
            data: params,
            dataType: "json",
            success: function(data){
                mylog.log("autoCompleteInvite success", data);
                
                var isGood = false;
                var msg = "";
                $.each(data.citoyens, function(key, value){
                    if( value.result == true){
                        isGood = true;
                        msg = value.msg;
                    }else 
                        msg = value.msg;
                });


                console.log("HERE", "actions", actionId, "action", null, actionId);
                if( isGood == true){
                    toastr.success(msg);
                    // uiCoop.getCoopData("actions", actionId, "action", null, actionId, 
                    //     function(){
                    //         uiCoop.minimizeMenuRoom(true);
                    //         uiCoop.showAmendement(false);
                    //         toastr.success(trad["processing ok"]);
                    //     }, false);
                } else {
                    toastr.error(msg);
                }
                
            }
        });
    });
});

function autoCompleteInviteModalSwitchLink(search){
  mylog.log("autoCompleteInvite", search);
  if (search.length < 3) { return }

  var data = { 
    "search" : search,
    "searchMode" : "personOnly"
  };

  mylog.log("url", baseUrl+'/'+moduleId+"/search/multiconnect");
  $.ajax({
    type: "POST",
    url: baseUrl+'/'+moduleId+"/search/searchmemberautocomplete",
    data: data,
    dataType: "json",
    success: function(data){
      mylog.log("autoCompleteInvite success", data);
      showElementInvite(data);
      bindAdd2();
    }
  });
}

function showElementInvite(contactsList, invite=false, dropdown = "#dropdown-search-invite"){
  mylog.log("showElementInvite", contactsList, invite);
  mylog.log("showElementInvite length", Object.keys(contactsList.citoyens).length);
  //var dropdown = "#dropdown-search-invite";
  var listNotExits = true;
  var addRoles = {};
  var searchInContactsList=(dropdown=="#dropdown-mycontacts-invite") ? true : false;
  var str = "";
  if(invite == true){
    dropdown = "#dropdown-invite";
  }else if(!searchInContactsList){
    var str = "<div class='col-xs-12 no-padding'>"+
          "<div class='btn-scroll-type col-xs-12 not-find-inside padding-20'>"+
            "<a href='javascript:;' onclick='newInvitation()' class='col-xs-12 text-center'>"+trad.notfoundlaunchinvite+" !</a>"+
          "</div>"+
        "</div>";
  }
  if(notNull(contactsList.citoyens) && Object.keys(contactsList.citoyens).length ){
    // str += '<div class="col-xs-12 no-padding">'+
    //      '<h5 class="padding-10 text-yellow"><i class="fa fa-user"></i> '+trad.People+'<hr></h5>'+     
    //    '</div>';
    $.each(contactsList.citoyens, function(key, value){
      mylog.log("contactsList.citoyens key, value", key, value);
      str += htmlListInvite(key, value, invite, "citoyens", invite, searchInContactsList);
    });

    listNotExits = false;
  }

  mylog.log("showElementInvite end", dropdown);
  $("#modalLinkAction "+dropdown).html(str);
  $("#modalLinkAction "+dropdown).show();
  //bindAdd2();
}

function htmlListInvite(id, elem, invite, type, searchInContactsList){
  //( typeof elem.id != "undefined" ? elem.id : elem.email )
  mylog.log("htmlListInvite", id, elem, invite, type, searchInContactsList);
  var typeList = type ;
  if(type ==  "invites" )
    type = "citoyens";
  var profilThumbImageUrl = (typeof elem.profilThumbImageUrl != "undefined" && elem.profilThumbImageUrl != "") ? baseUrl + elem.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+type+".png";   
  var str = "<div class='col-xs-12 listInviteElement no-padding'>";
      str +="<div class='btn-scroll-type col-xs-12 add-invite' "+
          " data-id='"+id+"' "+
          'id="'+id+'AddList" '+
          'name="'+id+'AddList"'+
          " data-name='"+elem.name+"' "+
          " data-profilThumbImageUrl='"+profilThumbImageUrl+"' "+
          'data-type-list="'+typeList+'" ' +
          " data-type='"+type+"' >";
        str += '<img src="'+ profilThumbImageUrl+'" class="thumb-send-to col-xs-1 bg-yellow" height="35" width="35"> ';
      str += '<span class="text-dark text-bold name-invite col-xs-9 elipsis margin-top-15">' + elem.name ; 
      mylog.log("mailalal", typeList, elem.mail, (typeList == "invites" && typeof elem.mail != "undefined"));
      if(typeList == "invites" && typeof elem.mail != "undefined"){
        mylog.log("mailalal", typeList, elem.mail);
        str += ' <'+ elem.mail +'>';
      }

      str += '</span>';

    str += "</div>";
  str += "</div>";
  return str ;
}

function bindAdd2(){
  mylog.log("bindAdd2");
  $('#modalLinkAction .add-invite').click(function(e){
    mylog.log(".add-invite");
    var id = $(this).data("id");
    var name = $(this).data("name");
    mylog.log(".add-invite", id, name);
    $('#modalLinkAction #name').html(name);
    $('#modalLinkAction #id').html(id);

    $("#modalLinkAction #dropdown-search-invite").html("");
    $("#modalLinkAction #dropdown-search-invite").hide();

    $("#modalLinkAction #select").show();
  });
}

</script>