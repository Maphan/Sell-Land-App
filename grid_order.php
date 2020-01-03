<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
.glyphicon { margin-right:5px; }
.thumbnail
{
    margin-bottom: 10px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.list-group-item-text
{
    margin: 0 0 11px;
}
	.box-img{
		display: table;
		align-items: center;
		vertical-align: middle;
	}
/*------------------- List ----------------*/
.box_oder-list .list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.box_oder-list .list-group-item:nth-of-type(odd):hover,.box_oder-list .list-group-item:hover
{
    background: #428bca;
}

.box_oder-list .list-group-item .list-group-image
{
    margin-right: 10px;
}
.box_oder-list .list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.box_oder-list .list-group-item .caption
{
    padding: 9px 9px 0px 250px;
}
.box_oder-list .list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}

.box_oder-list .list-group-item:before, .box_oder-list .list-group-item:after
{
    display: table;
    content: " ";
}

.box_oder-list .list-group-item img
{
    float: left;
	height: auto;
	width: 100%;
	max-width: 220px;
	max-height: 220px;
}
.box_oder-grid #box_img{
	width: 100%;
	height: 220px;
	vertical-align: middle;
}
.box_oder-list .list-group-item:after
{
    clear: both;
}
/*------------------- Grid ----------------*/
.box_oder-grid .list-group-item
{

}
.box_oder-grid .list-group-item:nth-of-type(odd):hover,.box_oder-grid .list-group-item:hover
{
    
}

.box_oder-grid .list-group-item .list-group-image
{
	width: 100%;
	height: auto;

}
.box_oder-grid .list-group-item .thumbnail
{
    
}
.box_oder-grid .list-group-item .caption
{
    
}

.box_oder-grid .list-group-item:nth-of-type(odd)
{
    
}

.box_oder-grid .list-group-item:before, .box_oder-grid .list-group-item:after
{
    
}

.box_oder-grid .list-group-item img
{
    height: auto;
	width: 100%;
	max-height: 230px;
	max-width: 380px;
}
.box_oder-grid #box_img{
	width: 100%;
	height: 230px;
	vertical-align: middle;
	z-index: -1;
}
.box_oder-grid .list-group-item:after
{
    
}


</style>

<script>
function UI_list() {
  var myButtonClasses = document.getElementById("products").classList;
  var myBtnList = document.getElementById("list_btn").classList;
  var myBtnGrid = document.getElementById("grid-btn").classList;
	
  if (myButtonClasses.contains("box_oder-list")) {
  } else {
	myButtonClasses.remove("box_oder-grid");
    myButtonClasses.add("box_oder-list");
	myBtnGrid.remove("active");
	myBtnList.add("active");
  }
}
function UI_grid() {
  var myButtonClasses = document.getElementById("products").classList;
  var myBtnList = document.getElementById("list_btn").classList;
  var myBtnGrid = document.getElementById("grid-btn").classList;
	
  if (myButtonClasses.contains("box_oder-grid")) {
  } else {
	myButtonClasses.remove("box_oder-list");
    myButtonClasses.add("box_oder-grid");
	myBtnList.remove("active");
	myBtnGrid.add("active");
  }
}
</script>

</head>
 <body>
  
   <div class="container">
    <div class="well well-sm">
        <strong>Category Title</strong>
        <div class="btn-group">
            <a onclick="UI_list()" id="list_btn" class="btn btn-default btn-sm">
            	<span class="glyphicon glyphicon-th-list"></span>List</a> 
            <a onclick="UI_grid()" id="grid-btn" class="btn btn-default btn-sm">
               <span class="glyphicon glyphicon-th"></span>Grid</a>
        </div>
    </div>
    <div id="products" class="row list-group box_oder-grid">
       <?php $i=0; for($i;$i<5;$i++){ ?>
        <div id="" class="list-group-item col-xs-4 col-lg-4">
            <div class="thumbnail">
              	
<!--               		<img class="group list-group-image" src="images/bg_intro.jpg" alt="" />-->
					<div id="box_img" class="group list-group-image">
						<div style="display: inline;">
							<img class="" src="images/logo.png" alt="" />
						</div>
					</div>
				               
                <div class="caption box_caption">
                  <h4 class="group inner list-group-item-heading">Product title</h4>
                    <p class="group inner list-group-item-text">
                        Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                        sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                $21.000</p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="http://www.jquery2dotnet.com">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>



<script src="jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>