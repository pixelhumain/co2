<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-hide-section tooltips
        <?php if(@$element["onepageEdition"]["#".@$sectionKey]["hidden"] == "true") echo 'active'; ?>"
        data-original-title="masquer cette section" 
        data-id="#<?php echo @$sectionKey; ?>">
        <i class="fa fa-ban"></i>
</button>
<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-show-section tooltips
        <?php if(@$element["onepageEdition"]["#".@$sectionKey]["hidden"] != "true") echo 'active'; ?>"
        data-original-title="afficher cette section" 
        data-id="#<?php echo @$sectionKey; ?>">
        <i class="fa fa-eye"></i>
</button>
<br>
<span class="pull-right badge-info-section">
<?php if(@$element["onepageEdition"]["#".@$sectionKey]["hidden"] == "true"){ ?>
    <small class="badge letter-blue bg-white margin-right-15">
        <i class="fa fa-ban"></i> Cette section n'est pas visible pour les visiteurs de votre page
    </small>
<?php } ?>
</span>