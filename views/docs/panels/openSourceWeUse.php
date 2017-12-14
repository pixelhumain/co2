<?php $this->renderPartial('../docs/panels/menuLink',array("url"=>"default/view/page/links")); ?>
<div class="panel-heading border-light center text-dark partition-white radius-10">
	<span class="panel-title homestead"> <i class='fa text-red fa-heart  faa-pulse animated fa-3x  '></i> <span style="font-size: 48px">OPEN SOURCE PROJECTS WE LOVE AND USE</span></span>
</div>
<div class="space20"></div>
<div class="keywordList col-xs-12"></div>

<script type="text/javascript">

var keywords = [
{
        "project" : "Yii PHP Framework",
        "url" : "http://www.yiiframework.com",
        "comment" : "Yii is a high-performance PHP framework best for developing Web 2.0 applications Yii comes with rich features: MVC, DAO/ActiveRecord, I18N/L10N, caching, authentication and role-based access control, scaffolding, testing, etc. It can reduce your development time significantly.",
        "image" : "https://www.javatpoint.com/yii/images/yii-framework.jpg"
    },
    {
        "project" : "Mongo DB",
        "url" : "https://www.mongodb.com/fr",
        "comment" : "Réinventons la gestion de l’information, Devenez plus rapide et évolutif grâce à MongoDB, la première base de données NoSQL",
        "image" : "https://webassets.mongodb.com/_com_assets/cms/MongoDB-Logo-5c3a7405a85675366beb3a5ec4c032348c390b3f142f5e6dddf1d78e2df5cb5c.png"
    },
    {
        "project" : "JQuery",
        "url" : "https://jquery.com/",
        "comment" : "jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.",
        "image" : "https://blog.netapsys.fr/wp-content/uploads/2016/07/jquery.gif"
    },
     {
        "project" : "Bootstrap",
        "url" : "http://getbootstrap.com/",
        "comment" : "Build responsive, mobile-first projects on the web with the world's most popular front-end component library.Bootstrap is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or build your entire app with our Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful plugins built on jQuery.",
        "image" : "http://getbootstrap.com/assets/img/bootstrap-stack.png"
    },

    
    
];

jQuery(document).ready(function() 
{
    $(".keywordList").html('');
    $.each(keywords,function(i,obj) { 
        icon = (obj.icon) ? obj.icon : "fa-tag" ;
        color = (obj.color) ? obj.color : "#E33551" ;
        $(".keywordList").append(
        '<div class="col-xs-3"><div class="keypan panel panel-white">'+
            '<div class="panel-heading border-light ">'+
                '<span class="panel-title ">'+
                '<img class="img-circle" width="50" height="50" src="'+obj.image+'"/> '+
                        '<a href="'+obj.url+'" target="_blank" style="font-size: 18px; "><br/>'+obj.project.toUpperCase()+'</a>'+
                        '<span style="font-size: 14px; "><br/>'+obj.comment+'</span>'+
                        '</span>'+
            '</div></div></div>');
     });
});

</script>

