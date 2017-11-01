<?php 

	$cssAnsScriptFilesModule = array(
		'/js/news/autosize.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	function multiple10($nb, $total){ //error_log("multiple1000 : " . $nb. "  - ".$total);
		for($i=0;$i<$total;$i+=10){ 
			if($i==$nb) error_log( "multiple10 : " . $i);
			if($i==$nb) return true;
		}
		return false;
	}

?>	
<style>
	.textarea-new-comment{
		max-width: 100%;
		min-width: 100%;
		vertical-align: top;
		font-size:13px;
	}
	.textarea-new-comment:focus {
		outline-style: solid;
		outline-width: 1px;
		outline-color: grey;
	}
	.footer-comments{
		<?php if($contextType != "actionRooms" && $contextType != "surveys" && $contextType != "actions"){ ?>
		margin-right: -10px;
		margin-left: -10px;
		margin-top: -5px;
		padding: 10px;
		<?php } ?> 
		background-color: rgba(231, 231, 231, 0.62);
	}
	.content-comment{
		max-width:80%;
		min-height: 35px;
	}
	.answerCommentContainer {
	    margin-left: 45px;
	    margin-top: 5px;
	}
	
	.ctnr-txtarea{
		position: absolute;
		right:10px; 
		left:50px;
	}

	.answerCommentContainer .ctnr-txtarea{
		left:40px!important;
	}

	.content-comment .tool-action-comment{
		display: none;
	}
	.content-comment:hover .tool-action-comment{
		display: inherit;
	}
	.content-comment .fa-reply{
		font-size:14px;
		margin-right:5px;
		margin-left:5px;

	}
	.text-comment{
		white-space: pre-line;
	}
	.content-new-comment .mentions{
		padding: 10px 10px !important;
    	font-size: 13px !important;
	}
	.content-update-comment .mentions{
		padding: 9px 5px !important;
    	font-size: 14px !important;
	}
</style>
<?php if($contextType == "actionRooms"){ ?>
<div class='row'>
	<?php 
	  	$icon = (@$context["status"] == ActionRoom::STATE_ARCHIVED) ? "download" : "comments";
      	$archived = (@$context["status"] == ActionRoom::STATE_ARCHIVED) ? "<span class='text-small helvetica'>(ARCHIVED)</span>" : "";
      	$color = (@$context["status"] == ActionRoom::STATE_ARCHIVED) ? "text-red " : "text-dark";
    ?>
    <div class='col-md-8'>
		<h3 class=" <?php echo $color;?>" style="color:rgba(0, 0, 0, 0.8);">
	      <i class="fa fa-angle-right"></i> "<?php echo $context["name"].$archived; ?>"
	  	</h3>
	</div>

	<?php
		if($contextType == "actionRooms" && $context["type"] == ActionRoom::TYPE_DISCUSS){
			echo "<div class='col-md-4'>";
			/*$this->renderPartial('../pod/fileupload', array("itemId" => (string)$context["_id"],
				  "type" => ActionRoom::COLLECTION,
				  "resize" => false,
				  "contentId" => Document::IMG_PROFIL,
				  "editMode" => $canComment,
				  "image" => $images,
				   "parentType" => $parentType,
				   "parentId" => $parentId, 
			)); */
		}
		echo "</div>";
	
    ?>
</div>
<?php } ?>


<div class="footer-comments row">

	<?php //image profil user connected + input new comment
		$profilThumbImageUrlUser = ""; 

		if(isset(Yii::app()->session["userId"])){
			$me = Person::getMinimalUserById(Yii::app()->session["userId"]);
			$profilThumbImageUrlUser = Element::getImgProfil($me, "profilThumbImageUrl", $this->module->assetsUrl); 
	?>

			
			<div class="col-md-12 col-sm-12 col-xs-12 no-padding margin-top-15 container-txtarea">
				<img src="<?php echo $profilThumbImageUrlUser; ?>" class="img-responsive pull-left" 
					 style="margin-right:6px;height:32px; border-radius:3px;">

				<div id="container-txtarea-<?php echo $idComment; ?>" class="content-new-comment">
					<div style="" class="ctnr-txtarea">
						<textarea rows="1" style="height:1em;" class="form-control textarea-new-comment" 
								  id="textarea-new-comment<?php echo $idComment; ?>" placeholder="<?php echo Yii::t("common","Your comment") ?>..."></textarea>
						<input type="hidden" id="argval" value=""/>
					</div>
				</div>
			</div>
	<?php } ?>

	<div id="comments-list-<?php echo $idComment; ?>">

		<?php 
			$assetsUrl = $this->module->assetsUrl;
			function showCommentTree($comments, $assetsUrl, $idComment, $canComment, $level, $parentType=null){
				$count = 0;
				$hidden = 0;
				$hiddenClass = "";
				$nbTotalComments = sizeOf($comments);

				if($nbTotalComments == 0 && $level == 1) { echo Yii::t("comment", "No comment"); }
				if($nbTotalComments == 0) return;
				//if($nbTotalComments == 0 && $level == 2) echo "Aucune commentaire";

		 		
				foreach ($comments as $key => $comment) { 
			 		$count++; 
					$profilThumbImageUrl = Element::getImgProfil($comment["author"], "profilThumbImageUrl", $assetsUrl); 
					if($hidden > 0) $hiddenClass = "hidden hidden-".$hidden;
					
					$classArgument = "";
					if(@$comment["argval"] == "up") $classArgument = "bg-green-comment";
					if(@$comment["argval"] == "down") $classArgument = "bg-red-comment";
					if(@$comment["argval"] == "") $classArgument = "bg-white-comment";
		?>
					<div class="col-xs-12 no-padding margin-top-5 item-comment <?php echo $hiddenClass.' '.$classArgument; ?>" 
						 id="item-comment-<?php echo $comment["_id"]; ?>">

						<img src="<?php echo $profilThumbImageUrl; ?>" class="img-responsive pull-left" 
							 style="margin-right:10px;height:32px; border-radius:3px;">
					
						<span class="pull-left content-comment">						
							<span class="text-black">
								<span class="text-dark"><strong><?php echo $comment["author"]["name"]; ?></strong></span> 
								<span class="text-comment <?php echo (@$comment['reportAbuseCount']&&$comment['reportAbuseCount']>=5)?'text-red-light-moderation':'' ?>" data-id="<?php echo $comment["_id"]; ?>" 
									<?php if(@$comment["parentId"]) echo "data-parent-id='".$comment["parentId"]."'"; ?>>
									<?php echo $comment["text"]; ?>
								</span>
							</span><br>
							<small class="bold">
							<?php if(isset(Yii::app()->session["userId"])){ ?>
								 
								<?php if(@$canComment){ ?>
								<?php 
									$lblReply = Yii::t("common","Answer");
									if(sizeOf($comment["replies"])==1) $lblReply = "<i class='fa fa-reply fa-rotate-180'></i>" . sizeOf($comment["replies"])." ".Yii::t("comment","answer");
									if(sizeOf($comment["replies"])>1) $lblReply = "<i class='fa fa-reply fa-rotate-180'></i>" . sizeOf($comment["replies"])." ".Yii::t("comment","answers");
								?>
									<a class="" href="javascript:answerComment('<?php echo $idComment; ?>', '<?php echo $comment["_id"]; ?>','<?php echo $comment["contextType"]; ?>')"><?php echo $lblReply; ?></a> 
								<?php } ?>
								<?php 
									$myId = Yii::app()->session["userId"]; $iVoted = "";
									$voteUpCount = @$comment['voteUpCount'] ? $comment['voteUpCount'] : 0;
									$voteDownCount = @$comment['voteDownCount'] ? $comment['voteDownCount'] : 0;
									$reportAbuseCount = @$comment['reportAbuseCount'] ? $comment['reportAbuseCount'] : 0;
									if(@$comment['voteUp']) foreach (@$comment['voteUp'] as $key => $value) { if($key == $myId) $iVoted = "up"; }
									if(@$comment['voteDown']) foreach (@$comment['voteDown'] as $key => $value) { if($key == $myId) $iVoted = "down"; }
									if(@$comment['reportAbuse']) foreach (@$comment['reportAbuse'] as $key => $value) { if($key == $myId) $iVoted = "abuse"; }
								?>
									<a style="margin-left:5px;margin-right:5px;" href="javascript:"
										class="tooltips commentVoteUp <?php echo $iVoted=='up' ? 'text-green' : ''; ?>"
										data-voted="<?php echo $iVoted!='' ? 'true' : 'false'; ?>"
										data-id="<?php echo $comment["_id"]; ?>" data-countcomment="<?php echo $voteUpCount; ?>"
										data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","I like") ?>">
										<span class="countC"><?php echo @$voteUpCount; ?></span> 
										<i class='fa fa-thumbs-up'></i>
									</a> 
									<a  href="javascript:"
										class="tooltips commentVoteDown <?php echo $iVoted=='down' ? 'text-orange' : ''; ?>"
										data-voted="<?php echo $iVoted!='' ? 'true' : 'false'; ?>"
										data-id="<?php echo $comment["_id"]; ?>" data-countcomment="<?php echo @$voteDownCount; ?>"
										data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","I don't like") ?>">
										<span class="countC"><?php echo @$voteDownCount; ?></span> 
										<i class='fa fa-thumbs-down'></i>
									</a>
									
									<?php if($reportAbuseCount > 1){ ?>
									<a style="margin-left:5px; margin-right:5px;" href="javascript:"
										class="tooltips commentReportAbuse <?php echo $iVoted=='abuse' ? 'text-red' : 'text-red-light'; ?>"
										data-voted="<?php echo $iVoted!='' ? 'true' : 'false'; ?>"
										data-id="<?php echo $comment["_id"]; ?>" data-countcomment="<?php echo @$reportAbuseCount; ?>"
										data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Declare an abuse") ?>">
										<span class="countC"><?php echo $reportAbuseCount; ?></span> 
										<i class='fa fa-flag'></i>
									</a>
									<?php } ?>
									<div class="tool-action-comment">

										<?php if($reportAbuseCount <= 1){ ?>
										<a style="margin-left:5px; margin-right:5px;" href="javascript:"
											class="tooltips commentReportAbuse <?php echo $iVoted=='abuse' ? 'text-red' : $reportAbuseCount >= 1 ? 'text-red-light' : ''; ?>"
											data-voted="<?php echo $iVoted!='' ? 'true' : 'false'; ?>"
											data-id="<?php echo $comment["_id"]; ?>" data-countcomment="<?php echo @$reportAcommentbuseCount; ?>"
											data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Declare an abuse") ?>">
											<span class="countC"><?php echo $reportAbuseCount; ?></span> 
											<i class='fa fa-flag'></i>
										</a>
										<?php } ?>
										
										<?php if(@$comment["author"]["id"] == Yii::app()->session["userId"]){ ?>
											<a style="margin-left:5px; margin-right:5px;"  class="tooltips"
											   data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Update") ?>"
											   href="javascript:editComment('<?php echo $comment["_id"]; ?>')"><i class='fa fa-pencil'></i>
											</a>
											<a class="tooltips"
											   data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Delete") ?>"
											   href="javascript:confirmDeleteComment('<?php echo $comment["_id"]; ?>',$(this))"><i class='fa fa-times'></i>
											</a>				
										<?php } ?>

									</div>

							<?php } ?>
							</small>
						</span>
						<div id="comments-list-<?php echo $comment["_id"]; ?>" class="hidden pull-left col-md-11 col-sm-11 col-xs-11 no-padding answerCommentContainer">
							<?php if(sizeOf($comment["replies"]) > 0) //recursive for answer (replies)
									showCommentTree($comment["replies"], $assetsUrl, $comment["_id"], $canComment, $level+1, $comment["contextType"]);  ?>
						</div>
					</div>
		<?php 		if(multiple10($count, $nbTotalComments)){ $hidden = $count; ?>
		<?php			$hiddenClass = ($hidden > 10) ? "hidden hidden-".($hidden-10) : ""; ?>
						<div class="pull-left margin-top-5 <?php echo $hiddenClass; ?> link-show-more-<?php echo ($hidden-10); ?>">
							<a class="" href="javascript:" onclick="showMoreComments('<?php echo $idComment; ?>', <?php echo $hidden; ?>);">
								<i class="fa fa-angle-down"></i> <?php echo Yii::t("comment","Show more comments") ?>
							</a>
						</div>
		<?php 		} //if (multiple10 ?>

		

		<?php 	} //$.each ?>
		<?php 	if($hidden > 0){ ?>
					<div class="pull-right margin-top-5">
						<a class="" href="javascript:" onclick="hideComments('<?php echo $idComment; ?>', <?php echo $level; ?>);">
							<i class="fa fa-angle-up"></i> Masquer
						</a>
					</div>
		<?php 	} ?>
		<?php	}//function()
		?>

		<?php showCommentTree($comments, $assetsUrl, $idComment, $canComment, 1, $contextType); ?>
					
	</div><!-- id="comments-list-<?php echo $idComment; ?>" -->

</div><!-- class="footer-comments" -->

<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->

<script type="text/javascript" >
	var contextType = "<?php echo $contextType; ?>";
	var idComment = "<?php echo $idComment; ?>";
	var comments = <?php echo json_encode($comments); ?>;
	
	var context = <?php echo json_encode($context)?>;

	var profilThumbImageUrlUser = "<?php echo @$profilThumbImageUrlUser; ?>";
	var isUpdatedComment=false;
	// mylog.log("context");
	// mylog.dir(context);
	// mylog.log("comments");
	// mylog.dir(comments);

	jQuery(document).ready(function() {

		var idTextArea = '#textarea-new-comment<?php echo $idComment; ?>';
		bindEventTextArea(idTextArea, idComment, contextType, false, "");
		bindEventActions();

		mylog.log(".comments-list-<?php echo $idComment; ?> .text-comment");
		$("#comments-list-<?php echo $idComment; ?> .text-comment").each(function(){
			idComment=$(this).data("id");
			idParent=$(this).data("parent-id");
			textComment=$(this).html();
			if(typeof idParent != "undefined"){
				comments[idComment]=comments[idParent].replies[idComment];
			}
			/*if(typeof idParent != "undefined"){
				if(typeof(comments[idParent].replies[idComment].mentions) != "undefined"){
	          		textComment = mentionsInit.addMentionInText(textComment,comments[idParent].replies[idComment].mentions);
	        	}
			}else{*/
				if(typeof(comments[idComment].mentions) != "undefined"){
	          		textComment = mentionsInit.addMentionInText(textComment,comments[idComment].mentions);
	        	}
	        //}
			textComment = linkify(textComment);
			$(this).html(textComment);
		});
		/*$.each(comments, function(e,v){
			textComment=v.text;
          	//Check if @mentions return text with link
        	if(typeof(v.mentions) != "undefined"){
        		alert();
          		textComment = mentionsInit.addMentionInText(textComment,v.mentions);
        	}
        	alert(textComment);
        	textComment=linkify(textComment);
       		$("#comments-list-"+e+" .text-comment").html(textComment);
		});*/
	});

	

	function bindEventActions(){

		$('.commentVoteUp').off().on("click",function(){
			id=$(this).data("id");
			mylog.log("thisData voted : ",  $(this).data("voted"));
			//if($(this).data("voted")=="true") 
			//	alert(typeof $(this).data("voted"));
			if((!$(this).hasClass("text-green") && $(this).data("voted")==true)){
				if($(".commentReportAbuse[data-id='"+id+"']").hasClass("text-red")){
					toastr.info("<?php echo Yii::t("common", "You can't make any actions on this comment after reporting abuse !") ?>");
				}
				else{
					toastr.info("<?php echo Yii::t("common", "Remove your last opinion before") ?>");
				}
			}else{
				method= $(this).hasClass("text-green");
				actionOnComment($(this),'<?php echo Action::ACTION_VOTE_UP ?>', method);
				disableOtherAction(id, '.commentVoteUp',method);
			}
		});
		$('.commentVoteDown').off().on("click",function(){
			id=$(this).data("id");
			if((!$(this).hasClass("text-orange") && $(this).data("voted")==true)){
				if($(".commentReportAbuse[data-id='"+id+"']").hasClass("text-red")){
					toastr.info("<?php echo Yii::t("common", "You can't make any actions on this comment after reporting abuse !") ?>");
				}
				else{
					toastr.info("<?php echo Yii::t("common", "Remove your last opinion before") ?>");
				}
			}else{	
				method= $(this).hasClass("text-orange");
				actionOnComment($(this),'<?php echo Action::ACTION_VOTE_DOWN ?>', method);
				disableOtherAction(id, '.commentVoteDown', method);
			}
		});

		//Abuse process
		$('.commentReportAbuse').off().on("click",function(){
			id=$(this).data("id");
			if($(this).data("voted")=="true")
				toastr.info("<?php echo Yii::t("common", "Remove your last opinion before") ?>");
			else{	
				if($(".commentVoteUp[data-id='"+id+"']").hasClass("text-green") || $(".commentVoteDown[data-id='"+id+"']").hasClass("text-orange")){
					toastr.info("<?php echo Yii::t("common", "You can't make any actions on this comment after reporting abuse !") ?>");
				}
				else{
					reportAbuse($(this), $(this).data("contextid"));
				}
			}
		});
		$('.deleteComment').off().on("click",function(){
			actionAbuseComment($(this), "<?php echo Comment::STATUS_DELETED ?>", "");
		});
	}
	

	function showOneComment(textComment, idComment, isAnswer, idNewComment, argval, mentionsArray){
		console.log(mentionsArray);
		if(notNull(mentionsArray)){
			textComment = mentionsInit.addMentionInText(textComment,mentionsArray);
		}
		textComment = linkify(textComment);
		var classArgument = "";
		if(argval == "up") classArgument = "bg-green-comment";
		if(argval == "down") classArgument = "bg-red-comment";
		if(argval == "") classArgument = "bg-white-comment";

		var html = '<div class="col-xs-12 no-padding margin-top-5 item-comment '+classArgument+'" id="item-comment-'+idNewComment+'">'+

						'<img src="<?php echo @$profilThumbImageUrlUser; ?>" class="img-responsive pull-left" '+
						'	 style="margin-right:10px;height:32px; border-radius:3px;">'+
					
						'<span class="pull-left content-comment">'+						
						'	<span class="text-black">'+
						'		<span class="text-dark"><strong><?php echo @$me["name"]; ?></strong></span><br>'+
						'		<span class="text-comment">'	+ textComment + "</span>" +
						'	</span><br>'+
							'<small class="bold">' +
								<?php if(@$canComment){ ?>
							'		<a class="" href=\'javascript:answerComment(\"<?php echo $idComment; ?>\", \"'+idNewComment+'\", \"'+contextType+'\")\'>'+trad.answer+'</a> '+
								<?php } ?> 
								<?php if(isset(Yii::app()->session["userId"])){ ?>

							'		<a class="tooltips commentVoteUp" style="margin-left:5px;margin-right:5px;"'+
							'			    class="tooltips commentVoteUp"'+
							'				data-voted="false"'+
							'				data-id="'+idNewComment+'" data-countcomment="0"	' +
							'				data-toggle="tooltip" data-placement="top" title="'+trad.ilike+'"'+
							'				href="javascript:">0 <i class="fa fa-thumbs-up"></i></a> ' +

							'		<a class="tooltips commentVoteDown"'+
							'			   	data-voted="false"'+
							'				data-id="'+idNewComment+'" data-countcomment="0"	' +
							'				data-toggle="tooltip" data-placement="top" title="'+trad.idontlike+'"'+
							'			  	href="javascript:">0 <i class="fa fa-thumbs-down"></i></a> ' +
							
							'<div class="tool-action-comment">' +
							'		<a class="tooltips commentReportAbuse" style="margin-left:5px;margin-right:5px;"'+
							'			   	data-voted="false"'+
							'				data-id="'+idNewComment+'" data-countcomment="0"	' +
							'				data-toggle="tooltip" data-placement="top" title="'+trad.declareabuse+'"'+
							'			  	href="javascript:">0 <i class="fa fa-flag"></i></a> '+
									
							'		<a style="margin-left:5px; margin-right:5px;"  class="tooltips"'+
							'			   data-toggle="tooltip" data-placement="top" title="'+trad.edit+'"'+
							'			   href=\'javascript:editComment(\"'+idNewComment+'\")\'><i class="fa fa-pencil"></i></a>'+

							'		<a class="tooltips"'+
							'			   data-toggle="tooltip" data-placement="top" title="'+trad.delete+'"'+
							'			   href=\'javascript:confirmDeleteComment(\"'+idNewComment+'\", $(this))\'><i class="fa fa-times"></i></a>'+
							'</div>' +
							//'			<a class="" href=\'javascript:deleteComment(\"'+idNewComment+'\")\'>Supprimer</a> '+
							//'			<a class="" href=\'javascript:modifyComment(\"'+idNewComment+'\")\'>Modifier</a>'+
								<?php } ?>
							'</small>'+
						'</span>'+	
						'<div id="comments-list-'+idNewComment+'" class="hidden pull-left col-md-11 no-padding answerCommentContainer"></div>' +
							
					'</div>';

		if(!isAnswer){
			$("#comments-list-<?php echo $idComment; ?>").prepend(html);
		}else{
			$('#container-txtarea-'+idComment).after(html);
		}
	}

	

	function saveComment(textComment, parentCommentId, domElement){
		textComment = $.trim(textComment);
		if(!notEmpty(parentCommentId)) parentCommentId = "";
		if(textComment == "") {
			toastr.error("<?php echo Yii::t("comment","Your comment is empty") ?>");
			return;
		}

		var argval = $("#argval").val();
		newComment={
			parentCommentId: parentCommentId,
			text : textComment,
			contextId : context["_id"]["$id"],
			contextType : contextType,
			argval : argval
		};
		newComment=mentionsInit.beforeSave(newComment, domElement);
		$.ajax({
			url: baseUrl+'/'+moduleId+"/comment/save/",
			data: newComment,
			type: 'post',
			global: false,
			dataType: 'json',
			success: 
				function(data) {
					if(!data.result){
						toastr.error(data.msg);
					}
					else { 
						toastr.success(data.msg);
						var count = $("#newsFeed"+context["_id"]["$id"]+" .nbNewsComment").html();
						
						if(!notEmpty(count)) count = 0;
						//mylog.log(count, context["_id"]["$id"]);
						comments[data.id.$id]=data.newComment;
						if(data.newComment.contextType=="news"){
							mentionsInit.reset(domElement);
							count = parseInt(count);
							var newCount = count +1;
							var labelCom = (newCount>1) ? trad.comments : trad.comment;
							$("#newsFeed"+context["_id"]["$id"]+" .lblComment").html("<i class='fa fa-comment'></i> <span class='nbNewsComment'>"+newCount+"</span> "+labelCom);
							$("#newsFeed"+context["_id"]["$id"]+" .newsAddComment").data('count', newCount);
						// }else{
						// 	$("#newsFeed"+context["_id"]["$id"]+" .lblComment").html("<i class='fa fa-comment'></i> <span class='nbNewsComment'>1</span> commentaire");
						// 	$("#newsFeed"+context["_id"]["$id"]+" .newsAddComment").data('count', 1);
						}
						
						// $('.nbComments').html((parseInt($('.nbComments').html()) || 0) + 1);
						// if (data.newComment.contextType=="news"){
						// 	$(".newsAddComment[data-id='"+data.newComment.contextId+"']").children().children(".nbNewsComment").text(parseInt($('.nbComments').html()) || 0);
						// }
						//switchComment(commentId, data.newComment, parentCommentId);
						latestComments = data.time;

						var isAnswer = parentCommentId!="";
						mentionsArray=null;
						if(typeof data.newComment.mentions != "undefined"){
							mentionsArray=data.newComment.mentions;
						}
						showOneComment(data.newComment.text, parentCommentId, isAnswer, data.id.$id, argval, mentionsArray);   
						bindEventActions();    
					}
				},
			error: 
				function(data) {
					toastr.error('<?php echo Yii::t("comment","Error calling the serveur : contact your administrator.") ?>');
				}
		});
		
	}



	function reportAbuse(comment, contextId) {
		// mylog.log(contextId);
		var message = "<div id='reason' class='radio'>"+
			"<h3 class='margin-top-10'>Pour quelle raison signalez-vous ce contenu ?</h3>" +
			"<hr>" +
			"<label><input type='radio' name='reason' value='Propos malveillants' checked>Propos malveillants</label><br>"+
			"<label><input type='radio' name='reason' value='Incitation et glorification des conduites agressives'>Incitation et glorification des conduites agressives</label><br>"+
			"<label><input type='radio' name='reason' value='Affichage de contenu gore et trash'>Affichage de contenu gore et trash</label><br>"+
			"<label><input type='radio' name='reason' value='Contenu pornographique'>Contenu pornographique</label><br>"+
		  	"<label><input type='radio' name='reason' value='Liens fallacieux ou frauduleux'>Liens fallacieux ou frauduleux</label><br>"+
		  	"<label><input type='radio' name='reason' value='Mention de source erronée'>Mention de source erronée</label><br>"+
		  	"<label><input type='radio' name='reason' value='Violations des droits auteur'>Violations des droits d\'auteur</label><br><br>"+
		  	"<input type='text' class='form-control' style='text-align:left;' id='reasonComment' placeholder='Laisser un commentaire...'/><br>"+
		  	"Votre signalement sera envoyé aux administrateurs du réseau,<br> qui le traiteront conformément aux <a href='javascript:'>conditions d'utilisations</a><br>" + 
			"<span class='text-red'><i class='fa fa-info-circle'></i> Tout signalement est définitif, vous ne pourrez pas l'annuler</span><br>" +
			"<hr>" +
			"<span class=''><i class='fa fa-arrow-right'></i> Le contenu sera signalé par un <i class='fa fa-flag text-red'></i> s'il fait l'objet d'au moins 2 signalements</span><br>" +
			"<span class='text-red-light'><i class='fa fa-arrow-right'></i> Le contenu sera masqué s'il fait l'objet d'au moins 5 signalements</span><br>" +
			"<span class=''><i class='fa fa-arrow-right'></i> Le contenu sera supprimé par les administrateurs s'il enfreint les conditions d'utilisations</span>" +
			"</div>";
		var boxComment = bootbox.dialog({
		  message: message,
		  //title: '<?php echo Yii::t("comment","You are going to declare this comment as abuse : please fill the reason ?") ?>',
		  title: '<span class="text-red"><i class="fa fa-flag"></i> <?php echo Yii::t("comment","Signaler un abus") ?>',
		  buttons: {
		  	annuler: {
		      label: "Annuler",
		      className: "btn-default",
		      callback: function() {
		        mylog.log("Annuler");
		      }
		    },
		    danger: {
		      label: "Envoyer le signalement",
		      className: "btn-danger",
		      callback: function() {
		      	// var reason = $('#reason').val();
		      	var reason = $("#reason input[type='radio']:checked").val();
		      	var reasonComment = $("#reasonComment").val();
		      	actionAbuseComment(comment, "<?php echo Action::ACTION_REPORT_ABUSE ?>", reason, reasonComment);
				disableOtherAction(comment.data("id"), '.commentReportAbuse');
				//copyCommentOnAbuseTab(comment);
				return true;
		      }
		    },
		  }
		});

		boxComment.on("shown.bs.modal", function() {
		  $.unblockUI();
		});

		boxComment.on("hide.bs.modal", function() {
		  $.unblockUI();
		});
	}

	function actionAbuseComment(comment, action, reason, reasonComment) {
		$.ajax({
			url: baseUrl+'/'+moduleId+"/action/addaction/",
			data: {
				id: comment.data("id"),
				collection : '<?php echo Comment::COLLECTION?>',
				action : action,
				reason : reason,
				comment : reasonComment
			},
			type: 'post',
			global: false,
			dataType: 'json',
			success: 
				function(data) {
	    			if(!data.result){
	                    toastr.error(data.msg);
	               	}
	                else { 
	                    if (data.userAllreadyDidAction) {
	                    	toastr.info('<?php echo Yii::t("comment","You already declare this comment as abused.") ?>');
	                    } else {
		                    toastr.success(data.msg);
		                    if (action == "<?php echo Action::ACTION_REPORT_ABUSE ?>") {
			                    count = parseInt(comment.data("count"));
								comment.data( "count" , count+1 );
								icon = comment.children(".label").children(".fa").attr("class");
								comment.children(".label").html(comment.data("count")+" <i class='"+icon+"'></i>");
							} else {
								$('.abuseCommentTable #comment'+comment.data("id")).remove();
								//abusedComments[comment.data("id")]
								$('.nbCommentsAbused').html((parseInt($('.nbCommentsAbused').html()) || 0) -1);
							}
						}
	                }
	            },
	        error: 
	        	function(data) {
	        		toastr.error('<?php echo Yii::t("comment","Error calling the serveur : contact your administrator.") ?>');
	        	}
			});
	}



	function actionOnComment(comment, action, method) {
		mylog.log(comment);
		params=new Object,
		params.id = comment.data("id"),
		params.collection = '<?php echo Comment::COLLECTION?>',
		params.action = action;
		if(method){
			params.unset=method;
		}
		$.ajax({
			url: baseUrl+'/'+moduleId+"/action/addaction/",
			data: params,
			type: 'post',
			global: false,
			dataType: 'json',
			success: 
				function(data) {
	    			if(!data.result){
	                    toastr.error(data.msg);
	               	}
	                else { 
	                    if (data.userAllreadyDidAction) {
	                    	toastr.info("You already vote on this comment.");
	                    } else {
							count = parseInt(comment.data("count"));
		                    if(action=="reportAbuse"){
								toastr.success(trad["thanktosignalabuse"]);

								//to hide menu
								$(".newsReport[data-id="+params.id+"]").hide();
							}
							else{ mylog.log("dataINC:", data);
			                    if(data.inc>=1)
			                    	toastr.success("<?php echo Yii::t("common", "Your vote has been successfully added") ?>");
			                    else
									toastr.success("<?php echo Yii::t("common","Your vote has been successfully removed") ?>");	 
							}                   
		                   // toastr.success(data.msg);

							comment.data( "count" , count+data.inc );
							icon = comment.children(".label").children(".fa").attr("class");
							comment.children(".label").html(comment.data("count")+" <i class='"+icon+"'></i>");
						}
	                }
	            },
	        error: 
	        	function(data) {
	        		toastr.error("Error calling the serveur : contact your administrator.");
	        	}
			});
	}



	function confirmDeleteComment(id, $this){
		// mylog.log(contextId);
		var message = "<?php echo Yii::t("comment","Do you want to delete this comment") ?> ?";
		var boxComment = bootbox.dialog({
		  message: message,
		  title: '<?php echo Yii::t("comment","You are going to delete this comment : are your sure ?") ?>', //Souhaitez-vous vraiment supprimer ce commentaire ?
		  buttons: {
		  	annuler: {
		      label: trad.cancel,
		      className: "btn-default",
		      callback: function() {
		        mylog.log("Annuler");
		      }
		    },
		    danger: {
		      label: trad.delete,
		      className: "btn-primary",
		      callback: function() {
		      	deleteComment(id,$this);
				return true;
		      }
		    },
		  }
		});

		boxComment.on("shown.bs.modal", function() {
		  $.unblockUI();
		});

		boxComment.on("hide.bs.modal", function() {
		  $.unblockUI();
		});
	}

	function deleteComment(id,$this){
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/comment/delete/id/"+id,
			dataType: "json",
			//data: {"newsId": idNews},
	    	success: function(data){
	        	if (data.result) {    
		        	mylog.log(data);           
					toastr.success("<?php echo Yii::t("common","Comment successfully deleted")?>");
					//liParent=$this.parents().eq(2);
		        	//liParent.fadeOut();
		        	$("#item-comment-"+id).html("");
		        	$('.nbComments').html((parseInt($('.nbComments').html()) || 0) - 1);
		        	if (data.comment.contextType=="news"){
							$(".newsAddComment[data-id='"+data.comment.contextId+"']").children().children(".nbNewsComment").text(parseInt($('.nbComments').html()) || 0 );
						}
				} else {
		            toastr.error("Quelque chose a buggé"); //j'adore cette alert ;) !
		        }
		    }
		});
	}

	function editComment(idComment){
		// mylog.log(contextId);
		isUpdatedComment=true;
		var commentContent = comments[idComment].text;
		var message = "<div id='container-txtarea-"+idComment+"' class='content-update-comment'>"+
						"<textarea id='textarea-new-comment"+idComment+"' class='form-control' placeholder='"+trad.modifyyourcomment+"'>"+commentContent+
						"</textarea>"+
					  "</div>";
		var boxComment = bootbox.dialog({
		  message: message,
		  title: '<?php echo Yii::t("comment","Update your comment"); ?>', //Souhaitez-vous vraiment supprimer ce commentaire ?
		  buttons: {
		  	annuler: {
		      label: trad.cancel,
		      className: "btn-default",
		      callback: function() {
		      	isUpdatedComment=false;
		      }
		    },
		    enregistrer: {
		      label: trad.save,
		      className: "btn-success",
		      callback: function() {
		      	updateComment(idComment,$("#textarea-new-comment"+idComment).val(), "#textarea-new-comment"+idComment);
				isUpdatedComment=false;
				return true;
		      }
		    },
		  }
		});

		boxComment.on("shown.bs.modal", function() {
		  $.unblockUI();
		  bindEventTextArea('#textarea-new-comment'+idComment, idComment, contextType, false, "", comments[idComment]);
		});

		boxComment.on("hide.bs.modal", function() {
		  $.unblockUI();
		});
	}



</script>